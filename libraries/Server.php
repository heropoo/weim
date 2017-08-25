<?php

/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/16
 * Time: 13:59
 */
class Server
{
    public static function start(){
        (new static)->showUsage();
    }

    public function showUsage(){

        $argv = $_SERVER['argv'];


        var_dump($argv);

        $argc = $_SERVER['argc'];


        echo '================================================================================
Usage: php ../../git/webim/webim_server.php start|stop|reload
================================================================================
            -d, --daemon      启用守护进程模式
    -h, --host [<value>]      指定监听地址
    -p, --port [<value>]      指定监听端口
                  --help      显示帮助界面
';
    }
}