<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumniInformation extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "alumni_informations";

    // public function alumniHobbies()
    // {
    //     return $this->hasMany(AlumniHobbies::class);
    // }
    public function hobbies(): BelongsToMany
    {
        return $this->belongsToMany(Hobbies::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'nationality',
        'civil_status',
        'age',
        'gender',
        'street_address',
        'country',
        'region',
        'province',
        'city',
        'barangay',
        'postal_code',
        'martial_status',
        'education_level',
        'course',
        'birth_date',
        'batch',
        'phone',
        'occupation',
        'user_id'
    ];


    public function getFullName(){
        return $this->first_name . " " . $this->middle_name . " " . $this->last_name . " " . $this->suffix;
    }

    public function getName(){
        return $this->first_name . " " . $this->last_name;
    }

}
