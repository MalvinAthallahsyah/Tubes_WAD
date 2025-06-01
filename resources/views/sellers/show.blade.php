@extends('layouts.app')

@section('content')
    {{-- Product/Seller Details Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $product->name ?? $seller->name }}</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $product->description ?? $seller->description }}</p>

        @if(isset($product) && $product->seller)
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Sold by: <a href="{{ route('sellers.show', $product->seller) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 font-medium">{{ $product->seller->name }}</a>
            </p>
        @endif

        {{-- Aggregate Rating & Review Button Section --}}
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    @if(isset($product))
                        Average Rating:
                        @if($product->average_rating)
                            <span class="text-yellow-500 ml-1">{{ number_format($product->average_rating, 1) }} / 5</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">({{ $product->total_reviews }} review{{ $product->total_reviews !== 1 ? 's' : '' }})</span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400 ml-1">No ratings yet.</span>
                        @endif
                    @elseif(isset($seller))
                        Seller Reputation:
                        @if($seller->reputation_score)
                            <span class="text-yellow-500 ml-1">{{ number_format($seller->reputation_score, 1) }} / 5</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">({{ $seller->total_seller_reviews }} review{{ $seller->total_seller_reviews !== 1 ? 's' : '' }})</span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400 ml-1">No direct seller reviews yet.</span>
                        @endif
                    @endif
                </p>
                <a href="{{ isset($product) ? route('reviews.create.product', $product) : route('reviews.create.seller', $seller) }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Leave a Review
                </a>
            </div>
        </div>
    </div>

    {{-- Reviews List Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8">
        <h3 class="text-xl md:text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
            {{ isset($product) ? 'Customer Reviews' : 'Seller Reviews' }}
        </h3>
        @forelse($product->reviews ?? $seller->reviews as $review)
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="text-md font-semibold text-gray-800 dark:text-gray-200">{{ $review->user->name ?? 'Anonymous' }}</p>
                        <p class="text-yellow-500 text-lg">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </p>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed prose prose-sm dark:prose-invert max-w-none">{{ $review->comment }}</p>

                {{-- Edit/Delete Links --}}
                {{-- NOTE: Authorization logic will be handled by auth module --}}
                <div class="mt-3 text-xs flex items-center space-x-3">
                    <a href="{{ route('reviews.edit', $review) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No reviews yet. Be the first!</p>
        @endforelse
    </div>
@endsection