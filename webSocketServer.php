<?php

use Workerman\Worker;

require_once 'vendor/autoload.php';

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
    $clients[$connection->id] = $connection;
    (new \App\Actions\WebSocketActions())->onMessage($connection, $data, $clients);
};

$wsWorker->onClose = function ($connection) use (&$clients) {
    unset($clients[$connection->id]);
    echo "Connection close";
};

Worker::runAll();