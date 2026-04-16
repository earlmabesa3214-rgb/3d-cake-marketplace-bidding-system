<?php
// FILE: app/Http/Controllers/Admin/IngredientController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
public function index(Request $request)
    {
        $ingredients = Ingredient::orderBy('category')->orderBy('name');

        if ($request->filled('category')) {
            $ingredients->where('category', $request->category);
        }

        $ingredients = $ingredients->get();
        $products    = \App\Models\Product::orderBy('name')->get();

        return view('admin.ingredients.index', compact('ingredients', 'products'));
    }
    public function store(Request $request)
    {
  $request->validate([
            'name'        => 'required|string|max:255',
            'emoji'       => 'nullable|string|max:10',
            'category'    => 'required|in:shape,flavor,frosting,drip,fruit,choco,sprinkle,candle,deco',
            'price'       => 'required|numeric|min:0|max:999999.99',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'nullable|boolean',
        ]);

        Ingredient::create([
            'name'        => $request->name,
            'emoji'       => $request->emoji,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient "' . $request->name . '" added successfully.');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
  $request->validate([
            'name'        => 'required|string|max:255',
            'emoji'       => 'nullable|string|max:10',
            'category'    => 'required|in:shape,flavor,frosting,drip,fruit,choco,sprinkle,candle,deco',
            'price'       => 'required|numeric|min:0|max:999999.99',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'nullable|boolean',
        ]);

        $ingredient->update([
            'name'        => $request->name,
            'emoji'       => $request->emoji,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient "' . $ingredient->name . '" updated.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $name = $ingredient->name;
        $ingredient->delete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient "' . $name . '" deleted.');
    }
}