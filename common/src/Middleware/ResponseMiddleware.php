<?php namespace Com\Clay\Common\Middleware;

use Closure;
use Illuminate\Container\BoundMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Com\Clay\Common\Libs\Response as ResponseData;

class ResponseMiddleware
{
    /**
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var Response $rt
         */
        $rt = $next($request);
        $original = $rt->getOriginalContent();
        if (is_string($original) || $original instanceof ResponseData) {
            return $rt;
        }

        return $rt->setContent(new ResponseData($original));
    }
}