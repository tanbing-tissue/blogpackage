<?php
namespace Tanbing\BlogPackage\Traits;

use Tanbing\BlogPackage\Models\Post;

trait HasPosts
{
    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }
}