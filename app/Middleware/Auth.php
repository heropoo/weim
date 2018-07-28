<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/1/29
 * Time: 14:14
 */
namespace App\Middleware;

use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Closure;

class Auth
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(!AuthService::isAuth()){
            return redirect('login');
        }

        return $next($request);
    }
}