@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Product List</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

        <table class="table table-bordered text-center">
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
                                <img src="{{ asset('storage/' . $product->image_path) }}" width="80">
                            @endif
                        </td>
                        <td>
                            {{-- BUAT WADAH BARU DI SINI --}}
                            <div class="actions-box">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mb-3">Edit</a>

                                {{-- Tombol Delete --}}
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="form-delete-inline" onsubmit="return confirm('Are you sure want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary mb-3">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
