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
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getRemainingQtyAttribute()
    {
        $sold = $this->orderDetails()->sum('quantity');
        return $this->stock_qty - $sold;
    }

    public function scopeLowStock($query, $hold = 5)
    {
        return $query->withSum('orderDetails', 'quantity')
            ->get()
            ->filter(fn($product) => ($product->stock_qty - $product->order_details_sum_quantity) < $hold);
    }
}
