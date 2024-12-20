<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'feedbacks';

    protected $fillable = ['user_id', 'feedback', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
