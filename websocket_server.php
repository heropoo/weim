<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/2
 * Time: 11:00
 */

require 'vendor/autoload.php';

$service = new \App\Services\WSService();
$service->run();
