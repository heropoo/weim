<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/14
 * Time: 11:49
 */

return [
    'debug' => env('DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Shanghai',
    'components' => [
        'db' => include __DIR__ . '/db.php'
    ],
    'bootstrap' => ['db']
];