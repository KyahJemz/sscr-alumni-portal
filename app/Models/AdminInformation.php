<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminInformation extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "admin_informations";

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
        'department',
    ];

    public function getFullName(){
        return $this->first_name . " " . $this->middle_name . " " . $this->last_name . " " . $this->suffix;
    }

    public function getName(){
        return $this->first_name . " " . $this->last_name;
    }

}
