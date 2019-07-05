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
        $username = request('username');
        $password = request('password');
        return AuthService::login($username, $password);
    }

    public function logout(){
        AuthService::logout();
        return redirect('login');
    }

    public function register(){
        return $this->render('register');
    }

    public function post_register(){
        $username = trim(request('username', ''));
        $password = trim(request('password', ''));
        $user = User::model()->where('username=? and status=0', [$username])->fetch();
        if(!empty($user)){
            return [
                'ret'=>10010,
                'msg'=>'当前username已被注册'
            ];
        }

        $password = AuthService::encrypt($password);

        $nickname = $username;

        $bool = User::model()->insert([
            'username'=>$username,
            'nickname'=>$nickname,
            'password'=>$password,
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