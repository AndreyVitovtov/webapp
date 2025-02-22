<?php

namespace App\Api;

use App\Models\Coefficients;
use App\Models\Draw;
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
                $this->addCoefficient($user);
                return $this->updateToken($user);
            } else {
                $referrerChatId = $this->data->data->referrer ?? null;
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

    public function getPage(): string
    {
        $page = $this->data->page;
        if (!empty($page)) {
            return html('Webapp/' . $page . '.php', json_decode(json_encode($this->data), true));
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

    public function getActiveDraw()
    {
        return (new Draw())->getOneObject(['active' => 1]);
    }
}