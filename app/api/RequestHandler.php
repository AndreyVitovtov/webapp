<?php

namespace App\Api;

use App\Models\Coefficients;
use App\Models\Draw;
use App\Models\User;
use App\Models\Winner;
use Random\RandomException;
use stdClass;

class RequestHandler extends API
{
    public mixed $data;
    public array $startParams;

    public function __construct($data)
    {
        $this->data = $this->webSocket($data);

        $startParams = explode('_', $this->data->params);
        $this->startParams = [];
        foreach ($startParams as $param) {
            $param = explode('-', $param);
            $this->startParams[$param[0]] = $param[1];
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
                $userReferrer = $referrer->getOneObject(['chat_id' => $referrerChatId]);
                $referrerId = $userReferrer->id ?? null;
                $user = $this->register($this->data->data->user, $referrerId);
                $userId = $user->id;
                if (!empty($userId)) {
                    $this->addCoefficient($user);
                    $this->updateCoefficients($user);
                }
            }
        }
        return $user ?? null;
    }

    public function getPage($data = []): string
    {
        $data = array_merge((array)$this->data, $data);
        $page = $this->data->page;
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
        $params = (!empty($drawHash) ? ['hash' => $drawHash] : [
            'active' => 1,
            'status' => 'IN PROGRESS'
        ]);
        return (new Draw())->getOneObject($params, 'AND', 'date');
    }

    public function getWinners(?Draw $activeDraw): array
    {
        return (new Winner)->query("
            SELECT *
            FROM `winners` w,
                 `users` u
            WHERE w.`user_id` = u.`id`
            AND w.`draw_id` = :drawId
        ", [
            'drawId' => $activeDraw->id ?? 0
        ], true);
    }
}