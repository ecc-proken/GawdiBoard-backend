<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 強制的にJSONをリクエスト
 * リクエストヘッダに Accept: application/json を付与する
 *
 * @link https://stackoverflow.com/questions/46035072/enforce-json-middleware
 */
class RequireJson
{
    public function handle($request, Closure $next)
    {
        // リクエストヘッダに Accept:application/json を加える
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        return $response;
    }
}
