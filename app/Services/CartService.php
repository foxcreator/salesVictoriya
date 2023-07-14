<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function addProductToCart(Product $product, $quantity)
    {

        $cart = session()->get('cart', []);


        if (isset($cart[$product->id]['quantity']) && ($cart[$product->id]['quantity'] + $quantity) > $product->quantity ){
            $cartQnt = $cart[$product->id]['quantity'];
            return redirect()->back()->with('error', "Невозможно добавить! Остаток - $product->quantity штук(и). Количество в открытом чеке - $cartQnt");
        }
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'opt_price' =>$product->opt_price,
                'quantity' => $quantity,
            ];
        }
        session()->put('cart', $cart);

        return redirect()->route('home')->with('status', "Товар $product->name добавлен в чек");
    }

    public function checkoutProductToDb()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        foreach ($cart as $productId => $item) {
            $cartModel = Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'price' => $item['price'],
                'opt_price' => $item['opt_price'],
                'quantity' => $item['quantity'],
            ]);

            $cartId = $cartModel->id;

            // Уменьшаем количество товара на складе
            $product = Product::findOrFail($productId);
            $product->quantity -= $item['quantity'];
            $product->save();
        }

        session()->forget('cart');

        return $cartId;
    }

    public function getTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

}

