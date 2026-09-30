<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingredient::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ingredients = $query->orderBy('category')->orderBy('name')->get();

        $stats = [
            'total'       => Ingredient::count(),
            'categories'  => Ingredient::distinct('category')->count('category'),
            'active'      => Ingredient::where('status', 'active')->count(),
            'coming_soon' => Ingredient::where('status', 'coming_soon')->count(),
            'inactive'    => Ingredient::where('status', 'inactive')->count(),
            'draft'       => Ingredient::where('status', 'draft')->count(),
        ];
        $categoryCounts = Ingredient::selectRaw('category, count(*) as cnt')
            ->groupBy('category')
            ->pluck('cnt', 'category');

        $trashed = Ingredient::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('admin.ingredients.index', compact('ingredients', 'stats', 'categoryCounts', 'trashed'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->attachUploads($request, $data);

        Ingredient::create($data);

        return redirect()->route('ingredients.index')
            ->with('success', 'Component "' . $data['name'] . '" added.');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $data = $this->validated($request);
        $this->attachUploads($request, $data);

        $ingredient->update($data);

        return redirect()->route('ingredients.index')
            ->with('success', 'Component "' . $ingredient->name . '" updated.');
    }

    /**
     * Quick status change (Draft / Coming Soon / Active / Inactive).
     * Route: PATCH /admin/ingredients/{ingredient}/status
     */
    public function updateStatus(Request $request, Ingredient $ingredient)
    {
        $request->validate(['status' => 'required|in:' . implode(',', Ingredient::STATUSES)]);

        $ingredient->update(['status' => $request->status]);

        return back()->with('success', $ingredient->name . ' is now ' . str_replace('_', ' ', $request->status) . '.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $name = $ingredient->name;

        // Soft delete: goes to Trash and can be restored. Uploaded files are kept.
        $ingredient->delete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Component "' . $name . '" moved to Trash.');
    }

    public function restore($id)
    {
        $ingredient = Ingredient::onlyTrashed()->findOrFail($id);
        $ingredient->restore();

        return redirect()->route('ingredients.index')
            ->with('success', 'Component "' . $ingredient->name . '" restored.');
    }

    public function forceDelete($id)
    {
        $ingredient = Ingredient::onlyTrashed()->findOrFail($id);
        $name = $ingredient->name;

        foreach (['model_path', 'thumbnail_path'] as $col) {
            if ($ingredient->$col) {
                Storage::disk('public')->delete($ingredient->$col);
            }
        }

        $ingredient->forceDelete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Component "' . $name . '" permanently deleted.');
    }
    private function validated(Request $request): array
    {
        return $request->validate([
            'name'             => 'required|string|max:255',
            'emoji'            => 'nullable|string|max:10',
            'category'         => 'required|in:' . implode(',', Ingredient::CATEGORIES),
            'price'            => 'required|numeric|min:0|max:999999.99',
            'price_two_tier'   => 'nullable|numeric|min:0|max:999999.99',
            'price_three_tier' => 'nullable|numeric|min:0|max:999999.99',
            'price_unit'       => 'nullable|string|max:50',
            'description'      => 'nullable|string|max:1000',
            'component_type'   => 'required|in:' . implode(',', Ingredient::COMPONENT_TYPES),
            'placement'        => 'nullable|in:' . implode(',', Ingredient::PLACEMENTS),
            'status'           => 'required|in:' . implode(',', Ingredient::STATUSES),
        ]);
    }

    private function attachUploads(Request $request, array &$data): void
    {
        if ($request->hasFile('model_file')) {
            $data['model_path'] = Storage::disk('public')->putFile('cake-components/models', $request->file('model_file'));
        }
        if ($request->hasFile('thumbnail_file')) {
            $data['thumbnail_path'] = Storage::disk('public')->putFile('cake-components/thumbnails', $request->file('thumbnail_file'));
        }
    }
}