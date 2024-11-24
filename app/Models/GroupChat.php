<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupChat extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'group_chats';

    protected $fillable = [
        'sent_by',
        'group_id',
        'message',
        'file',
        'image',
        'read_at',
        'seen',
        'deleted_by',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
