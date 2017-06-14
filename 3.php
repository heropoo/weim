<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/1
 * Time: 17:21
 */

$ws = new swoole_websocket_server('127.0.0.1', 8001);

$ws->on('open', function(swoole_websocket_server $ws, swoole_http_request $request){
    echo "server: handshake success with fd{$request->fd}\n";
});

$ws->on('message', function(swoole_websocket_server $ws, swoole_websocket_frame $frame){
    var_dump($frame);
    echo "receive from {$frame->fd}:{$frame->data}, opcode:{$frame->opcode}, fin:{$frame->finish}\n";
    $ws->push($frame->fd, $frame->data);    //原样返回
});

$ws->on('close', function(swoole_websocket_server $ws, $fd){
    echo "client {$fd} closed\n";
});

$ws->start();


