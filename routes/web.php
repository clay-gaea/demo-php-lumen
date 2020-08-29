<?php

use Com\Clay\UacSimpleApi\Client\UserClient;
use Com\Clay\UacSimpleApi\Entity\User;
use Com\Clay\UacSimpleApi\Facade\UserFacade;
use GuzzleHttp\Promise;


/**
 * @var $router Laravel\Lumen\Routing\Router
 */
$router->get('/', function () use ($router) {

    // 同步调用
    $user1 = UserFacade::findUser(7);
    $user2 = (new UserClient())->findUser(7);
    $page = UserFacade::queryUserPage(null);
//    dd($user1, $user2, $page);

    // 异步调用（不是真正异步）
//    $promise = (new UserClient())->findUserAsync(7);
//    $promise->then(function (User $user) {
//        dd($user);
//    })->wait();

    // 并发请求
    $results = Promise\unwrap([
        'user' => (new UserClient())->findUserAsync(7),
        'page' => (new UserClient())->queryUserPageAsync(null)
    ]);
    dd($results);

    return $router->app->version();
});
