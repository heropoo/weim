<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:40
 */

namespace App\Controllers;


use App\Models\Model;
use App\Models\User;
use App\Services\AuthService;
use Moon\Controller;

class UserController extends Controller
{
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

    public function register(){
        return $this->render('register');
    }

    public function post_register(){
        $email = request('email', '');
        $password = request('password', '');
        $user = User::model()->where('email=? and status=0', [$email])->fetch();
        if(!empty($user)){
            return [
                'ret'=>10010,
                'msg'=>'当前Email已被注册'
            ];
        }

        $salt = AuthService::salt();
        $password = AuthService::encrypt($password, $salt);

        $username = $nickname = strstr($email, '@', true);

        $bool = User::model()->insert([
            'username'=>$username,
            'nickname'=>$nickname,
            'email'=>$email,
            'password'=>$password,
            'salt'=>$salt
        ]);

        if($bool){
            return [
                'ret'=>200,
            ];
        }
        return [
            'ret'=>10500,
            'msg'=>'注册失败'
        ];
    }
}