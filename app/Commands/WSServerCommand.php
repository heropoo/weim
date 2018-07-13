<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/14
 * Time: 1:40
 */
namespace App\Commands;


use App\Services\WSService;
use Moon\Command;

class WSServerCommand extends Command
{
    public function run(){
        $ip = '0.0.0.0';
        $port = config('ws.server.port');
        $service = new WSService();
        $service->run($ip, $port);
        return 0;
    }

    public function test(){
        echo __METHOD__.'::test';
    }
}