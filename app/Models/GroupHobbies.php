<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupHobbies extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'group_hobbies';

    protected $fillable = [
        'hobbies_id',
        'group_id',
        'deleted_at',
    ];

    public function hobbies()
    {
        return $this->belongsTo(Hobbies::class, 'hobbies_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
