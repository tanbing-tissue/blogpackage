<?php
/**
 *PostWasCreated
 * @author tan bing
 * @date 2021-06-04 10:32
 */


namespace Tanbing\BlogPackage\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Tanbing\BlogPackage\Models\Post;

class PostWasCreated
{
    use Dispatchable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}