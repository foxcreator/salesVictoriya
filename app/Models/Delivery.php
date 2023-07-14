<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'quantity',
        'purchase_price',
        'retail_price'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'delivery_product')
            ->using(DeliveryProduct::class)
            ->withPivot(['quantity', 'purchase_price', 'retail_price']);
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
