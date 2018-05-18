<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/5/18
 * Time: 18:34
 */

require_once __DIR__.'/vendor/autoload.php';

use Workerman\Worker;

// Create a Websocket server
$ws_worker = new Worker("ws://0.0.0.0:8801");

// 4 processes
$ws_worker->count = 4;

// Emitted when new connection come
$ws_worker->onConnect = function($connection)
{
    var_dump($connection);
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data)
{
    // Send hello $data
    $connection->send('hello ' . $data);
};

// Emitted when connection closed
$ws_worker->onClose = function($connection)
{
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();