<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_name',
        'branch_code',
        'branch_email',
        'branch_contact',
        'branch_address',
        'created_by',
        'is_active',
    ];
}
