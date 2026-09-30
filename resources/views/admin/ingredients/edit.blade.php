@extends('layouts.admin')
@section('title', 'Edit Ingredient')

@push('styles')
<style>
.ce{
    --espresso:#24150F;--choc:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;
    --caramel:#A96F42;--gold:#B89452;--burgundy:#54252C;--taupe:#9A897A;--beige:#D8C8B7;
    --info:#4F6A7A;--info-soft:#E6ECEF;
    --danger:#8E3B3B;--danger-soft:#F6E7E5;
    font-family:'Plus Jakarta Sans',sans-serif;color:var(--espresso);
    padding:2rem 2.25rem 4rem;background:var(--ivory);min-height:100%;
}
.ce *,.ce *::before,.ce *::after{box-sizing:border-box;font-family:inherit;}

/* Header */
.ce-crumbs{display:flex;flex-wrap:wrap;align-items:center;gap:.5rem;font-size:.66rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--taupe);margin-bottom:1.25rem;}
.ce-crumbs .sep{color:var(--beige);}
.ce-crumbs .current{color:var(--caramel);}
.ce-head{padding-bottom:1.5rem;margin-bottom:2rem;border-bottom:1px solid var(--beige);position:relative;}
.ce-head::after{content:'';position:absolute;left:0;bottom:-1px;width:72px;height:2px;background:var(--gold);}
.ce-title{font-size:1.85rem;font-weight:800;letter-spacing:-.035em;line-height:1.1;margin:0 0 .5rem;}
.ce-sub{font-size:.85rem;color:var(--taupe);margin:0;max-width:52ch;line-height:1.55;}

/* Layout */
.ce-grid{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:1.75rem;align-items:start;max-width:1100px;}

/* Form surface */
.ce-card{background:#FFFDFA;border:1px solid var(--beige);border-radius:14px;box-shadow:0 1px 2px rgba(36,21,15,.04),0 10px 30px rgba(36,21,15,.05);overflow:hidden;}
.ce-card-head{display:flex;align-items:center;gap:.75rem;padding:1.1rem 1.5rem;background:var(--cream);border-bottom:1px solid var(--beige);}
.ce-card-icon{width:34px;height:34px;border-radius:9px;background:var(--espresso);color:var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ce-eyebrow{font-size:.62rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe);}
.ce-card-title{font-size:.9rem;font-weight:800;letter-spacing:-.01em;margin-top:2px;}
.ce-body{padding:1.75rem 1.5rem 1.5rem;display:flex;flex-direction:column;gap:1.5rem;}

/* Fields */
.ce-field{display:flex;flex-direction:column;gap:.45rem;}
.ce-label{display:flex;align-items:center;gap:.4rem;font-size:.66rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--choc);}
.ce-label svg{color:var(--caramel);}
.ce-help{font-size:.72rem;color:var(--taupe);line-height:1.5;margin:0;}
.ce-input,.ce-select{
    width:100%;height:46px;padding:0 .9rem;border:1px solid var(--beige);border-radius:10px;
    background:#fff;color:var(--espresso);font-size:.88rem;font-weight:500;
    transition:border-color .15s,box-shadow .15s;-webkit-appearance:none;appearance:none;
}
.ce-input:hover,.ce-select:hover{border-color:var(--taupe);}
.ce-input:focus,.ce-select:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.22);}
.ce-input--primary{height:54px;font-size:1rem;font-weight:700;letter-spacing:-.01em;}
.ce-select{padding-right:2.5rem;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239A897A' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .9rem center;}
.ce-money{display:flex;align-items:stretch;}
.ce-money-prefix{display:flex;align-items:center;padding:0 .95rem;background:var(--cream);border:1px solid var(--beige);border-right:none;border-radius:10px 0 0 10px;font-weight:800;color:var(--caramel);font-size:.95rem;transition:border-color .15s;}
.ce-money .ce-input{border-radius:0 10px 10px 0;font-variant-numeric:tabular-nums;font-weight:700;}
.ce-money:focus-within .ce-money-prefix{border-color:var(--gold);}
.ce-field.has-error .ce-input,.ce-field.has-error .ce-select,.ce-field.has-error .ce-money-prefix{border-color:var(--danger);}
.ce-error{font-size:.72rem;font-weight:600;color:var(--danger);background:var(--danger-soft);border-radius:6px;padding:.35rem .6rem;margin:0;}

/* Actions */
.ce-actions{display:flex;justify-content:flex-end;gap:.75rem;padding:1.15rem 1.5rem;border-top:1px solid var(--beige);background:var(--ivory);}
.ce-btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;height:44px;padding:0 1.35rem;border-radius:10px;font-size:.8rem;font-weight:800;letter-spacing:.01em;cursor:pointer;text-decoration:none;transition:background .15s,border-color .15s,box-shadow .15s,transform .15s;}
.ce-btn:focus-visible{outline:none;box-shadow:0 0 0 3px rgba(184,148,82,.4);}
.ce-btn--ghost{background:#fff;border:1px solid var(--beige);color:var(--choc);}
.ce-btn--ghost:hover{border-color:var(--taupe);background:var(--cream);}
.ce-btn--primary{border:1px solid var(--caramel);background:linear-gradient(135deg,var(--gold),var(--caramel));color:#fff;box-shadow:0 4px 14px rgba(169,111,66,.28);}
.ce-btn--primary:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(169,111,66,.34);}
.ce-btn--primary:active{transform:none;}

/* Side panel */
.ce-aside{background:var(--espresso);color:var(--cream);border-radius:14px;padding:1.5rem;position:relative;overflow:hidden;}
.ce-aside::before{content:'';position:absolute;left:0;top:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--caramel));}
.ce-aside-icon{width:36px;height:36px;border-radius:9px;border:1px solid rgba(184,148,82,.4);color:var(--gold);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;}
.ce-aside .ce-eyebrow{color:var(--gold);}
.ce-aside h2{font-size:1rem;font-weight:800;margin:.35rem 0 .6rem;letter-spacing:-.01em;color:#fff;}
.ce-aside p{font-size:.78rem;line-height:1.6;color:rgba(239,230,215,.72);margin:0;}
.ce-meta{margin:1.25rem 0 0;padding:1rem 0 0;border-top:1px solid rgba(216,200,183,.16);display:grid;gap:.7rem;}
.ce-meta div{display:flex;justify-content:space-between;gap:1rem;font-size:.72rem;}
.ce-meta dt{color:var(--taupe);font-weight:600;text-transform:uppercase;letter-spacing:.09em;font-size:.62rem;padding-top:1px;}
.ce-meta dd{margin:0;font-weight:700;color:var(--cream);text-align:right;word-break:break-word;}

@media(max-width:960px){
    .ce-grid{grid-template-columns:1fr;}
    .ce-aside{order:2;}
}
@media(max-width:640px){
    .ce{padding:1.25rem 1rem 3rem;}
    .ce-title{font-size:1.5rem;}
    .ce-actions{flex-direction:column-reverse;}
    .ce-btn{width:100%;}
    .ce-input,.ce-select{font-size:1rem;} /* prevents iOS zoom */
}
</style>
@endpush

@section('content')
@php
    // Category keys mirror the Cake Builder catalog used on the admin ingredients page.
    $categories = [
        'shape'      => 'Cake Shape',
        'cake_type'  => 'Cake Type',
        'cake_style' => 'Cake Style',
        'flavor'     => 'Flavor & Layers',
        'filling'    => 'Filling',
        'base_icing' => 'Borders & Icing',
        'texture'    => 'Texture',
        'drip'       => 'Drip',
        'fruit'      => 'Fruits',
        'choco'      => 'Chocolates',
        'sprinkle'   => 'Sprinkles',
        'candle'     => 'Candles & Toppers',
        'deco'       => 'Decorative Elements',
    ];
    $currentCategory = old('category', $ingredient->category);
    $indexAvailable  = \Illuminate\Support\Facades\Route::has('ingredients.index');
@endphp

<div class="ce">
    <nav class="ce-crumbs" aria-label="Breadcrumb">
        <span>Administration</span><span class="sep" aria-hidden="true">/</span>
        <span>Cake Components</span><span class="sep" aria-hidden="true">/</span>
        <span class="current" aria-current="page">Edit Component</span>
    </nav>

    <header class="ce-head">
        <h1 class="ce-title">Edit Ingredient</h1>
        <p class="ce-sub">Update the component information used throughout the BakeSphere customization catalog.</p>
    </header>

    <div class="ce-grid">
        <form class="ce-card" action="{{ route('ingredients.update', $ingredient) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="ce-card-head">
                <span class="ce-card-icon" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </span>
                <div>
                    <div class="ce-eyebrow">01 &middot; Component Information</div>
                    <div class="ce-card-title">Catalog entry details</div>
                </div>
            </div>

            <div class="ce-body">
                <div class="ce-field @error('name') has-error @enderror">
                    <label class="ce-label" for="ingredient-name">Component Name</label>
                    <input type="text" id="ingredient-name" name="name"
                           value="{{ old('name', $ingredient->name) }}"
                           class="ce-input ce-input--primary"
                           aria-describedby="name-help @error('name') name-error @enderror">
                    <p class="ce-help" id="name-help">The name displayed to administrators and used in the customization catalog.</p>
                    @error('name')<p class="ce-error" id="name-error">{{ $message }}</p>@enderror
                </div>

                <div class="ce-field @error('category') has-error @enderror">
                    <label class="ce-label" for="ingredient-category">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Category
                    </label>
                    <select id="ingredient-category" name="category" class="ce-select"
                            @error('category') aria-describedby="category-error" @enderror>
                        @unless(array_key_exists($currentCategory, $categories))
                            {{-- Keeps any existing value submittable even if it is not in the known list --}}
                            <option value="{{ $currentCategory }}" selected>{{ $currentCategory }}</option>
                        @endunless
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" @selected($currentCategory === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="ce-error" id="category-error">{{ $message }}</p>@enderror
                </div>

                <div class="ce-field @error('price') has-error @enderror">
                    <label class="ce-label" for="ingredient-price">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        Price
                    </label>
                    <div class="ce-money">
                        <span class="ce-money-prefix" aria-hidden="true">&#8369;</span>
                        <input type="number" step="0.01" min="0" id="ingredient-price" name="price"
                               value="{{ old('price', $ingredient->price) }}"
                               class="ce-input" inputmode="decimal"
                               aria-describedby="price-help @error('price') price-error @enderror">
                    </div>
                    <p class="ce-help" id="price-help">Amount in Philippine Peso.</p>
                    @error('price')<p class="ce-error" id="price-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="ce-actions">
                @if($indexAvailable)
                <a href="{{ route('ingredients.index') }}" class="ce-btn ce-btn--ghost">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Cancel
                </a>
                @endif
                <button type="submit" class="ce-btn ce-btn--primary">Update Ingredient</button>
            </div>
        </form>

        <aside class="ce-aside" aria-label="Catalog component information">
            <div class="ce-aside-icon" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div class="ce-eyebrow">Master Catalog</div>
            <h2>Catalog Component</h2>
            <p>This component is part of the BakeSphere customization catalog. Changes made here may affect the options available in the Cake Builder.</p>
            <dl class="ce-meta">
                <div><dt>Component ID</dt><dd>#{{ $ingredient->id }}</dd></div>
                <div><dt>Category</dt><dd>{{ $categories[$ingredient->category] ?? $ingredient->category }}</dd></div>
            </dl>
        </aside>
    </div>
</div>
@endsection