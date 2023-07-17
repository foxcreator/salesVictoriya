<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDeliveryRequest;
use App\Models\Delivery;
use App\Models\Ingridient;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use function redirect;
use function view;

class StockController extends Controller
{
    public function index(Request $request)
    {

        $query = Delivery::with('products', 'suppliers');
        $search = null;
        // Поиск по тексту
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhereHas('suppliers', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('deliver_name', 'like', "%$search%");
                    })
                    ->orWhereDate('created_at', 'like', "%$search%");
            });
        }

        $deliveries = $query->get();

        foreach ($deliveries as $delivery) {
            $totalAmount = 0;

            foreach ($delivery->products as $product) {
                $totalAmount += $product->pivot->purchase_price * $product->pivot->quantity;
            }

            $delivery->total_amount = $totalAmount;
        }

        $deliveries = $deliveries->sortByDesc('created_at');
        return view('admin.stock.index', compact('deliveries', 'search'));
    }

    public function create(Request $request)
    {

        $supplierId = $request->all()['supplier_id'];
        $supplier = Supplier::find($supplierId);

        $products = $supplier->products;
        $deliveries = Delivery::all();

        return view('admin.stock.create', compact('products', 'supplierId'));
    }

    public function firstStep()
    {
        $suppliers = Supplier::all();

        return view('admin.stock.create_first_step', compact('suppliers'));
    }

    public function store(CreateDeliveryRequest $request)
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


    public function getProductsBySupplier(Request $request, $supplierId)
    {
        // Получите список продуктов, связанных с выбранным поставщиком
        $supplierName = Supplier::findOrFail($supplierId)->name;
        $products = Product::where('supplier', $supplierName)->get();

        // Верните список продуктов в формате JSON
        return response()->json(['products' => $products]);
    }
}
