<?php namespace Com\Clay\UacSimpleApi;

use Com\Clay\Common\Middleware\AuthMiddleware;
use Com\Clay\Common\Middleware\BindingMiddleware;
use Com\Clay\Common\Middleware\ResponseMiddleware;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Routing\Router;
use Com\Clay\UacSimpleApi\Service\UserInterface;
use Com\Clay\UacSimpleApi\Client\UserClient;

/**
 * uac-simple-api
 * @version 1.0.0
 */
class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $path = $this->app->configPath("gaea_services.php");
        $this->mergeConfigFrom($path, 'gaea_services');

        $this->registerClient();
        $config = config('gaea_services.uac-simple-api');
        if ($config && $config['service'] ?? false) {
            $this->registerService();
        }

        $implements = $config ? $config['implements'] ?? [] : [];
        foreach ($implements as $interface => $implement) {
            $this->app->bind($interface, $implement);
        }
    }

    public function registerClient()
    {
        $this->app->bindIf(UserInterface::class, UserClient::class);
    }

    public function registerService()
    {
        $auth = config('gaea_services.uac-simple-api.auth', 0);
        $this->app->routeMiddleware([
            'msBinding' => BindingMiddleware::class,
            'msResponse' => ResponseMiddleware::class,
            'auth' => AuthMiddleware::class
        ]);
        $this->app->router->group([
            'middleware' => $auth ? ['msBinding', 'msResponse', 'auth'] : ['msBinding', 'msResponse'],
            'namespace' => __NAMESPACE__ . '\Controller',
        ], function (Router $router) {

            // 用户
            $router->post('/user/list', ['uses' => 'UserController@queryUserList', 'name' => '用户列表']);
            $router->post('/user/page', ['uses' => 'UserController@queryUserPage', 'name' => '用户列表（分页）']);
            $router->post('/user/create', ['uses' => 'UserController@createUser', 'name' => '创建用户']);
            $router->get('/user/find', ['uses' => 'UserController@findUser', 'name' => '用户信息']);
            $router->put('/user/update', ['uses' => 'UserController@updateUser', 'name' => '更新用户']);
            $router->delete('/user/delete', ['uses' => 'UserController@deleteUser', 'name' => '删除用户']);

        });
    }
}
