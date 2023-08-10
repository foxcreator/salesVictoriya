<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Services\ReportsServise;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function products()
    {
        $products = Product::with('category')->where('on_sale', 1)->paginate(20);
        return view('new_design.admin.products.index', compact('products'));
    }

    public function setDesign($design)
    {
        session(['design' => $design]);
        return redirect()->back();
    }

}
