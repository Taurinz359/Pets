<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    protected $table = "users";
    protected $fillable = [
        'email',
        'password'
    ];
    protected $hidden = ['password'];
}