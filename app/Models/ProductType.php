<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = 'product_types';
    protected $fillable = ['product_type_name', 'is_active', 'is_updated'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
