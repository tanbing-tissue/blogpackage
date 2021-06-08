<?php
/**
 *PostTest
 * @author tan bing
 * @date 2021-06-03 11:37
 */


namespace Tanbing\BlogPackage\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tanbing\BlogPackage\Models\Post;
use Tanbing\BlogPackage\Tests\TestCase;

class PostTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    function a_post_has_a_title()
    {
        $post = factory(Post::class)->create(['title' => 'Fake Title']);
        $this->assertEquals('Fake Title', $post->title);
    }
}