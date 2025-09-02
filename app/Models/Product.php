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
        'entry_no',
        'color',
        'size',
        'stock_qty',
        'purchase_price',
        'selling_price',
        'bottom_price',
        'remarks',
        'is_active',
        'is_updated',
        'created_by',
        'updated_by',
    ];

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }
}
