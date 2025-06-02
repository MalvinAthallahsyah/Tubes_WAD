@extends('layouts.app')

@section('content')
    {{-- Product Details Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 mb-8">
        <div class="md:flex md:space-x-8">
            {{-- Product Image --}}
            <div class="md:w-1/3 mb-6 md:mb-0">
                <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                    {{-- UPDATED: Logic untuk menampilkan gambar produk aktual --}}
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        {{-- Fallback jika tidak ada gambar --}}
                        <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div class="md:w-2/3">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $product->name }}</h1>
                @if($product->seller)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1"> {{-- Mengurangi margin bottom jika kategori ditambahkan setelah ini --}}
                        Sold by: <a href="{{ route('sellers.show', $product->seller) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 font-medium">{{ $product->seller->name }}</a>
                    </p>
                @endif

                {{-- ADDED: Menampilkan kategori produk --}}
                @if($product->category)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Category: <span class="font-semibold">{{ $product->category->name }}</span> {{-- Asumsi model Category punya atribut 'name' --}}
                    </p>
                @endif

                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">{{ $product->description }}</p>

                {{-- Price & Stock Placeholder --}}
                <div class="mb-6">
                    <span class="text-3xl font-bold text-red-600 dark:text-red-500 mr-4">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                    <span class="text-sm font-medium {{ ($product->stock ?? 0) > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ ($product->stock ?? 0) > 0 ? 'In Stock' : 'Out of Stock' }} ({{ $product->stock ?? 0 }})
                    </span>
                </div>

                {{-- Action Buttons Placeholder --}}
                <div class="flex space-x-4">
                    <button type="button" class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Add to Cart
                    </button>
                    <button type="button" class="px-6 py-3 border border-red-600 text-red-600 hover:bg-red-50 dark:hover:bg-red-700/20 font-semibold text-sm rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Add to Wishlist
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl md:text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Customer Reviews
                </h3>
                @if($product->total_reviews > 0)
                    <div class="flex items-center mt-2">
                        <div class="flex items-center">
                            @php $rounded_rating = round($product->average_rating); @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $rounded_rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-700 dark:text-gray-300 font-semibold">{{ number_format($product->average_rating, 1) }} out of 5</span>
                        <span class="ml-3 text-gray-500 dark:text-gray-400 text-sm">based on {{ $product->total_reviews }} review{{ $product->total_reviews !== 1 ? 's' : '' }}</span>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">No reviews yet for this product.</p>
                @endif
            </div>
            <a href="{{ route('reviews.create.product', $product) }}"
               class="mt-4 md:mt-0 inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shrink-0">
                Write a Review
            </a>
        </div>

        {{-- This @if block wraps both histogram and review list --}}
        @if($product->total_reviews > 0 && isset($ratingDistribution))
        <div class="md:flex md:space-x-8 items-start">
            {{-- Review Histogram/Summary --}}
            <div class="md:w-1/3 mb-8 md:mb-0">
                <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-3">Rating Breakdown</h4>
                <div class="space-y-1.5">
                    @for ($i = 5; $i >= 1; $i--)
                        @php
                            $count = $ratingDistribution[$i] ?? 0;
                            $percentage = ($product->total_reviews > 0) ? ($count / $product->total_reviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center text-sm">
                            <span class="text-yellow-500 w-12 shrink-0">{{ $i }} star{{ $i > 1 ? 's' : '' }}</span>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mx-2">
                                <div class="bg-yellow-400 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 w-10 text-right shrink-0">{{ number_format($percentage, 0) }}%</span>
                            <span class="text-gray-400 dark:text-gray-500 w-12 text-right shrink-0">({{ $count }})</span>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Individual Reviews List --}}
            <div class="md:w-2/3 space-y-8">
                @forelse($product->reviews as $review)
                    <div class="flex space-x-3 sm:space-x-4 pb-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0 last:pb-0">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500 dark:bg-gray-700">
                                <span class="text-sm font-medium leading-none text-white">{{ strtoupper(substr($review->user->name ?? 'S', 0, 1)) }}</span>
                            </span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 text-sm sm:text-base">{{ $review->user->name ?? 'Telkom Student' }}</span>
                                    <span class="ml-2 text-xs text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-500/30 px-1.5 py-0.5 rounded-full font-medium">
                                        Verified Transaction
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center my-1">
                                @for ($s = 1; $s <= 5; $s++)
                                    <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                @endfor
                                <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">({{ $review->rating }}/5 Stars)</span>
                            </div>
                            @if(isset($review->title) && $review->title) {{-- Assuming 'title' is nullable string --}}
                                <h5 class="font-semibold text-md text-gray-800 dark:text-gray-200 mt-2 mb-1">{{ $review->title }}</h5>
                            @endif
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed prose prose-sm dark:prose-invert max-w-none">{{ $review->comment }}</p>

                            <div class="mt-3 flex items-center space-x-4 text-xs">
                                <button class="flex items-center text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.562 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.865 2.4z"/></svg>
                                    Helpful <span class="ml-1 text-gray-400 dark:text-gray-500">(0)</span>
                                </button>
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                @auth
                                    @if(Auth::id() == $review->user_id)
                                        <a href="{{ route('reviews.edit', $review) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">Delete</button>
                                        </form>
                                    @else
                                        <button class="text-gray-500 hover:text-orange-600 dark:text-gray-400 dark:hover:text-orange-400">Report</button>
                                    @endif
                                @else
                                     <a href="#" class="text-gray-400 dark:text-gray-500" title="Login to interact">Report (Login)</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600 dark:text-gray-400 py-8">Be the first to review this product!</p>
                @endforelse
            </div> {{-- Closes md:w-2/3 div (Individual Reviews List) --}}
        </div> {{-- Closes md:flex div (Histogram + Reviews List container) --}}
        @endif {{-- Closes @if($product->total_reviews > 0 && isset($ratingDistribution)) --}}
    </div> {{-- Closes "Reviews Section" card --}}
@endsection