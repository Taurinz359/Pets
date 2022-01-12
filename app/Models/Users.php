<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $fillable = [
        'name',
        'email'
    ];
    protected $hidden =['password'];
    protected $connection = 'pgsql';
}