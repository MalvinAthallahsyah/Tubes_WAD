<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom Marketplace</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- Tambahkan style untuk link kartu jika perlu --}}
    <style>
        a.product-card-link {
            text-decoration: none; /* Menghilangkan garis bawah default dari link */
            color: inherit; /* Mewarisi warna teks dari parent */
            display: block; /* Membuat link mengambil seluruh area kartu */
        }
        a.product-card-link:hover .product-card { /* Contoh efek hover sederhana */
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        .product-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Untuk animasi hover */
        }
    </style>
</head>
<body>

    @include('navbar')

    <div class="container" style="padding: 20px;">
        <h2>Welcome, {{ $user->name }}!</h2>
        <p>Email: {{ $user->email }}</p>

        <hr style="margin-top: 20px; margin-bottom: 20px;">

        <h3 style="font-size: 1.5em; margin-bottom: 1em;">All Product</h3>

        @if(isset($products) && $products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    {{-- MODIFIKASI: Bungkus product-card dengan tag <a> --}}
                    <a href="{{ route('products.show', $product->id) }}" class="product-card-link">
                        <div class="product-card"> {{-- Class CSS Anda untuk kartu --}}
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300x200.png?text=No+Image+Available" alt="No Image Available">
                            @endif
                            <div class="content">
                                <h3>{{ $product->name }}</h3>
                                <p class="category">
                                    @if($product->category)
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    @else
                                        Uncategorized
                                    @endif
                                </p>
                                <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                {{-- <p>Stock: {{ $product->stock }}</p> --}}
                            </div>
                        </div>
                    </a>
                    {{-- AKHIR MODIFIKASI --}}
                @endforeach
            </div>
        @else
            <div class="no-products">
                <p>No products to display at the moment.</p>
            </div>
        @endif
        {{-- AKHIR BAGIAN PRODUK --}}

    </div>
</body>
</html>