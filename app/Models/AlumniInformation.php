<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AlumniInformation extends Model
{
    use HasFactory;

    public $table = "alumni_informations";

    // public function alumniHobbies()
    // {
    //     return $this->hasMany(AlumniHobbies::class);
    // }
    public function hobbies(): BelongsToMany
    {
        return $this->belongsToMany(Hobbies::class);
    }
}
