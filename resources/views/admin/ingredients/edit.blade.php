@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Ingredient</h2>

    <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $ingredient->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" value="{{ $ingredient->category }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $ingredient->price }}" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection