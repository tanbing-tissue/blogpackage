<?php
/**
 *CapitalizeTitle
 * @author tan bing
 * @date 2021-06-04 11:02
 */


namespace Tanbing\BlogPackage\Http\Middleware;


use Illuminate\Contracts\Http\Kernel;

class CapitalizeTitle
{

    /**
     * 创建中间件
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @author tan bing
     * @date 2021-06-04 11:05
     */
    public function handle($request, \Closure $next)
    {
        if($request->has('title')) {
            $request->merge([
                'title' => ucfirst($request->title),
            ]);
        }

        return $next($request);
    }

}