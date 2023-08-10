<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportsServise;
use Carbon\Carbon;
use function view;

class AdminController extends Controller
{

    public function __construct(ReportsServise $reportsServise)
    {
        $this->reportService = $reportsServise;
        $this->middleware('auth');
    }

    public function index()
    {
        $todayCash = $this->todayCash();
        $monthlyIncome = $this->monthlyIncome();
        return view('new_design.admin.index', compact('todayCash', 'monthlyIncome'));
    }

    public function todayCash()
    {
        $today = Carbon::today();
        $reportData = $this->reportService->dailyReports($today);
        $totalSales = $reportData['totalSales'];

        return $totalSales;
    }

    public function monthlyIncome()
    {
        $dates = [
            'ondate' => \Illuminate\Support\Carbon::now()->startOfMonth()->format('Y-m-d'),
            'todate' => Carbon::today()->format('Y-m-d')
        ];

        $reportData = $this->reportService->Reports($dates['ondate'], $dates['todate']);
        $totalSales = $reportData['totalSales'];
        $totalOptSales = $reportData['totalOptSales'];

        $income = $totalSales - $totalOptSales;

        return $income;
    }
}
