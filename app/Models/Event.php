<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'events';

    protected $fillable = ['title', 'description', 'thumbnail', 'start_date', 'end_date', 'location', 'status', 'contributions', 'amount'];

    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
