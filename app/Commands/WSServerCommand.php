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
    public function swoole(){
        $host = config('server.ws.host');
        $port = config('server.ws.port');
        $service = new WSService();
        $service->run($ip, $port);
        return 0;
    }
}