<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'groups';

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }
}
