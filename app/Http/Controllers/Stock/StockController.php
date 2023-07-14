<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Ingridient;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use function redirect;
use function view;

class StockController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with('products', 'suppliers')->get();

        foreach ($deliveries as $delivery) {
            $totalAmount = 0;

            foreach ($delivery->products as $product) {
                $totalAmount += $product->pivot->purchase_price * $product->pivot->quantity;
            }

            $delivery->total_amount = $totalAmount;
        }
        return view('admin.stock.index', compact('deliveries'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $deliveries = Delivery::all();

        return view('admin.stock.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $delivery = new Delivery();
        if ($request->has('supplier_id')) {
            $delivery->supplier_id = $request->input('supplier_id');
        }

        $delivery->save();
        $productIds = $request->get('products');

        $data = [];
        foreach ($productIds as $productId) {
            $quantity = $request->get('quantity')[$productId];
            $purchasePrice = $request->get('purchase_price')[$productId];
            $retailPrice = $request->get('retail_price')[$productId];

            // Находим соответствующий продукт
            $product = Product::find($productId);

            // Обновляем цены продукта
            $product->price = $retailPrice;
            $product->opt_price = $purchasePrice;

            // Прибавляем количество к остатку продукта
            $product->quantity += $quantity;

            // Сохраняем изменения
            $product->save();

            // Связываем продукт с поставкой
            $delivery->products()->attach($productId, [
                'quantity' => $quantity,
                'purchase_price' => $purchasePrice,
                'retail_price' => $retailPrice,
            ]);
        }
        return redirect()->route('admin.stock')->with('status', "Продукт(ы) успешно добавлен(ы)");

    }

    public function singleDelivery(Delivery $delivery)
    {
        $products = $delivery->products()->withPivot('quantity', 'purchase_price', 'retail_price')->get();

        return view('admin.stock.single', compact('delivery', 'products'));
    }
}
