<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Jumlah order
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersThisWeek = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $ordersThisMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Filter minggu (bisa diganti via request)
        $filterDate = $request->input('week');
        $start = $filterDate ? Carbon::parse($filterDate)->startOfWeek() : $startOfWeek;
        $end = $filterDate ? Carbon::parse($filterDate)->endOfWeek() : $endOfWeek;

        // Profit per hari di minggu yang dipilih
        $profits = Order::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(profit) as total_profit")
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy("date", "asc")
            ->get();

        return view('dashboard.index', compact(
            'ordersToday', 'ordersThisWeek', 'ordersThisMonth', 
            'profits', 'start', 'end', 'filterDate'
        ));
    }
}
