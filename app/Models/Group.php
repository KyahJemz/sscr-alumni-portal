<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'groups';

    protected $fillable = [
        'created_by',
        'deleted_by',
        'name',
        'description',
        'image',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'group_admins', 'group_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'group_id');
    }

    public function group_members()
    {
        return $this->hasMany(GroupMember::class, 'group_id');
    }

    public function group_admins()
    {
        return $this->hasMany(GroupAdmin::class, 'group_id');
    }

}
