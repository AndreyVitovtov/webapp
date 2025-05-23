<?php

namespace App\Api;

use App\Controllers\Withdrawals;
use App\Models\Airdrop;
use App\Models\Balance;
use App\Models\Channel;
use App\Models\Coefficients;
use App\Models\Draw;
use App\Models\Participants;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Winner;
use App\Utility\Database;
use App\Utility\Redis;
use App\Utility\TelegramBot;
use Random\RandomException;
use stdClass;

class RequestHandler extends API
{
    public mixed $data;
    public array $startParams;

    public function __construct($data)
    {
        $this->data = $this->webSocket($data);

        $startParams = explode('_', ($this->data->params ?? ''));
        $this->startParams = [];
        foreach ($startParams as $param) {
            $param = explode('-', $param);
            $this->startParams[$param[0]] = ($param[1] ?? null);
        }
    }

    /**
     * @throws RandomException
     */
    public function authorizationRegistration(): ?\App\Models\User
    {
        if (!empty($this->data)) {
            $user = $this->existsUser($this->data->data->user);
            $userId = $user->id;
            if (!empty($userId)) {
                $this->addCoefficient($user);
                return $this->updateToken($user);
            } else {
                $referrerChatId = $this->startParams['ref'] ?? null;
                $referrer = new User();
                if (!empty($referrerChatId)) {
                    $userReferrer = $referrer->getOneObject(['chat_id' => $referrerChatId]);
                    $referrerId = $userReferrer->id ?? null;
                }
                $user = $this->register($this->data->data->user, $referrerId ?? null);
                $userId = $user->id;
                if (!empty($userId)) {
                    $this->addCoefficient($user);
                    $this->updateCoefficients($user);
                }
            }
        }
        return $user ?? null;
    }

    public function getPage($data = [], $page = null): string
    {
        $data = array_merge((array)$this->data, $data);
        if (empty($page)) $page = $this->data->page;
        if (!empty($page)) {
            return html('Webapp/' . $page . '.php', $data);
        } else {
            return 'No page found';
        }
    }

    private function updateCoefficients(User $user): void
    {
        $referrerId = $user->referrer_id;
        if (!empty($referrerId)) {
            $coefficients = (new Coefficients())->getOneObject(['user_id' => $referrerId]);
            $newCoefficient = floatval($coefficients->coefficient) + settings('coefficient_first_level');
            $coefficients->coefficient = $newCoefficient;
            $coefficients->update();
        }

        $referrerLevel1 = (new User())->getOneObject(['id' => $referrerId]);
        $referrerIdLevel2 = $referrerLevel1->referrer_id;
        if (!empty($referrerIdLevel2)) {
            $coefficients = (new Coefficients())->getOneObject(['user_id' => $referrerIdLevel2]);
            $newCoefficient = floatval($coefficients->coefficient) + settings('coefficient_second_level');
            $coefficients->coefficient = $newCoefficient;
            $coefficients->update();
        }
    }

    private function addCoefficient(User $user)
    {
        $coefficients = (new Coefficients())->getOneObject(['user_id' => $user->id]);
        $coefficientsId = $coefficients->id ?? null;
        if (!empty($coefficientsId)) return $coefficients->coefficient;
        else {
            $coefficients = new Coefficients();
            $coefficients->user_id = $user->id;
            $coefficients->coefficient = settings('coefficient');
            $coefficients->coefficient_admin = 0;
            $coefficients->insert();
            return $coefficients->coefficient;
        }
    }

    public function getLanguageCode(User $user): string
    {
        if (!in_array($user->language_code, array_keys(LANGUAGES))) return DEFAULT_LANG;
        return $user->language_code ?? DEFAULT_LANG;
    }

    public function getActiveDraw($drawHash = null): ?Draw
    {
        $params = (!empty($drawHash) ? [
            'hash' => $drawHash,
            'active' => 1
        ] : [
            'active' => 1,
            'status' => 'IN PROGRESS'
        ]);
        $draw = (new Draw())->getOneObject($params, 'AND', 'date');

        if (!empty($drawHash) && empty($draw)) {
            $draw = (new Draw())->getOneObject(['active' => 1], 'AND', 'date');
        } elseif (empty($drawHash) && empty($draw)) {
            $draw = (new Draw())->getOneObject(['active' => 1, 'status' => 'COMPLETED'], 'AND', 'date', 'DESC');
        }
        return $draw;
    }

    public function getWinners(?Draw $activeDraw, User $user): array
    {
        $winners = (new Winner)->query("
            SELECT *
            FROM `winners` w,
                 `users` u
            WHERE w.`user_id` = u.`id`
            AND w.`draw_id` = :drawId
        ", [
            'drawId' => $activeDraw->id ?? 0
        ], true);

        $winner = array_filter($winners, fn($w) => $w['user_id'] === $user->id);
        $otherWinners = array_filter($winners, fn($w) => $w['user_id'] !== $user->id);
        return array_merge($winner, $otherWinners);
    }

    public function pageIndex(User $user, array &$data): void
    {
        $data['menu'] = $this->getPage([
            'languageCode' => $this->getLanguageCode($user)
        ], 'menu');
        $data['user'] = $user;
        $data['mainButton'] = [
            'text' => __('invite participants', [], DEFAULT_LANG),
            'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_LINK . '?start=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], DEFAULT_LANG))
        ];
        $drawHash = $this->startParams['draw'] ?? null;
        $activeDraw = $this->getActiveDraw($drawHash);
        $drawId = $activeDraw->id ?? 0;

        if (!empty($drawId)) {
            $data['noActiveDraw'] = (empty($drawHash) && $activeDraw->status == 'COMPLETED');

            // Add participant
            if ($activeDraw->status == 'IN PROGRESS') {
                $participant = new Participants();
                if (empty($participant->getOne([
                    'user_id' => $user->id,
                    'draw_id' => $drawId
                ]))) {
                    $participant->user_id = $user->id;
                    $participant->draw_id = $drawId;
                    $participant->insert();
                }
            }

            $activeDraw->title = json_decode($activeDraw->title);
            $activeDraw->description = json_decode($activeDraw->description);
            $data['draw'] = [
                'id' => $drawId,
                'title' => $activeDraw->title->{$this->getLanguageCode($user)},
                'description' => $activeDraw->description->{$this->getLanguageCode($user)},
                'conditions' => $activeDraw->conditions->{$this->getLanguageCode($user)} ?? '',
                'prize' => $activeDraw->prize,
                'status' => $activeDraw->status,
                'sponsor_title' => $activeDraw->sponsor_title,
                'sponsor_url' => $activeDraw->sponsor_url,
                'winners' => $activeDraw->winners,
                'date' => gmdate('Y-m-d\TH:i:s\Z', strtotime($activeDraw->date))
            ];
            $status = $activeDraw->status;
            if ($status == 'COMPLETED') {
                $data['participants'] = (new Participants())->query("
					SELECT COUNT(*) as number
					FROM `participants` p,
					     `users` u
					WHERE p.`user_id` = u.`id`
					AND p.`draw_id` = :drawId
				", [
                    'drawId' => $drawId
                ], true)[0]['number'] ?? 0;
                $data['winners'] = $this->getWinners($activeDraw, $user);
            } else {
                $coefficients = (new Coefficients())->get();
                $coefficients = array_combine(array_column($coefficients, 'user_id'), $coefficients);
                $participants = array_map(function ($user) use ($coefficients) {
                    $user = (object)$user;
                    $user->coefficient = (!empty($coefficients[$user->id]['coefficient_admin']) ? $coefficients[$user->id]['coefficient_admin'] : $coefficients[$user->id]['coefficient']) ?? 0;
                    $username = $user->username;
                    if (empty($username)) $user->username = $user->first_name . ' ' . $user->last_name;
                    return $user;
                }, (new User())->query("
				SELECT u.* 
				FROM `users` u,
				     `participants` p
				WHERE u.`id` = p.`user_id`
				AND p.`draw_id` = :drawId
				AND u.`active` = 1
				", [
                    'drawId' => $drawId
                ], true));

                $participant = array_filter($participants, fn($p) => $p->id === $user->id);
                $otherParticipants = array_filter($participants, fn($p) => $p->id !== $user->id);
                $participants = array_merge($participant, $otherParticipants);
                $data['participantsNumber'] = count($participants);
                $data['participants'] = array_slice($participants, 0, settings('participants_number'));
                $data['participantsOther'] = array_slice($participants, settings('participants_number'), 3);
                $participantsOtherNumber = $data['participantsNumber'] - settings('participants_number');
                $data['participantsOtherNumber'] = ($participantsOtherNumber < 0 ? 0 : $participantsOtherNumber);

                $data['channels'] = (new Channel())->getObjects([
                    'draw_id' => $drawId,
                    'language' => $this->getLanguageCode($user)
                ]);
                $telegram = new TelegramBot(TELEGRAM_TOKEN);
                foreach ($data['channels'] as $key => $channel) {
                    $chatMember = @json_decode($telegram->getChatMember(trim($user->chat_id), trim($channel->chat_id)));
                    $data['channels'][$key]->subscribe = $chatMember->result->status !== 'left';
                }
                $data['weChooseWinnersText'] = __('we choose winners', ['winners' => $data['draw']['winners']], DEFAULT_LANG);
                $data['loadUrl'] = assets('images/load.gif');
                $data['participate'] = [
                    'yes' => __('you are participating', [], DEFAULT_LANG),
                    'no' => __('you are not participating', [], DEFAULT_LANG)
                ];
            }
        }
    }

    public function pageShare(User $user, array &$data): void
    {
        $data['user'] = $user;
        $data['coefficient'] = (new Coefficients())->getOneObject(['user_id' => $user->id])->coefficient ?? settings('coefficient');
        $data['earned'] = (new Winner())->query("
			SELECT SUM(w.`prize_referrer`) as earned
			FROM `users` u,
			     `winners` w
			WHERE w.`user_id` = u.`id`
			AND u.`referrer_id` = :userId
		", [
            'userId' => $user->id
        ], true)[0]['earned'] ?? 0;

        $data['mainButton'] = [
            'text' => __('invite participants', [], DEFAULT_LANG),
            'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_LINK . '?start=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], DEFAULT_LANG))
        ];
        $data['referrals'] = (new User())->getObjects([
            'referrer_id' => $user->id
        ]);
        $data['popupText'] = __('link copied', [], DEFAULT_LANG);
        $data['url'] = BOT_LINK . '?start=' . $user->chat_id;
    }

    public function pageWallet(User $user, array &$data): void
    {
        $data['user'] = $user;
        $data['wallet'] = (new Wallet())->getOneObject(['user_id' => $user->id]);
        $balance = (new Balance())->getOneObject(['user_id' => $user->id]);
        $data['balance'] = ($balance->balance ?? '0');
        $data['warningDisconnectWallet'] = __('warning disconnect wallet', [], DEFAULT_LANG);
    }

    public function checkSubscribe($user, $drawId): array
    {
        $telegram = new TelegramBot(TELEGRAM_TOKEN);
        $channels = (new Channel())->getObjects([
            'draw_id' => $drawId,
            'language' => $this->getLanguageCode($user)
        ]);
        $subscribe = true;
        $subscribeChannel = [];
        foreach ($channels as $channel) {
            $chatMember = @json_decode($telegram->getChatMember(trim($user->chat_id), trim($channel->chat_id)));
            if ($chatMember->result->status == 'left') {
                $subscribeChannel[$channel->id] = false;
                $subscribe = false;
            } else $subscribeChannel[$channel->id] = true;
        }
        return [
            'subscribe' => $subscribe,
            'subscribeChannels' => $subscribeChannel,
            'text' => __($subscribe ? 'invite participants' : 'check subscribe app', [], DEFAULT_LANG),
            'mainButton' => [
                'text' => __('invite participants', [], DEFAULT_LANG),
                'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_LINK . '?start=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], DEFAULT_LANG))
            ]
        ];
    }

    public function linkWallet(User $user, $walletInfo): array
    {
        $wallet = (new Wallet())->getOneObject(['user_id' => $user->id]);
        $walletId = $wallet->id ?? null;

        if (empty($walletId)) {
            $wallet = new Wallet();
        }

        $wallet->user_id = $user->id;
        $wallet->json = @json_encode($walletInfo);
        $wallet->address = $walletInfo->account->address;
        if (empty($walletId)) {
            $wallet->insert();
        } else {
            $wallet->update();
        }
        return [
            'src' => assets('images/wallet/check.svg'),
            'text' => __('wallet connected', [], DEFAULT_LANG)
        ];
    }

    function pageAirdrops(User $user, array &$responseData, $data): void
    {
        $responseData['user'] = $user;
        $responseData['airdrops'] = (new Airdrop())->get(['active' => 1]);
    }

    function pageAirdrop(User $user, array &$responseData, $data): void
    {
        $responseData['user'] = $user;
        $responseData['id'] = $data->id;
        $responseData['airdrop'] = (new Airdrop())->getOneObject(['id' => $data->id]);
        $responseData['airdrop']->description = (json_decode($responseData['airdrop']->description))->{$this->getLanguageCode($user)} ?? '';
        $responseData['date'] = gmdate('Y-m-d\TH:i:s\Z', strtotime($responseData['airdrop']->date));
        $responseData['mainButton'] = [
            'text' => __('invite participants', [], DEFAULT_LANG),
            'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_LINK . '?start=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], DEFAULT_LANG))
        ];
    }

    function checkDrawCompleted(User $user, $drawId): ?string
    {
        $drawCompleted = @json_decode(Redis::get('drawCompleted'), true);
        if (!empty($drawCompleted[$drawId] ?? [])) {
            return html('Webapp/winners.php', [
                'user' => $user,
                'winners' => $drawCompleted[$drawId],
            ]);
        } else {
            return null;
        }
    }

    public function disconnectWallet(User $user): void
    {
        $wallet = (new Wallet())->getOneObject(['user_id' => $user->id]);
        if ($wallet) $wallet->delete();
    }

    public function withdrawBalance(User $user): array
    {
        $balance = (new Balance())->getOneObject(['user_id' => $user->id]);
        $userBalance = $balance->balance ?? 0;
        $minimumBalance = settings('min_balance_withdrawals');
        if (empty($balance) || $userBalance < $minimumBalance) {
            return [
                'status' => false,
                'message' => __('minimum balance for withdrawal', [
                    'balance' => $minimumBalance
                ], DEFAULT_LANG)
            ];
        } else {
            try {
                $db = Database::instance()->getDbh();
                $db->beginTransaction();

                $wallet = (new Wallet())->getOneObject(['user_id' => $user->id]);
                $address = $wallet->address ?? null;
                if (empty($address)) return [
                    'status' => false,
                    'message' => __('wallet not connected', [], DEFAULT_LANG)
                ];

                $withdrawals = new \App\Models\Withdrawals();
                $withdrawals->user_id = $user->id;
                $withdrawals->balance = $userBalance;
                $withdrawals->wallet = $address;
                $withdrawals->insert();

                $balance->balance = 0;
                $balance->update();

                $db->commit();
                return [
                    'status' => true,
                    'message' => __('balance withdrawal request successfully created', [], DEFAULT_LANG)
                ];

            } catch (\Exception $e) {
                $db->rollBack();
                return ['status' => false, 'message' => __('error withdrawal', [], DEFAULT_LANG)];
            }
        }
    }
}