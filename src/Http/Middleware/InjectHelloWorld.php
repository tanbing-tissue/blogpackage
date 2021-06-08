<?php
/**
 *InjectHelloWorld
 * @author tan bing
 * @date 2021-06-04 11:08
 */


namespace Tanbing\BlogPackage\Http\Middleware;


use Closure;

class InjectHelloWorld
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Perform action

        return $response;
    }
}