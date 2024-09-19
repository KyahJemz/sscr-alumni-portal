<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'announcements';

    protected $fillable = ['title', 'description', 'thumbnail'];

    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
