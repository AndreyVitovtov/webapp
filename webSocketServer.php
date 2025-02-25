<?php

use App\Utility\Redis;
use Workerman\Timer;
use Workerman\Worker;

require_once 'vendor/autoload.php';

const PING_INTERVAL_SECONDS = 30;
const TIME_LIFE_CONNECTION_SECONDS = 60;

$wsWorker = new Worker(WEBSOCKET, [
    'ssl' => [
        'local_cert' => WEBSOCKET_LOCAL_CERT,
        'local_pk' => WEBSOCKET_PRIVATE_KEY,
        'verify_peer' => false,
    ]
]);
$wsWorker->transport = 'ssl';
$wsWorker->count = 4;

$clients = [];

$wsWorker->onConnect = function ($connection) {
    echo "New connect";
};

$wsWorker->onMessage = function ($connection, $data) use ($wsWorker, &$clients) {
    try {
        (new App\Api\Websocket())->onMessage($data, $connection, $clients);
    } catch (\Throwable $th) {
        $connection->send(json_encode([
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'message' => $th->getMessage()
        ]));
    }
};

$wsWorker->onClose = function ($connection) use (&$clients) {
    $wsConnections = @json_decode(Redis::get('wsConnections'), true);
    if (!empty($wsConnections)) {
        foreach ($wsConnections as $key => $value) {
            if ($value['connection']->id == $connection->id) {
                unset($wsConnections[$key]);
                break;
            }
        }
        Redis::set('wsConnections', json_encode($wsConnections));
    }
    unset($clients[$connection->id]);
    echo "Connection close";
};

$wsWorker->onWorkerStart = function () use ($wsWorker) {
    Timer::add(PING_INTERVAL_SECONDS, function () use ($wsWorker) {
        foreach ($wsWorker->connections as $connection) {
            $connection->send(json_encode([
                'sc' => true,
                'type' => 'ping',
                'key' => $connection->id
            ]));
        }

        $wsConnections = @json_decode(Redis::get('wsConnections'), true) ?? [];
        foreach ($wsConnections as $key => $connection) {
            if (time() - $connection['lastActivity'] >= TIME_LIFE_CONNECTION_SECONDS) {
                unset($wsConnections[$key]);
                Redis::set('wsConnections', json_encode($wsConnections));
            }
        }
    });
};

Worker::runAll();