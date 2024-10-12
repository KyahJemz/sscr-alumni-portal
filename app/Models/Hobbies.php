<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobbies extends Model
{
    use HasFactory;

    public $table = 'hobbies';

    protected $fillable = [
        'name',
        'description',
        'category',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_hobbies', 'hobbies_id', 'user_id');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_hobbies', 'hobbies_id', 'group_id')->wherePivotNull('deleted_at');
    }
}
