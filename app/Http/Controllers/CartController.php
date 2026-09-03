<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('user.cart', compact('cart'));
    }

    public function add(Request $request, Food $food)
    {
        if ($food->stock <= 0) {
            return $this->cartResponse(
                $request,
                'Makanan sudah habis.',
                false
            );
        }

        $quantity = max(1, (int) $request->quantity);

        if ($quantity > $food->stock) {
            return $this->cartResponse(
                $request,
                'Jumlah melebihi stok.',
                false
            );
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$food->id])) {

            $newQuantity =
                $cart[$food->id]['quantity'] + $quantity;

            if ($newQuantity > $food->stock) {
                return $this->cartResponse(
                    $request,
                    'Jumlah melebihi stok.',
                    false
                );
            }

            $cart[$food->id]['quantity'] = $newQuantity;

        } else {

            $cart[$food->id] = [
                'id' => $food->id,
                'name' => $food->name,
                'price' => $food->price,
                'quantity' => $quantity,
                'image' => $food->image,
            ];
        }

        session()->put('cart', $cart);

        return $this->cartResponse(
            $request,
            'Makanan ditambahkan ke keranjang.',
            true,
            $cart[$food->id]['quantity']
        );
    }

    public function update(Request $request, Food $food)
    {
        $quantity = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if ($quantity <= 0) {

            unset($cart[$food->id]);

            session()->put('cart', $cart);

            return $this->cartResponse(
                $request,
                'Makanan dihapus dari keranjang.',
                true,
                0
            );
        }

        if ($quantity > $food->stock) {
            return $this->cartResponse(
                $request,
                'Jumlah melebihi stok.',
                false
            );
        }

        if (isset($cart[$food->id])) {
            $cart[$food->id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return $this->cartResponse(
            $request,
            'Keranjang diperbarui.',
            true,
            $quantity
        );
    }

    public function remove(Request $request, Food $food)
    {
        $cart = session()->get('cart', []);

        unset($cart[$food->id]);

        session()->put('cart', $cart);

        return $this->cartResponse(
            $request,
            'Makanan dihapus dari keranjang.',
            true,
            0
        );
    }

    private function cartResponse(
        Request $request,
        string $message,
        bool $success,
        int $quantity = 0
    ) {
        if ($request->expectsJson()) {

            return response()->json([
                'success' => $success,
                'message' => $message,
                'quantity' => $quantity,
            ]);
        }

        if ($success) {
            return back()->with('success', $message);
        }

        return back()->with('error', $message);
    }
}