<?php
/**
 * php原生socket
 */

//$ip = '127.0.0.1';
//$port = 8001;
//
///**
// * +-------------------------------
// * @socket通信整个过程
// * +-------------------------------
// * @socket_create
// * @socket_bind
// * @socket_listen
// * @socket_accept
// * @socket_read
// * @socket_write
// * @socket_close
//+--------------------------------
// */
//
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('socket create failed:' . socket_strerror(socket_last_error()) . PHP_EOL);
//
//socket_bind($socket, $ip, $port) or die('socket bind failed' . socket_strerror(socket_last_error()) . PHP_EOL);
//
//socket_listen($socket, 4) or die('socket listen failed' . socket_strerror(socket_last_error()) . PHP_EOL);
//
////socket_set_nonblock($socket);
//
//echo "waiting for clients to connect\n";
//
//do {
//    $msgSock = socket_accept($socket) or die("socket_accept() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
//
//    $msg = '测试成功！' . PHP_EOL;
//
//    socket_write($msgSock, $msg, strlen($msg));
//
//    echo "测试成功了啊\n";
//
//    $buf = socket_read($msgSock, 8192);
//
//    $talkback = "收到的信息:$buf\n";
//
//    echo $talkback;
//
//    socket_close($msgSock);
//
//} while (1);


class WS {
    var $master;
    var $sockets = array();
    var $debug = false;
    var $handshake = false;

    function __construct($address, $port, $debug = false){
        $this->debug = $debug;
        $this->master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)     or die("socket_create() failed");
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)  or die("socket_option() failed");
        socket_bind($this->master, $address, $port)                    or die("socket_bind() failed");
        socket_listen($this->master,20)                                or die("socket_listen() failed");

        $this->sockets[] = $this->master;
        $this->say("Server Started : ".date('Y-m-d H:i:s'));
        $this->say("Listening on   : ".$address." port ".$port);
        $this->say("Master socket  : ".$this->master."\n");

        while(true){
            $socketArr = $this->sockets;
            $write = NULL;
            $except = NULL;
            socket_select($socketArr, $write, $except, NULL);  //自动选择来消息的socket 如果是握手 自动选择主机
            foreach ($socketArr as $socket){
                if ($socket == $this->master){  //主机
                    $client = socket_accept($this->master);
                    if ($client < 0){
                        $this->log("socket_accept() failed");
                        continue;
                    } else{
                        $this->connect($client);
                    }
                } else {
                    $this->log("^^^^");
                    $bytes = @socket_recv($socket,$buffer,2048,0);
                    $this->log("^^^^");
                    if ($bytes == 0){
                        $this->disConnect($socket);
                    }
                    else{
                        if (!$this->handshake){
                            $this->doHandShake($socket, $buffer);
                        }
                        else{
                            $buffer = $this->decode($buffer);
                            $this->send($socket, $buffer);
                        }
                    }
                }
            }
        }
    }

    function send($client, $msg){
        $this->log("> " . $msg);
        $msg = $this->frame($msg);
        socket_write($client, $msg, strlen($msg));
        $this->log("! " . strlen($msg));
    }
    function connect($socket){
        array_push($this->sockets, $socket);
        $this->say("\n" . $socket . " CONNECTED!");
        $this->say(date("Y-n-d H:i:s"));
    }
    function disConnect($socket){
        $index = array_search($socket, $this->sockets);
        socket_close($socket);
        $this->say($socket . " DISCONNECTED!");
        if ($index >= 0){
            array_splice($this->sockets, $index, 1);
        }
    }
    function doHandShake($socket, $buffer){
        $this->log("\nRequesting handshake...");
        $this->log($buffer);
        list($resource, $host, $origin, $key) = $this->getHeaders($buffer);
        $this->log("Handshaking...");
        $upgrade  = "HTTP/1.1 101 Switching Protocol\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept: " . $this->calcKey($key) . "\r\n\r\n";  //必须以两个回车结尾
        $this->log($upgrade);
        $sent = socket_write($socket, $upgrade, strlen($upgrade));
        $this->handshake=true;
        $this->log("Done handshaking...");
        return true;
    }

    function getHeaders($req){
        $r = $h = $o = $key = null;
        if (preg_match("/GET (.*) HTTP/"              ,$req,$match)) { $r = $match[1]; }
        if (preg_match("/Host: (.*)\r\n/"             ,$req,$match)) { $h = $match[1]; }
        if (preg_match("/Origin: (.*)\r\n/"           ,$req,$match)) { $o = $match[1]; }
        if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/",$req,$match)) { $key = $match[1]; }
        return array($r, $h, $o, $key);
    }

    function calcKey($key){
        //基于websocket version 13
        $accept = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        return $accept;
    }

    function decode($buffer) {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;

        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        }
        else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        }
        else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }

    function frame($s){
        $a = str_split($s, 125);
        if (count($a) == 1){
            return "\x81" . chr(strlen($a[0])) . $a[0];
        }
        $ns = "";
        foreach ($a as $o){
            $ns .= "\x81" . chr(strlen($o)) . $o;
        }
        return $ns;
    }


    function say($msg = ""){
        echo $msg . "\n";
    }
    function log($msg = ""){
        if ($this->debug){
            echo $msg . "\n";
        }
    }
}

$ws = new WS("127.0.0.1", 8001, true);

