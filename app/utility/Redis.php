<?php

namespace App\Utility;

use Predis\Client;
use Predis\Response\Status;

class Redis
{
    private static string $host = '127.0.0.1';
    private static string $port = '6379';
    private static string $password = '';
    private static $client;

    private static function getClient(): Client
    {
        if (!self::$client) {
            self::$client = new Client([
                'scheme' => 'tcp',
                'host' => self::$host,
                'port' => self::$port,
                'password' => self::$password,
            ]);
        }

        return self::$client;
    }

    public static function set($key, $value, $share = true): Status
    {
        $client = self::getClient();
        return $client->set($key, $value);
    }

    public static function get($key): ?string
    {
        $client = self::getClient();
        return $client->get($key);
    }

    public static function del($key, $share = true): int
    {
        $client = self::getClient();
        return $client->del([$key]);
    }

    public static function expire($key, $seconds): int
    {
        $client = self::getClient();
        return $client->expire($key, $seconds);
    }

    public static function persist($key): int
    {
        $client = self::getClient();
        return $client->persist($key);
    }

    public static function exists($key): int
    {
        $client = self::getClient();
        return $client->exists($key);
    }

    public static function publish($channel, $message): int
    {
        $client = self::getClient();
        return $client->publish($channel, $message);
    }

    public static function subscribe(array $channels, $callback, $unset = false): void
    {
        $client = self::getClient();
        $pubSub = $client->pubSubLoop();

        $pubSub->subscribe(...$channels);

        foreach ($pubSub as $message) {
            if ($message->kind === 'message') {
                $callback($message->channel, $message->payload);
            }
        }

        if ($unset) unset($pubSub);
    }

    public function rPush($key, $value): int
    {
        $client = self::getClient();
        return $client->rpush($key, $value);
    }
}