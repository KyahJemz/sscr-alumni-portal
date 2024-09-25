<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    public $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'image',
        'role',
        'created_by',
        'deleted_by',
        'deleted_at',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'disabled_by',
        'disabled_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alumniInformation()
    {
        return $this->hasOne(AlumniInformation::class);
    }
    public function adminInformation()
    {
        return $this->hasOne(AdminInformation::class);
    }

    public function posts()
    {
        return $this->hasMany(post::class, 'created_by');
    }

    public function approvedPosts()
    {
        return $this->hasMany(post::class, 'approved_by');
    }

    public function rejectedPosts()
    {
        return $this->hasMany(post::class, 'rejected_by');
    }

    public function hobbies()
    {
        return $this->belongsToMany(Hobbies::class, 'user_hobbies', 'user_id', 'hobbies_id')
                    ->withPivot('created_at', 'updated_at', 'deleted_at')
                    ->whereNull('user_hobbies.deleted_at')
                    ->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')
            ->withPivot('deleted_at', 'created_at')
            ->whereNull('group_members.deleted_at')
            ->whereNull('group_members.rejected_at')
            ->whereNotNull('group_members.approved_at')
            ->orderBy('group_members.created_at', 'desc')
            ->distinct('group_members.group_id');
    }

    public function groupsManaged()
    {
        return $this->belongsToMany(Group::class, 'group_admins', 'user_id', 'group_id')
                ->withPivot('deleted_at', 'created_at')
                ->whereNull('group_admins.deleted_at')
                ->orderBy('group_admins.created_at', 'desc')
                ->distinct('group_admins.group_id');
    }
}
