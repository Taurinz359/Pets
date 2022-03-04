<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    const  UPDATED_AT = false;

    public const STATUS_DRAFT = 1;
    public const STATUS_PUBLISHED = 2;

    protected $table = "posts";
    protected $fillable = [
        'user_id',
        'name',
        'content',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
