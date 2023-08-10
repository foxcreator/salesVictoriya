<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);


        $search = $request->input('search');
        if ($search) {
            $products = Product::where('name', 'LIKE', '%' . $search . '%')->paginate(8);
        } else {
            $products = Product::where('on_sale', 1)->paginate(12);
        }

        return view('new_design.home', compact('products', 'search', 'cart'));
    }

    public function create()
    {
        $units = Unit::all();
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('new_design.admin.products.create', compact('units', 'suppliers', 'categories'));
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        $suppliers = $data['supplier'];
        unset($data['supplier']);

        $product = Product::create($data);

        if ($product) {
            // Сохранение связи между продуктом и поставщиком
            $product->suppliers()->sync($suppliers);

            return redirect()->back()->with('status', "Продукт {$product->name} был успешно добавлен в меню!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('new_design.admin.products.edit', compact('product', 'suppliers', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();
        $suppliers = $data['supplier'];
        unset($data['supplier']);
        $product = Product::find($id);

        // Проверяем, было ли загружено новое изображение
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');

            // Удаляем старое изображение
            if (isset($product->thumbnail)) {
                Storage::delete($product->thumbnail);
            }

            // Загружаем и сохраняем новое изображение
            $thumbnailPath = $thumbnail->store('public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $saveProduct = $product->update($data);
        if ($saveProduct) {
            // Сохранение связи между продуктом и поставщиком
            $product->suppliers()->sync($suppliers);
        }

        if ($saveProduct) {
            return redirect()->route('admin.product')->with('status', "Продукт  был успешно изменен!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }
    }

    public function updatePrice(Request $request, $id)
    {
        $data = $request->all();
        $product = Product::where('id', $id)
            ->update(['price' => $data['price']]);

        if ($product) {
            return redirect()->back()->with('status', "Продукт был успешно обновлен!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }

    }

    public function delete($id)
    {
        $product = Product::find($id);
        Product::where('id', $id)->update(['on_sale' => 0, 'quantity' => 0]);

        return redirect()->back()->with('status', "Продукт $product->name был успешно удален" );
    }

}
