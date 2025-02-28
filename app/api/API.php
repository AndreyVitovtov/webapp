<?php

namespace App\Api;

use App\Models\User;
use Random\RandomException;
use StdClass;

class API
{
	private $request = null;

	public function webSocket($data, $object = true)
	{
		if (is_object($data)) {
			$this->request = $data;
			return $data;
		}
		$data = ($object ? @json_decode($data) : $data);
		if (!is_object($data)) $this->request = new StdClass;
		else $this->request = $data;
		return $data;
	}

	public function POST($object = true)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			return $this->REQUEST($object);
		} else {
			return null;
		}
	}

	public function GET($object = true)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			return $this->REQUEST($object);
		} else {
			return null;
		}
	}

	public function REQUEST($object = true)
	{
		if (!empty($_REQUEST)) {
			if (is_string($_REQUEST)) {
				$this->request = ($object ? json_decode($_REQUEST) : new StdClass);
				return ($object ? $this->request : $_POST);
			} else {
				return ($object ? null : $_REQUEST);
			}
		} else {
			return null;
		}
	}

	public function existsProperties($properties, $data = new StdClass): bool
	{
		if (empty($data)) $data = $this->request;
		if (!is_object($data)) return false;
		foreach ($properties as $property) {
			if (!property_exists($data, $property)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @throws RandomException
	 */
	public function generateToken(): string
	{
		$bytes = random_bytes(32);
		$uniqueString = microtime(true) . bin2hex($bytes);
		return hash('sha256', $uniqueString);
	}

	public function getToken($data): string|null
	{
		if ($this->existsProperties(['token'])) {
			return $this->request->token;
		} else {
			return null;
		}
	}

	public function auth($token): User|null
	{
		$user = new User();
		return $user->getOneObject(['token' => $token]);
	}

	public function existsUser($data): User|null
	{
		if ($this->existsProperties(['id'], $data)) {
			$user = new User();
			$user = $user->getOneObject(['chat_id' => $data->id]);
			$user->username = $data->username ?? $user->username;
			$user->first_name = $data->first_name ?? $user->first_name;
			$user->last_name = $data->last_name ?? $user->last_name;
			$user->language_code = $data->language_code ?? $user->language_code;
			$user->photo_url = $data->photo_url ?? $user->photo_url;
			$user->update();
			return $user;
		} else {
			return null;
		}
	}

	/**
	 * @throws RandomException
	 */
	public function register($data, $referrerId = null): User
	{
		$user = new User([
			'chat_id' => $data->id,
			'username' => $data->username,
			'first_name' => $data->first_name,
			'last_name' => $data->last_name,
			'language_code' => $data->language_code,
			'photo_url' => $data->photo_url,
			'referrer_id' => $referrerId,
			'active' => 1
		]);
		$token = $this->generateToken();
		$user->token = $token;
		$user = $user->insert();
		return $user;
	}

	/**
	 * @throws RandomException
	 */
	public function updateToken(User $user, $token = null): User
	{
		$user->token = $token ?? $this->generateToken();
		$user->update();
		return $user;
	}
}