<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $table = 'lookups';
    protected $fillable = ['lookup_type', 'lookup_name', 'is_active', 'is_updated'];
}
