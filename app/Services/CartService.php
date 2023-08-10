<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\DeliveryProduct;
use App\Models\Product;
use App\Models\TemporaryCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\FlareMiddleware\CensorRequestBodyFields;

class CartService
{
    public function addProductToCart(Product $product, $quantity)
    {
        // Получаем товары из открытого чека в сессии
        $cart = session()->get('cart', []);

        // Получаем товары из отложенных чеков в базе данных
        $delayedChecks = TemporaryCheckout::where('check_id', '!=', null)->get();

        // Объединяем товары из сессии и из отложенных чеков
        $allProducts = array_merge($cart, $delayedChecks->toArray());
        // Проверяем остатки товаров
        $totalQuantity = 0;
        foreach ($allProducts as $item) {
            if ($item['product_id'] == $product->id) {
                $totalQuantity += $item['quantity'];
            }
        }

        // Вычисляем доступное количество товара на складе
        $availableQuantity = $product->quantity - $totalQuantity;

        // Проверяем, достаточно ли товара на складе
        if ($availableQuantity < $quantity) {
            $cartQnt = $totalQuantity;
            return redirect()->back()->with('error', "Невозможно добавить! Остаток - $availableQuantity штук(и). Количество в открытом и отложенных чеках - $cartQnt");
        }

        // Добавляем товар в чек
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + $quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'opt_price' =>$product->opt_price,
                'quantity' => $quantity,
            ];
        }

        // Обновляем данные в сессии
        session()->put('cart', $cart);

        return redirect()->route('home')->with('status', "Товар $product->name добавлен в чек");
    }


    public function checkoutProductToDb($isDelayed)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);
        $checkId = $this->generateCheckId($isDelayed == 0 ? 'check' : 'temp');

        foreach ($cart as $productId => $item) {
            $remainingQuantity = $item['quantity'];

            while ($remainingQuantity > 0) {
                $productDelivery = DeliveryProduct::where('product_id', $productId)
                    ->where('available_quantity', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->first();

                if (!$productDelivery) {
                    break; // Нет доступных поставок, прекращаем
                }

                $quantityToTake = min($remainingQuantity, $productDelivery->available_quantity);

                if ($productDelivery->purchase_price) {
                    $optPrice = $productDelivery->purchase_price;
                } else {
                    $optPrice = $item['opt_price'];
                }

                if ($isDelayed == 0) {
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'price' => $item['price'],
                        'opt_price' => $optPrice,
                        'quantity' => $quantityToTake,
                        'check_id' => $checkId,
                    ]);
                } else {
                    TemporaryCheckout::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'price' => $item['price'],
                        'opt_price' => $optPrice,
                        'quantity' => $quantityToTake,
                        'check_id' => $checkId,
                    ]);
                }

                $productDelivery->available_quantity -= $quantityToTake;
                $productDelivery->save();

                $remainingQuantity -= $quantityToTake;
            }

            // Уменьшаем общий остаток товара
            $product = Product::findOrFail($productId);
            $product->quantity -= $item['quantity'];
            $product->save();
        }

        session()->forget('cart');

        return $checkId;
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

    private function generateCheckId($whatsCheck)
    {
        if ($whatsCheck == 'temp') {
            // Получаем последний использованный идентификатор из базы данных
            $lastCheck = TemporaryCheckout::orderBy('check_id', 'desc')->first();
        } else {

            $lastCheck = Cart::orderBy('check_id', 'desc')->first();
        }

        if (isset($lastCheck->check_id)) {
            $lastCheckId = $lastCheck->check_id;
        } else {
            $lastCheckId = null;
        }

        $nextCheckId = $lastCheckId ? $lastCheckId + 1 : 1;

        return $nextCheckId;
    }

    public function saveIntoTemporary($delayedCheckId)
    {
        $checkId = $this->generateCheckId('check');
        $cart = TemporaryCheckout::query()->where('check_id', $delayedCheckId)->get();

        foreach ($cart as $item) {
            $cartModel = Cart::create([
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'price' => $item->price,
                'opt_price' => $item->opt_price,
                'quantity' => $item->quantity,
                'check_id' => $checkId,
            ]);

            $cartId = $cartModel->id;

            // Уменьшаем количество товара на складе
            $product = Product::findOrFail($item->product_id);
            $product->quantity -= $item->quantity;
            $product->save();

            TemporaryCheckout::query()->where('id', $item->id)->delete();
        }

        return $cartId;
    }


}

