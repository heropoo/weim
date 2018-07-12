<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:14
 */

return [
    'dsn' => 'mysql:host=localhost;dbname=test;port=3306;charset=utf8',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'tablePrefix' => '',
    'emulatePrepares' => false,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];