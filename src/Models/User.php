<?php
/**
 *User
 * @author tan bing
 * @date 2021-06-04 10:05
 */


namespace Tanbing\BlogPackage\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }
}