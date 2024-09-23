<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostEditApproval extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "post_edit_approvals";

    protected $fillable = ['post_id', 'approved_by', 'rejected_by', 'created_by', 'request', 'rejected_at', 'approved_at'];
}
