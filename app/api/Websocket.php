<?php

namespace App\Api;

use App\Models\Channel;
use App\Models\User;
use App\Utility\Redis;
use App\Utility\TelegramBot;
use App\Utility\TelegramWebApp;
use Random\RandomException;

class Websocket extends API
{
	/**
	 * @throws RandomException
	 */
	public function onMessage($data, $connection, &$clients = []): void
	{
		$data = $this->webSocket($data);
		if (!empty($data)) {
			$handler = new RequestHandler($data);
			switch ($data->type) {
				case 'auth':
					if (!TelegramWebApp::validatingData($data->data->initData)) {
						$connection->send(json_encode([
							'sc' => false,
							'type' => 'auth'
						]));
						return;
					} else {
						$user = $handler->authorizationRegistration();
						$clients[$connection->id] = [
							'connection' => $connection,
							'user' => $user
						];

						$wsConnections = @json_decode(Redis::get('wsConnections'), true);
						if (empty($wsConnections)) $wsConnections = [];
						$wsConnections[$connection->id] = [
							'connection' => $connection,
							'user' => (array)$user,
							'lastActivity' => time()
						];
						Redis::set('wsConnections', json_encode($wsConnections));

						$connection->send(json_encode([
							'sc' => true,
							'type' => 'auth',
							'token' => $user->token
						]));
					}
					break;
				case 'getPage':
					if (method_exists($handler::class, $method = 'page' . ucfirst($handler->data->page))) {
						$responseData = [];
						$user = (new User())->getOneObject(['token' => $handler->data->token]);
						if (empty($user)) {
							$connection->send(json_encode([
								'sc' => false,
								'error' => 'Not found'
							]));
							break;
						}
						$handler->$method($user, $responseData, $data);
					}

					$responseData = array_merge($responseData ?? [], [
						'sc' => true,
						'type' => 'page',
						'page' => $handler->data->page,
						'html' => $handler->getPage($responseData ?? [])
					]);

					$connection->send(json_encode($responseData));
					break;
				case 'pong':
					$wsConnections = @json_decode(Redis::get('wsConnections'), true);
					if (!empty($wsConnections[$data->key])) {
						$wsConnections[$data->key]['lastActivity'] = time();
					}
					Redis::set('wsConnections', json_encode($wsConnections));
					break;
				case 'indexCheckSubscribe':
					$user = (new User())->getOneObject(['token' => $handler->data->token]);
					$connection->send(json_encode([
						'sc' => true,
						'type' => 'indexCheckSubscribe',
						'subscribe' => $handler->checkSubscribe($user, $handler->data->drawId)
					]));
					break;
				case 'linkWallet':
					$user = (new User())->getOneObject(['token' => $handler->data->token]);
					$connection->send(json_encode([
						'sc' => true,
						'type' => 'linkWallet',
						'wallet' => $handler->linkWallet($user, $handler->data->wallet)
					]));
					break;
				case 'disconnectWallet':
					$user = (new User())->getOneObject(['token' => $handler->data->token]);
					$handler->disconnectWallet($user);
					$connection->send(json_encode([
						'sc' => true,
						'type' => 'disconnectWallet'
					]));
					break;
				case 'withdrawBalance':
					$user = (new User())->getOneObject(['token' => $handler->data->token]);
					$connection->send(json_encode(array_merge([
						'sc' => true,
						'type' => 'withdrawBalance'
					], $handler->withdrawBalance($user))));
					break;
				case 'checkDrawCompleted':
					$user = (new User())->getOneObject(['token' => $handler->data->token]);
					$result = $handler->checkDrawCompleted($user, $handler->data->drawId);
					if (!empty($result)) {
						$connection->send(json_encode([
							'sc' => true,
							'type' => 'drawCompleted',
							'html' => $result
						]));
					}
					break;
				default:
					$connection->send(json_encode([
						'sc' => false,
						'error' => 'Not found'
					]));
					break;
			}
		}
	}
}