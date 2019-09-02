<?php
/**
 * Date: 2018/7/12
 * Time: 10:42
 */
return [
    'server' => [
        'protocol' => env('WS_PROTOCOL', 'ws'),
        'host' => env('WS_HOST', '127.0.0.1'),
        'port' => env('WS_PORT', '8001'),
    ],
];