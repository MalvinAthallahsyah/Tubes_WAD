{{-- dashboard.blade.php - Refactored with Tailwind --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom Marketplace</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    @include('navbar') {{-- Assumes this is the primary navbar for this page --}}

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Welcome, {{ $user->name ?? 'Guest' }}!</h1>
            @if(isset($user))
            <p class="text-gray-600 dark:text-gray-400">Email: {{ $user->email }}</p>
            @endif
        </div>

        <hr class="my-6 border-gray-200 dark:border-gray-700">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Explore Products</h2>
            {{-- <a href="#" class="text-sm text-red-600 hover:text-red-700 font-medium">View All &rarr;</a> --}}
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="block group">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 ease-in-out transform group-hover:-translate-y-1">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">
                                    @if($product->category)
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    @else
                                        Uncategorized
                                    @endif
                                </p>
                                <p class="text-lg font-bold text-red-600 dark:text-red-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                {{-- <p class="text-sm text-gray-600 dark:text-gray-300">Stock: {{ $product->stock }}</p> --}}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No Products Yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Check back soon or start selling your own!</p>
              </div>
        @endif
    </div>
</body>
</html>