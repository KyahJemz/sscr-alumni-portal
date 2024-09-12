<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hobbies extends Model
{
    use HasFactory;

    public $table = 'hobbies';

    public function alumniInformation(): BelongsToMany
    {
        return $this->belongsToMany(AlumniInformation::class);
    }
}
