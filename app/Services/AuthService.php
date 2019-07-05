<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/28
 * Time: 22:19
 */

namespace App\Services;


use App\Models\User;

class AuthService
{
    const SESSION_KEY = 'user';

    public static function setUser($user)
    {
        $_SESSION[static::SESSION_KEY] = $user;
    }

    public static function user()
    {
        return !empty($_SESSION[static::SESSION_KEY]) ? $_SESSION[static::SESSION_KEY] : false;
    }

    public static function id()
    {
        return !empty(static::user()) ? static::user()['id'] : false;
    }

    public static function isAuth()
    {
        return !empty(static::user());
    }

    public static function login($username, $password)
    {
        if (empty($username)) {
            return [
                'ret' => 10400,
                'msg' => '账号不能为空'
            ];
        }
        if (empty($password)) {
            return [
                'ret' => 10401,
                'msg' => '密码不能为空'
            ];
        }
        $user = User::model()->where('username=? and status=0', [$username])->fetch();
        if (empty($user)) {
            return [
                'ret' => 10402,
                'msg' => '账号不存在'
            ];
        }

        if (!static::checkPassword($password, $user['password'])) {
            return [
                'ret' => 10403,
                'msg' => '密码不正确'
            ];
        }

        static::setUser($user);

        return [
            'ret' => 200
        ];
    }

    public static function logout()
    {
        unset($_SESSION[static::SESSION_KEY]);
    }

    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkPassword($password, $hash){
        return password_verify($password, $hash);
    }

    public static function salt()
    {
        return md5(uniqid() . mt_rand(1000, 9999));
    }
}