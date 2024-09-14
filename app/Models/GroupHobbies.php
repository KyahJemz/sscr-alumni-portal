<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupHobbies extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'group_hobbies';
}
