<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:14
 */

return [
    'class'=>\Moon\Db\Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=weim;port=3306',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'tablePrefix' => 'we_',
    'emulatePrepares' => false,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];