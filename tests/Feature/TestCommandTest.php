<?php
/**
 *TestCommandTest
 * @author tan bing
 * @date 2021-06-03 11:03
 */


namespace Tanbing\BlogPackage\Tests\Feature;


use Tanbing\BlogPackage\Tests\Commands\TestCommand;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Artisan;
use Tanbing\BlogPackage\Tests\TestCase;

class TestCommandTest extends TestCase
{
    /** @test **/
    public function it_does_a_certain_thing()
    {
        Application::starting(function ($artisan) {
            $artisan->add(app(TestCommand::class));
        });

        // Running the command
        Artisan::call('test-command:run');

        // Assertions...
    }
}