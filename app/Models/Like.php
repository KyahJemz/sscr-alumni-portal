<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'likes';

    protected $fillable = ['liked_by', 'post_id'];

    public function post()
    {
        return $this->hasMany(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'liked_by');
    }
}
