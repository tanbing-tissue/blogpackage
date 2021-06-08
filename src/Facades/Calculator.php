<?php
/**
 *Calculator
 * @author tan bing
 * @date 2021-06-03 10:06
 */


namespace Tanbing\BlogPackage\Facades;


use Illuminate\Support\Facades\Facade;

class Calculator extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "calculator";
    }
}