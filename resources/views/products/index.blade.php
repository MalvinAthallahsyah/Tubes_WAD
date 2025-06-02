@extends('layouts.app')

{{-- Tambahkan section ini untuk me-link product.css --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')

    <div class="container">
        <h1 class="product-page-title">Product List</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-add-product mb-3">Add Product</a>

        <table class="table table-bordered text-center product-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>Rp.{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                            @endif
                        </td>
                        <td>
                            <div class="actions-box">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="form-delete-inline" onsubmit="return confirm('Are you sure want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
