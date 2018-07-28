<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:40
 */

namespace App\Controllers;


use App\Services\AuthService;
use Moon\Controller;

class UserController extends Controller
{
    public function index(){
        echo 'user - index';
    }

    public function login(){
        return $this->render('login');
    }

    public function post_login(){
        $email = request('email');
        $password = request('password');
        return AuthService::login($email, $password);
    }

    public function logout(){
        AuthService::logout();
        return redirect('login');
    }
}