<?php

namespace App\Controllers;

use App\Models\BotMessages;
use App\Models\Channel;
use App\Models\Coefficients;
use App\Models\Draw;
use App\Models\User;
use App\Utility\TelegramBot;

class UpdateCoefficients
{
	private TelegramBot $telegram;

	public function __construct()
	{
		$this->telegram = new TelegramBot(TELEGRAM_TOKEN);
	}

	public function index($drawId = null): void
	{
		set_time_limit(0);

		if (!empty($drawId) && !is_object($drawId)) {
			$users = array_map(function ($user) {
				return (new User($user));
			}, (new User())->query("
				SELECT *
				FROM `users` u,
				     `participants` p
				WHERE u.`id` = p.`user_id`
				AND p.`draw_id` = :drawId
			", ['drawId' => $drawId], true));
		} else {
			$users = (new User())->getObjects();
		}

		foreach ($users as $user) {
			$channels = $this->getChannelsWithDraw($user, $drawId);
			if (!empty($channels)) {
				$active = 1;
				$subscribeChannels = [];
				foreach ($channels as $key => $channel) {
					$subscribeChannels[$key] = [
						'title' => $channel->title,
						'url' => $channel->url,
						'subscribe' => true
					];
					if (!$this->checkSubscribe($user, $channel)) {
						$active = 0;
						$subscribeChannels[$key]['subscribe'] = false;
					}
				}
				$buttons = $this->getButtons($user, $subscribeChannels);
				if (!$active) {
					$language = (in_array($user->language_code, array_keys(LANGUAGES)) ? $user->language_code : DEFAULT_LANG);
					$result = $this->telegram->sendMessage($user->chat_id, __('does not participate in the drawing', [], $language), $buttons);
					$this->updateBotMessage($user, $result);
				}
				$this->updateCoefficient($user, $active);
				$user->active = $active;
				$user->update();
			}
			usleep(50000);
		}
	}

	private
	function checkSubscribe(User $user, Channel $channel): bool
	{
		$result = @json_decode($this->telegram->getChatMember($user->chat_id, $channel->chat_id));
		return $result->result->status ?? 'right' !== 'left';
	}

	private
	function getActiveDraw(): ?Draw
	{
		$draw = (new Draw())->getOneObject([
			'active' => 1,
			'status' => 'IN PROGRESS'
		]);
		$drawId = $draw->id;
		return (!empty($drawId) ? $draw : null);
	}

	private
	function getChannelsWithDraw(User $user, $drawId = null): array
	{
		if (!empty($drawId)) {
			$activeDraw = (new Draw())->getOneObject(['id' => $drawId]);
		} else {
			$activeDraw = $this->getActiveDraw();
		}
		if (empty($activeDraw)) return [];
		if (!in_array($user->language_code, array_keys(LANGUAGES))) $language = DEFAULT_LANG;
		return (new Channel())->getObjects([
			'draw_id' => $activeDraw->id,
			'language' => ($language ?? $user->language_code)
		]);
	}

	public function updateCoefficient(User $user, $subscribeNow): void
	{
		$subscribeEarly = $user->active;
		if ($subscribeEarly == $subscribeNow) return;
		$referrerId = $user->referrer_id;
		if (!empty($referrerId)) {
			$change = (!$subscribeEarly && $subscribeNow ? 1 : ($subscribeEarly && !$subscribeNow ? -1 : 0));
			$referrerLevel1 = (new User())->getOneObject(['id' => $referrerId]);
			$referrerLevel1Id = $referrerLevel1->id;
			if (!empty($referrerLevel1Id)) {
				$coefficientReferrerLevel1 = (new Coefficients())->getOneObject(['user_id' => $referrerLevel1Id]);
				$newCoefficientReferrerLevel1 = floatval($coefficientReferrerLevel1->coefficient) + ($change * settings('coefficient_first_level'));
				$coefficientReferrerLevel1->coefficient = $newCoefficientReferrerLevel1;
				$coefficientReferrerLevel1->update();

				$referrerLevel2Id = $referrerLevel1->referrer_id;
				if (!empty($referrerLevel2Id)) {
					$coefficientReferrerLevel2 = (new Coefficients())->getOneObject(['user_id' => $referrerLevel2Id]);
					$newCoefficientReferrerLevel2 = floatval($coefficientReferrerLevel2->coefficient) + ($change * settings('coefficient_second_level'));
					$coefficientReferrerLevel2->coefficient = $newCoefficientReferrerLevel2;
					$coefficientReferrerLevel2->update();
				}
			}
		}
	}

	private function getButtons(User $user, array $subscribeChannels): array
	{
		$buttons = [
			'inline_keyboard' => array_map(function ($v) {
				return [['text' => ($v['subscribe'] ? '✅' : '⛔') . ' ' . $v['title'], 'url' => $v['url']]];
			}, $subscribeChannels)
		];

		$language = (in_array($user->language_code, array_keys(LANGUAGES)) ? $user->language_code : DEFAULT_LANG);

		$buttons['inline_keyboard'] = array_merge($buttons['inline_keyboard'], [
			[['text' => __('check subscribe', [], $language), 'callback_data' => 'checkSubscribeToChannel']]
		]);
		return $buttons;
	}

	private function getIdSendMessage($result)
	{
		return $result->result->message_id;
	}

	private function updateBotMessage(User $user, $result): void
	{
		$result = @json_decode($result);
		$messageId = $this->getIdSendMessage($result);
		$botMessages = (new BotMessages())->getOneObject(['chat_id' => $user->chat_id]);
		$botMessagesId = $botMessages->id;
		if (!empty($botMessagesId)) {
			$botMessages->message_id = $messageId;
			$botMessages->update();
		} else {
			$botMessages = new BotMessages();
			$botMessages->chat_id = $user->chat_id;
			$botMessages->message_id = $messageId;
			$botMessages->insert();
		}
	}
}