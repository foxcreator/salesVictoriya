<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Services\ReportsServise;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportsServise $reportsServise)
    {
        $this->reportService = $reportsServise;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);


        $search = $request->input('search');
        if ($search) {
            $products = Product::where('name', 'LIKE', '%' . $search . '%')->paginate(8);
        } else {
            $products = Product::where('on_sale', 1)->paginate(20);
        }


        return view('home', compact('products', 'search', 'cart'));
    }

    public function create()
    {
        $units = Unit::all();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('units', 'suppliers'));
    }

    public function products()
    {
        $products = Product::where('on_sale', 1)->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'suppliers'));
    }

    public function todayReport(Request $request)
    {
        $today = Carbon::today();
        $employeeName = $request->input('employee');

        $reportData = $this->reportService->dailyReports($today, $employeeName);

        $productsSold = $reportData['productsSold'];
        $totalSales = $reportData['totalSales'];
        $totalOptSales = $reportData['totalOptSales'];

        return view('admin.reports.index', compact('productsSold', 'totalSales', 'totalOptSales', 'employeeName'));
    }

    public function monthlyReport(Request $request)
    {
        $search = $request->input('search');
        return view('admin.reports.monthly');
    }

    public function calcMonthlyReport(Request $request)
    {
        $dates = $request->all();
        if (empty($dates)) {
            $dates = [
                'ondate' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'todate' => Carbon::today()->format('Y-m-d')
            ];
        }

        $reportData = $this->reportService->Reports($dates['ondate'], $dates['todate']);
        $productsSold = $reportData['productsSold'];
        $totalSales = $reportData['totalSales'];
        $totalOptSales = $reportData['totalOptSales'];

        return view('admin.reports.monthly', compact('productsSold', 'totalSales', 'dates', 'totalOptSales'));
    }

}
