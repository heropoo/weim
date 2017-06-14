<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/1
 * Time: 14:58
 */

$ip = '127.0.0.1';
$port = 8001;

$master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
    or die('socket_create failed:' . socket_strerror(socket_last_error()));

socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1)
    or die('socket_set_option failed:' . socket_strerror(socket_last_error()));

socket_bind($master, $ip, $port)
    or die('socket_bind failed' . socket_strerror(socket_last_error()) . PHP_EOL);

socket_listen($master, 2)
    or die('socket_listen failed' . socket_strerror(socket_last_error()) . PHP_EOL);

$sockets = [];
$sockets[] = $master;

echo("Master socket: " . $master . " Listening on $ip:$port\n");

$handshake = false;

while(true){
    //自动选择来消息的 socket 如果是握手 自动选择主机
    $write = null;
    $except = null;

    socket_select($sockets, $write, $except, null)
        or die('socket_select failed' . socket_strerror(socket_last_error()) . PHP_EOL);

    foreach ($sockets as $socket) {
        //连接主机的 client
        if ($socket == $master) {
            $client = socket_accept($master);
            if (!$client) {
                // debug
                echo "socket_accept failed" . socket_strerror(socket_last_error()) . PHP_EOL;
                continue;
            } else {
                //connect($client);
                array_push($sockets, $client);
                echo "connect client $client\n";
            }
        } else {
            $bytes = @socket_recv($socket, $buffer, 2048, 0);

            if($bytes == 0){
                continue;
            }else {
                if (!$handshake) {
                    // 如果没有握手，先握手回应
                    doHandShake($socket, $buffer);
                    echo "shakeHands\n";

                } else {

                    // 如果已经握手，直接接受数据，并处理
                    $buffer = decode($buffer);
                    echo $buffer;
                    //process($socket, $buffer);
                    //echo "send file\n";
                    send_msg($socket, $buffer);
                }
            }

        }
    }
}

function dohandshake($socket, $req)
{
    // 获取加密key
    $acceptKey = encry($req);
    $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "Sec-WebSocket-Accept: " . $acceptKey . "\r\n" .
        "\r\n";

    echo "dohandshake " . $upgrade . chr(0);
    // 写入socket
    socket_write($socket, $upgrade . chr(0), strlen($upgrade . chr(0)));
    // 标记握手已经成功，下次接受数据采用数据帧格式
    global $handshake;
    $handshake = true;
}


function encry($req)
{
    $key = getKey($req);
    $mask = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";

    return base64_encode(sha1($key . $mask, true));
}

function getKey($req)
{
    $key = null;
    if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $req, $match)) {
        $key = $match[1];
    }
    return $key;
}

// 解析数据帧
function decode($buffer)
{
    $len = $masks = $data = $decoded = null;
    $len = ord($buffer[1]) & 127;

    if ($len === 126) {
        $masks = substr($buffer, 4, 4);
        $data = substr($buffer, 8);
    } else if ($len === 127) {
        $masks = substr($buffer, 10, 4);
        $data = substr($buffer, 14);
    } else {
        $masks = substr($buffer, 2, 4);
        $data = substr($buffer, 6);
    }
    for ($index = 0; $index < strlen($data); $index++) {
        $decoded .= $data[$index] ^ $masks[$index % 4];
    }
    return $decoded;
}

// 返回帧信息处理
function frame($s)
{
    $a = str_split($s, 125);
    if (count($a) == 1) {
        return "\x81" . chr(strlen($a[0])) . $a[0];
    }
    $ns = "";
    foreach ($a as $o) {
        $ns .= "\x81" . chr(strlen($o)) . $o;
    }
    return $ns;
}

// 返回数据
function send_msg($client, $msg)
{
    $msg = frame($msg);
    socket_write($client, $msg, strlen($msg));
}