<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsServise
{
    public function dailyReports($day, $search)
    {
        $query = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->whereDate('carts.created_at', $day)
            ->groupBy('users.id', 'users.name', 'carts.product_id', 'carts.price', 'carts.opt_price')
            ->select(
                'users.name as employee_name',
                'products.name as product_name',
                'carts.price',
                'carts.opt_price', // Используем оптовую цену из таблицы carts
                DB::raw('SUM(carts.quantity) as total_sold')
            );


        if ($search) {
            $query->where('users.name', 'LIKE', '%' . $search . '%');
        }

        $productsSold = $query->get();

        $totalSales = 0;
        $totalOptSales = 0;

        foreach ($productsSold as $product) {
            $totalSales += $product->price * $product->total_sold;
            $totalOptSales += $product->opt_price * $product->total_sold;
        }

        return compact('productsSold', 'totalSales', 'totalOptSales');
    }

//Todo Сделать расчет по оптовой цене на момент продажи для дальнейшего просчета маржи
    public function Reports($onDate, $toDate)
    {

        $productsSold = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->whereDate('carts.created_at','>=', $onDate)
            ->whereDate('carts.created_at','<=', $toDate)
            ->groupBy('carts.product_id', 'carts.price')
            ->select('products.name', 'carts.price', 'products.opt_price', DB::raw('SUM(carts.quantity) as total_sold'))
            ->get();

        $totalSales = 0;
        $totalOptSales = 0;

        foreach ($productsSold as $product) {
            $totalSales += $product->price * $product->total_sold;
            $totalOptSales += $product->opt_price * $product->total_sold;
        }

        return compact('productsSold', 'totalSales', 'totalOptSales');
    }

}
