<?php

namespace App\Http\Controllers;

use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'foods' => function ($query) {
                $query->where('stock', '>', 0)
                    ->latest();
            }
        ])->get();

        $cart = session()->get('cart', []);

        return view('user.menu', compact('categories', 'cart'));
    }
}