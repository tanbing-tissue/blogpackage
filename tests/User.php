<?php
/**
 *User
 * @author tan bing
 * @date 2021-06-04 10:15
 */


namespace Tanbing\BlogPackage\Tests;


use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    protected $guarded = [];

    protected $table = 'users';

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}