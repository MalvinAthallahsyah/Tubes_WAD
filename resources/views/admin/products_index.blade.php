<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>
    <div class="admin-layout-container">
        @include('admin.sidebar')

        <main class="admin-main-content">
            <div class="admin-page-header">
                <h1>Products List</h1>
            </div>

            <div class="admin-content-area">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ngecek dulu nih ada products apa enggak, biar gak error --}}
                            @if($products->count() > 0)
                                @foreach($products as $product)
                                <tr>
                                    {{-- $loop->iteration itu auto-numbering dari Laravel, jadi gak perlu bikin counter sendiri --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{-- Kalau ada gambar ya tampilin, kalau gak ada ya tulis 'No Image' --}}
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" width="50">
                                        @else
                                            <span class="no-image">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    {{-- Format harga jadi pake ribuan separator biar enak diliat --}}
                                    <td>{{ $product->category ? $product->category->name : 'Uncategorized' }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    {{-- Carbon itu library buat format tanggal --}}
                                    <td>{{ $product->created_at ? \Carbon\Carbon::parse($product->created_at)->format('d M Y H:i') : '-' }}</td>
                                    <td class="action-buttons">
                                        {{-- Form buat delete data, pake onclick confirm biar gak ke-delete kalau salah klik --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete product {{ $product->name }}?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                {{-- Kalau gak ada produk sama sekali, tampilin pesan ini --}}
                                <tr>
                                    <td colspan="8" class="no-products">No products found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
