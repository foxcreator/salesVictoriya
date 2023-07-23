<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryCheckout extends Model
{

    use HasFactory;

    protected $fillable = [
        'check_id',
        'user_id',
        'product_id',
        'price',
        'opt_price',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
