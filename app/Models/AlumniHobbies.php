<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumniHobbies extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'alumni_hobbies';

    public function alumniInformation(): HasOne
    {
        return $this->hasOne(AlumniInformation::class);
    }

    public function hobbies(): HasMany
    {
        return $this->hasMany(Hobbies::class);
    }
}
