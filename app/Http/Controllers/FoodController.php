<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->latest()->get();

        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id',
            'name',
            'description',
            'price',
            'stock',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($data);

        return redirect()
            ->route('admin.foods.index')
            ->with('success', 'Makanan berhasil ditambahkan.');
    }

    public function edit(Food $food)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.foods.edit', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id',
            'name',
            'description',
            'price',
            'stock',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($data);

        return redirect()
            ->route('admin.foods.index')
            ->with('success', 'Makanan berhasil diperbarui.');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()
            ->route('admin.foods.index')
            ->with('success', 'Makanan berhasil dihapus.');
    }
}