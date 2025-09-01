<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id',
        'product_name',
        'product_code',
        'remarks',
        'entry_no',
        'is_active',
        'is_updated',
        'created_by',
    ];

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

}
