<?php
/**
 *CapitalizeTitleMiddlewareTest
 * @author tan bing
 * @date 2021-06-04 11:06
 */


namespace Tanbing\BlogPackage\Tests\Unit;


use Illuminate\Http\Request;
use Tanbing\BlogPackage\Http\Middleware\CapitalizeTitle;
use Tanbing\BlogPackage\Tests\TestCase;

class CapitalizeTitleMiddlewareTest extends TestCase
{

    public function it_capitalizes_the_request_title()
    {
        // Given we have a request
        $request = new Request();

        // with  a non-capitalized 'title' parameter
        $request->merge(['title' => 'some title']);

        // when we pass the request to this middleware,
        // it should've capitalized the title
        (new CapitalizeTitle())->handle($request, function ($request) {
            $this->assertEquals('Some title', $request->title);
        });
    }
}