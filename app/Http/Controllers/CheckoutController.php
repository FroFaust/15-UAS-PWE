<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $order = DB::transaction(function () use ($cart) {

            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'total' => $total,
                'status' => 'Menunggu',
            ]);

            foreach ($cart as $item) {

                $food = Food::find($item['id']);

                if (!$food) {
                    throw new \Exception(
                        "Makanan {$item['name']} tidak ditemukan."
                    );
                }

                if ($food->stock < $item['quantity']) {
                    throw new \Exception(
                        "Stok {$item['name']} tidak mencukupi."
                    );
                }

                $subtotal = $food->price * $item['quantity'];

                $order->orderDetails()->create([
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'price' => $food->price,
                    'subtotal' => $subtotal,
                ]);

                $food->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat.');
    }
}