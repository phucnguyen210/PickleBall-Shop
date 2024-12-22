<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller

{


    public function index()
    {

        $totalOrders = Order::where('status', '!=','cancelled')->count();
        $totalCustomers = User::where('role', 0)->count();
        $totalProducts = Product::count();
        $totalRevenus = Order::where('status', '!=','cancelled')->sum('grand_total');

        // this month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $revenueThisMonth = Order::where('status', '!=','cancelled')
        ->whereDate('created_at', '>=',  $startOfMonth)
        ->whereDate('created_at', '<=',  $currentDate)
        ->sum('grand_total');

        // last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndtDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('M');

        $revenueLastMonth = Order::where('status', '!=','cancelled')
        ->whereDate('created_at', '>=',  $lastMonthStartDate)
        ->whereDate('created_at', '<=',  $lastMonthEndtDate)
        ->sum('grand_total');

        // last 30 days sale
        $lastThirtyDayDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $revenueLastThirtyDays = Order::where('status', '!=','cancelled')
        ->whereDate('created_at', '>=',  $lastThirtyDayDate)
        ->whereDate('created_at', '<=',  $currentDate)
        ->sum('grand_total');


        return view('admin.dashboard',[
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalRevenus' => $totalRevenus,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueLastThirtyDays' => $revenueLastThirtyDays,
            'lastMonthName' => $lastMonthName

        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
