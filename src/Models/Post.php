<?php

namespace Tanbing\BlogPackage\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    public function author()
    {
        return $this->morphTo();
    }
}
