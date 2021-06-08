<?php
/**
 *MakeFooCommandTest
 * @author tan bing
 * @date 2021-06-03 10:51
 */


namespace Tanbing\BlogPackage\Tests\Feature;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tanbing\BlogPackage\Tests\TestCase;

class MakeFooCommandTest extends TestCase
{
    /**
     * @test
     */
    function it_creates_a_new_foo_class()
    {
        // destination path of the Foo class
        $fooClass = app_path('Foo/MyFooClass.php');

        // make sure we're starting from a clean state
        if (File::exists($fooClass)) {
            unlink($fooClass);
        }
        $this->assertFalse(File::exists($fooClass));
        // Run the make command
        Artisan::call('make:foo MyFooClass');

        // Assert a new file is created
        $this->assertTrue(File::exists($fooClass));

        // Assert the file contains the right contents
        $expectedContents = <<<CLASS
<?php
namespace App\Foo;
use Tanbing\BlogPackage\Foo;
class MyFooClass implements Foo
{
    public function myFoo()
    {
        // foo2
    }
}
CLASS;

        $this->assertEquals($expectedContents, file_get_contents($fooClass));
    }
}