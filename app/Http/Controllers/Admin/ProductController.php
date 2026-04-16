<?php
// FILE: app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /* ─────────────────────────────────────────
     | INDEX
     ───────────────────────────────────────── */
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.products.index', compact('products'));
    }

    /* ─────────────────────────────────────────
     | STORE  (Add Product)
     ───────────────────────────────────────── */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'base_price'     => 'required|numeric|min:0',
            'is_active'      => 'nullable',
            'ingredient_ids' => 'nullable|string',   // comes as JSON string e.g. '["shape_2","flv_5"]'
        ]);

        // Decode the JSON string sent by the hidden field
        $ingredientIds = json_decode($request->input('ingredient_ids', '[]'), true) ?? [];

        Product::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'base_price'     => $request->base_price,
            'is_active'      => $request->has('is_active') ? 1 : 0,
            'ingredient_ids' => $ingredientIds,   // stored as JSON (cast: 'array' in model)
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $request->name . '" added successfully.');
    }

    /* ─────────────────────────────────────────
     | UPDATE  (Edit Product)
     ───────────────────────────────────────── */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'base_price'     => 'required|numeric|min:0',
            'is_active'      => 'nullable',
            'ingredient_ids' => 'nullable|string',
        ]);

        $ingredientIds = json_decode($request->input('ingredient_ids', '[]'), true) ?? [];

        $product->update([
            'name'           => $request->name,
            'description'    => $request->description,
            'base_price'     => $request->base_price,
            'is_active'      => $request->has('is_active') ? 1 : 0,
            'ingredient_ids' => $ingredientIds,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $request->name . '" updated successfully.');
    }

    /* ─────────────────────────────────────────
     | DESTROY  (Delete Product)
     ───────────────────────────────────────── */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product "' . $name . '" deleted.');
    }
}