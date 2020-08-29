<?php namespace Com\Clay\Common\Middleware;

use Closure;
use Illuminate\Container\BoundMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Com\Clay\Common\Libs\Entity;

class BindingMiddleware
{
    /**
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * 关于http请求参数适配，优先级由高到低
         *
         * 1. 变量名称适配(要求：path&query参数必须请求参数名)
         * 2. Entity 通过 boday 参数赋值
         */
        $routeInfo = $request->route();
        $parameters = $routeInfo[2];
        $uses = $routeInfo[1]['uses'];

        if (is_string($uses) && !Str::contains($uses, '@')) {
            $uses .= '@__invoke';
        }

        [$controller, $method] = explode('@', $uses);
        $reflectionParameters = (new \ReflectionMethod(app()->make($controller), $method))->getParameters();
        foreach ($reflectionParameters as $parameter) {
            foreach ($request->query() as $key => $value) {
                // 如果路径中已经有该参数
                if (isset($parameters[$key])) continue;

                if ($key == $parameter->getName()) {
                    $parameters[$key] = $value;
                }
            }

            if ($parameter->getClass() && $parameter->getClass()->isSubclassOf(Entity::class)) {
                $reflector = new \ReflectionClass($parameter->getClass()->name);
                $instance = $reflector->newInstanceArgs([$request->post()]);

                $parameters[$parameter->name] = $instance;
            }
        }

        $routeInfo[2] = $parameters;
        $request->setRouteResolver(function () use ($routeInfo) {
            return $routeInfo;
        });

        return $next($request);
    }
}