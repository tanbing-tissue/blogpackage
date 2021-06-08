<?php
/**
 *InstallBlogPackageTest
 * @author tan bing
 * @date 2021-06-03 10:27
 */


namespace Tanbing\BlogPackage\Tests\Unit;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tanbing\BlogPackage\Tests\TestCase;

class InstallBlogPackageTest extends TestCase
{
    /**
     * @test
     */
    function the_install_command_copies_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('blogpackage.php'))) {
            unlink(config_path('blogpackage.php'));
        }

        $this->assertFalse(File::exists(config_path('blogpackage.php')));

        Artisan::call('blogpackage:install');

        $this->assertTrue(File::exists(config_path('blogpackage.php')));
    }

    /**
     * @test
     */
    public function when_a_config_file_is_present_users_can_choose_to_not_overwrite_it()
    {
        // Given we have already have an existing config file
        File::put(config_path('blogpackage.php'), 'test contents');
        $this->assertTrue(File::exists(config_path('blogpackage.php')));

        // When we run the install command
        $command = $this->artisan('blogpackage:install');

        // We expect a warning that our configuration file exists
        $command->expectsQuestion(
            'Config file already exists. Do you want to overwrite it?',
            // When answered with "no"
            'no'
        );

        // We should see a message that our file was not overwritten
        $command->expectsOutput('Existing configuration was not overwritten');

        // Assert that the original contents of the config file remain
        $this->assertEquals(file_get_contents(config_path('blogpackage.php')), 'test contents');

        // Clean up
        unlink(config_path('blogpackage.php'));
    }

    /**
     * @test
     */
    public function when_a_config_file_is_present_users_can_choose_to_do_overwrite_it()
    {
        // Given we have already have an existing config file
        File::put(config_path('blogpackage.php'), 'test contents');
        $this->assertTrue(File::exists(config_path('blogpackage.php')));

        // When we run the install command
        $command = $this->artisan('blogpackage:install');

        // We expect a warning that our configuration file exists
        $command->expectsQuestion(
            'Config file already exists. Do you want to overwrite it?',
            // When answered with "yes"
            'yes'
        );

        $command->expectsOutput('Overwriting configuration file...');

        // Assert that the original contents are overwritten
        $this->assertEquals(
            file_get_contents(config_path('blogpackage.php')),
            file_get_contents(__DIR__.'/../config/config.php')
        );

        // Clean up
        unlink(config_path('blogpackage.php'));
    }
}