<?php

namespace App\Models;

use App\Services\FileStorageService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'supplier',
        'description',
        'barcode',
        'unit',
        'price',
        'opt_price',
        'quantity',
        'thumbnail'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function temporaryCheckouts()
    {
        return $this->hasMany(TemporaryCheckout::class);
    }

    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_product')
            ->using(DeliveryProduct::class)
            ->withPivot(['quantity', 'purchase_price', 'retail_price']);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function removeFromCart()
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$this->id])) {
            if ($cart[$this->id]['quantity'] > 1) {
                $cart[$this->id]['quantity']--;
            } else {
                unset($cart[$this->id]);
            }

            session()->put('cart', $cart);

            return redirect()->back()->with('status', "$this->name удален из чека");
        }

        return redirect()->back()->with('error', 'Товар не найден в чеке');
    }

    public function removeFromTemporaryCartDb($product)
    {
        $productRow = TemporaryCheckout::where('product_id', $product->id)->first();

        if ($productRow) {
            if ($productRow->quantity <= 1) {
                $productRow->delete();
                $delete = true;
            } else {
                $productRow->quantity = $productRow->quantity - 1;
                $productRow->save();
                $delete = false;
            }
        }
        return $delete;
        return redirect()->back()->with('error', 'Товар не найден в чеке');
    }


    public function setThumbnailAttribute($image)
    {
        if (!empty($this->attributes['thumbnail'])){
            FileStorageService::remove($this->attributes['thumbnail']);
        }


        $this->attributes['thumbnail'] = FileStorageService::upload($image);
    }

    public function thumbnailUrl(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::url($this->attributes['thumbnail'])
        );
    }
}
