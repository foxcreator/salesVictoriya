<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_info',
        'deliver_name'
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'supplier_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supplier');
    }
}
