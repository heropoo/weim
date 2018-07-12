<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/10
 * Time: 10:58
 */

/**
 * @var \Moon\Routing\Router $router
 */
$router = Moon::$app->get('router');

$router->group(['middleware'=>\App\Middleware\SessionStart::class], function ($router){
    /**
     * @var \Moon\Routing\Router $router
     */
    $router->get('/', 'IndexController::index')->name('index');

    $router->get('login', 'UserController::login');
    $router->post('login', 'UserController::post_login');
    $router->get('logout', 'UserController::logout');

    $router->group(['prefix'=>'user', 'middleware'=>\App\Middleware\Auth::class], function ($router){
        /**
         * @var \Moon\Routing\Router $router
         */
        $router->get('', 'UserController::index')->name('user');
    });
});