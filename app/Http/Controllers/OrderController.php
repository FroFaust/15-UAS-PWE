<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderDetails.food');

        return view('user.order-detail', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }
}