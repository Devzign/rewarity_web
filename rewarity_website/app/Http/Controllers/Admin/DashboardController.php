<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();

        $metrics = [
            'totalUsers' => User::count(),
            'activeAdmins' => User::whereRaw('LOWER(user_type) = ?', ['admin'])->where('status', 'Active')->count(),
            'activeDealers' => User::whereRaw('LOWER(user_type) = ?', ['dealer'])->where('status', 'Active')->count(),
            'totalProducts' => Product::count(),
            'lowStockProducts' => Product::whereColumn('current_stock', '<=', 'low_stock_alert')->count(),
            'purchasesThisMonth' => Purchase::whereBetween('purchase_date', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->count(),
        ];

        $recentUsers = User::orderByDesc('created_at')->limit(5)->get();
        $recentProducts = Product::with('dealer')->orderByDesc('created_at')->limit(5)->get();
        $recentPurchases = Purchase::with(['product', 'dealer'])->orderByDesc('purchase_date')->limit(5)->get();

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'recentUsers' => $recentUsers,
            'recentProducts' => $recentProducts,
            'recentPurchases' => $recentPurchases,
            'pageHeading' => 'Dashboard',
        ]);
    }
}
