<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);

        if ($product) {
            return redirect()->back()->with('status', "Продукт {$product->name} был успешно добавлен в меню!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = Product::where('id', $id)
            ->update(['price' => $data['price'], 'quantity' => $data['quantity']]);

        if ($product) {
            return redirect()->back()->with('status', "Продукт был успешно обновлен!");
        } else {
            return redirect()->back()->with('warn', 'Oops, something went wrong. Please check the logs.')->withInput();
        }

    }

    public function edit(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();

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

        $product->update($data);

        if ($product) {
            return redirect()->route('admin.products')->with('status', "Продукт  был успешно изменен!");
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
