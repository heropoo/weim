<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:28
 */
namespace App\Controllers;

use Moon\Controller;

class IndexController extends Controller
{
    public function index(){
        return $this->render('index');
    }

    public function chat(){
        return $this->render('chat');
    }

    public function test(){
        var_dump(\Moon::$app->get('db'));
    }
}