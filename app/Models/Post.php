<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "posts";

    protected $fillable = ['group_id', 'event_id', 'news_id', 'announcement_id', 'created_by', 'approved_by', 'deleted_by', 'rejected_by', 'content', 'type', 'images', 'files', 'videos', 'approved_at', 'rejected_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejected_by()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
