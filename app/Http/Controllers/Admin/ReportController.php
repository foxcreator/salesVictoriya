<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportsServise;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function __construct(ReportsServise $reportsServise)
    {
        $this->reportService = $reportsServise;
        $this->middleware('auth');
    }

    public function todayReport(Request $request)
    {
        $today = Carbon::today();
        $employeeName = $request->input('employee');

        $reportData = $this->reportService->dailyReports($today, $employeeName);

        $productsSold = $reportData['productsSold'];
        $totalSales = $reportData['totalSales'];
        $totalOptSales = $reportData['totalOptSales'];

        return view('new_design.admin.reports.index', compact('productsSold', 'totalSales', 'totalOptSales', 'employeeName'));
    }

    public function monthlyReport(Request $request)
    {
        $search = $request->input('search');

        return view('new_design.admin.reports.monthly');
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

        return view('new_design.admin.reports.monthly', compact('productsSold', 'totalSales', 'dates', 'totalOptSales'));
    }
}
