<?php
/**
 * Date: 2019-09-02
 * Time: 11:09
 */

namespace App\Controllers;


use Monolog\Logger;
use Moon\Controller;

class TestController extends Controller
{
    //todo log
    public function log(){
        /** @var Logger $logger */
        $logger = \Moon::$app->get('logger');
        $logger->error(__METHOD__.'error');
        //var_dump($logger->getHandlers());
    }
}