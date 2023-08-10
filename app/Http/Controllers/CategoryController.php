<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('new_design.admin.categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->all();

        $categorySaved = Category::create($data);
        if ($categorySaved) {
            return redirect()->back()->with('status', "Категория {$categorySaved->name} успешно добавлена!");
        } else {
            return redirect()->back()->with('error', 'smth wrong');
        }

    }
}
