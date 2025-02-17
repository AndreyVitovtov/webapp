<?php

namespace App\Api;

use App\Models\Coefficients;
use App\Models\User;
use Random\RandomException;
use stdClass;

class RequestHandler extends API
{
	public mixed $data;

	public function __construct($data)
	{
		$this->data = $this->webSocket($data);
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
				return $this->updateToken($user);
			} else {
				$referrerChatId = $this->data->data->referrer ?? null;
				$referrer = new User();
				$userReferrer = $referrer->getOneObject(['chat_id' => $referrerChatId]);
				$referrerId = $userReferrer->id ?? null;
				$user = $this->register($this->data->data->user, $referrerId);
				$userId = $user->id;
				if (!empty($userId) && !empty($referrerId)) {
					$this->updateCoefficients($user, $eventId = 1, $referrerId);
				}
			}
		}
		return $user ?? null;
	}

	public function getPage(): string
	{
		$page = $this->data->page;
		if (!empty($page)) {
			return html('Webapp/' . $page . '.php');
		} else {
			return 'No page found';
		}
	}

	private function updateCoefficients()
	{

	}

	private function updateCoefficient(User $user, $eventId, $referrerId = null, $coefficient = null, $deep = 1): void
	{
		$coefficients = (new Coefficients())->getOneObject(['user_id' => $user->id, 'event_id' => $eventId]);
		$coefficientsId = $coefficients->id ?? null;
		if (!empty($coefficientsId)) {
			$coefficients->user_id = $user->id;
			$coefficients->event_id = $eventId;
			$coefficients->coefficient = ($coefficient ?? settings('coefficient'));
			$coefficients->coefficient_admin = 0;
			$coefficients->insert();
		} else {
			$coefficients->find($coefficientsId);
			$coefficients->coefficient = ($coefficients->coefficient + ($coefficient ?? 0));
			$coefficients->update();
		}

		if (!empty($referrerId)) {
			$user = new User();
			$user->find($referrerId);
			$this->updateCoefficient($user, $eventId, $user->referrer_id, $coefficients->coefficient + settings('coefficient'));
		}
	}

	private function addCoefficient()
	{

	}
}