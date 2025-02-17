<?php

namespace App\Controllers;

use App\Models\BotMessages;
use App\Models\Channel;
use App\Models\Draw;
use App\Models\User;
use App\Utility\TelegramBot;

class Bot extends Controller
{
	private TelegramBot $telegram;
	/**
	 * @var array|string[]
	 */
	private array $channels;

	public function __construct()
	{
        $activeDraw = (new Draw())->getOneObject(['active' => 1]);
		$this->telegram = new TelegramBot(TELEGRAM_TOKEN);
		$channel = new Channel();
		$channels = [];
		foreach ($channel->getObjects(['draw_id' => ($activeDraw->id ?? 0)]) as $ch) {
			$lang = $ch->language;
			if (!isset($channels[$lang])) $channels[$lang] = [];
			$channels[$lang][] = [
				'title' => $ch->title,
				'id' => $ch->chat_id,
				'url' => $ch->url
			];
		}
		$this->channels = $channels;
	}

	public function index(): void
	{
		$data = $this->telegram->getRequest();
		file_put_contents(data('logs/bot.log'), print_r($data, true));

		$this->requestHandler();
	}

	private function requestHandler(): void
	{
		switch ($this->telegram->getMessage()) {
			case in_array(trim($this->telegram->getMessage() ?? ''), [
				'start',
				'Start',
				'START',
				'/start',
				'/Start',
				'/START',
				'старт',
				'СТАРТ']):
				$user = $this->register();
				$this->sendMessage(__('greetings', [], $this->getLanguageCode()));
				$this->telegram->sendChatAction($user->chat_id);
				extract($this->getResultCheckSubscribeToChannel());
				$result = $this->sendMessage(__(($noSubscribe ?? false) ? 'no subscribe to channels' : 'there are channel subscriptions', [], $this->getLanguageCode()), $buttons);
				$this->updateBotMessage($user->chat_id, $result);
				break;
			case 'checkSubscribeToChannel':
				$this->telegram->sendChatAction($this->telegram->getChat());
				extract($this->getResultCheckSubscribeToChannel());
				$botMessage = new BotMessages();
				$botMessage = $botMessage->getOneObject(['chat_id' => $this->telegram->getChat()]);
				$messageId = $botMessage->message_id ?? null;
				if ($messageId) $this->telegram->editMessageText($this->telegram->getChat(), $messageId, __(($noSubscribe ?? false) ? 'no subscribe to channels' : 'there are channel subscriptions'), $buttons);
				break;
			default:
				$this->sendMessage(__('unknown command', [], $this->getLanguageCode()));
				break;
		}
	}

	private function register(): User
	{
		$user = (new User())->getOneObject(['chat_id' => $this->telegram->getChat()]);
		if (empty($user)) {
			$request = $this->telegram->getRequest();
			$user = new User();
			$user->chat_id = $request->message->from->id;
			$user->username = $request->message->from->username ?? '';
			$user->first_name = $request->message->from->first_name ?? '';
			$user->last_name = $request->message->from->first_name ?? '';
			$user->language_code = $request->message->from->first_name ?? '';
			$user->photo_url = $request->message->from->photo_url ?? '';
			$user->insert();
			return $user;
		} else return $user;
	}

	private function getLanguageCode(): string
	{
		$request = $this->telegram->getRequest();
		if (!in_array($request->message->from->language_code, array_keys(LANGUAGES))) return DEFAULT_LANG;
		return $request->message->from->language_code ?? DEFAULT_LANG;
	}

	private function sendMessage(string $message, ?array $buttons = null, $parseMode = 'HTML',
	                                    $disableWebPagePreview = true): string
	{
		return $this->telegram->sendMessage($this->telegram->getChat(), $message, $buttons, $parseMode, $disableWebPagePreview);
	}

	private function checkSubscribeToChannel($chatId, $channelId): bool
	{
		$result = @json_decode($this->telegram->getChatMember($chatId, $channelId));
		return $result->result->status !== 'left';
	}

	private function getIdSendMessage($result)
	{
		return $result->result->message_id;
	}

	private function updateBotMessage($chatId, $result): void
	{
		$result = @json_decode($result);
		$messageId = $this->getIdSendMessage($result);
		$botMessages = (new BotMessages())->getOneObject(['chat_id' => $chatId]);
		$botMessagesId = $botMessages->id;
		if (!empty($botMessagesId)) {
			$botMessages->message_id = $messageId;
			$botMessages->update();
		} else {
			$botMessages = new BotMessages();
			$botMessages->chat_id = $chatId;
			$botMessages->message_id = $messageId;
			$botMessages->insert();
		}
	}

	private function getResultCheckSubscribeToChannel(): array
	{
		$user = (new User())->getOneObject(['chat_id' => $this->telegram->getChat()]);
		$subscribeToChannel = [];
		foreach ($this->channels[$this->getLanguageCode()] ?? $this->channels[DEFAULT_LANG] as $channel) {
			$resultSubscribeToChannel = $this->checkSubscribeToChannel($user->chat_id, $channel['id']);
			$subscribeToChannel[] = array_merge($channel, ['subscribe' => $resultSubscribeToChannel]);
			if (!$resultSubscribeToChannel) $noSubscribe = true;
		}

		$buttons = [
			'inline_keyboard' => array_map(function ($v) {
				return [['text' => ($v['subscribe'] ? '✅' : '⛔') . ' ' . $v['title'], 'url' => $v['url']]];
			}, $subscribeToChannel)
		];

		if ($noSubscribe ?? false) {
			$buttons['inline_keyboard'] = array_merge($buttons['inline_keyboard'], [
				[['text' => __('check subscribe', [], $this->getLanguageCode()), 'callback_data' => 'checkSubscribeToChannel']]
			]);
		} else {
			$buttons['inline_keyboard'] = array_merge($buttons['inline_keyboard'], [
				[['text' => __('invite', [], $this->getLanguageCode()), 'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_APP_LINK . '?startapp=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], $this->getLanguageCode()))]]
			]);
		}

		return [
			'noSubscribe' => $noSubscribe ?? false,
			'buttons' => $buttons
		];
	}
}