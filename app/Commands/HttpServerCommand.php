<?php

namespace App\Commands;

use Swoole\Http\Server;
use Moon\Command;

class HttpServerCommand extends Command{
    public function swoole(){
        $host = config('server.http.host');
        $port = config('server.http.port');

        $http = new Server($host, $port);
        $http->on('request', function ($request, $response) {
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });
        $http->start();
    }
}