<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hobbies extends Model
{
    use HasFactory;

    public $table = 'hobbies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_hobbies', 'hobbies_id', 'user_id');
    }

}
