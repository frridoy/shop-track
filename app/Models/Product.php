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
        'product_qty',
        'product_max_price',
        'product_bottom_price',
        'is_active',
        'is_updated',
        'created_by',
    ];

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

}
