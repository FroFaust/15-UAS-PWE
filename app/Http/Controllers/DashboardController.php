<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use App\Models\Order;

class DashboardController extends Controller
{
    public function user()
    {
        $user = auth()->user();

        $cart = session()->get('cart', []);

        $cartCount = collect($cart)->sum('quantity');

        $totalOrders = $user->orders()->count();

        $activeOrders = $user->orders()
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->count();

        $recentOrders = $user->orders()
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.user', compact(
            'cartCount',
            'totalOrders',
            'activeOrders',
            'recentOrders'
        ));
    }

    public function admin()
    {
        $totalFoods = Food::count();

        $totalCategories = Category::count();

        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'Menunggu')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalFoods',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'recentOrders'
        ));
    }
}
