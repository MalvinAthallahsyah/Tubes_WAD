@extends('layouts.app')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 md:p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-900 dark:text-gray-100">All Submitted Reviews</h2>
            {{-- Add any filter/search controls here if needed later --}}
        </div>

        @if($reviews->isEmpty())
            <p class="text-center text-gray-500 dark:text-gray-400 py-8">No reviews have been submitted yet.</p>
        @else
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                    @if($review->product)
                                        Review for Product: <a href="{{ route('products.show', $review->product) }}" class="hover:underline">{{ $review->product->name }}</a>
                                    @elseif($review->seller)
                                        Review for Seller: <a href="{{ route('sellers.show', $review->seller) }}" class="hover:underline">{{ $review->seller->name }}</a>
                                    @else
                                        General Review
                                    @endif
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    By: <span class="font-medium">{{ $review->user->name ?? 'Anonymous' }}</span> (User ID: {{ $review->user_id }})
                                </p>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex-shrink-0 ml-4">{{ $review->created_at->format('M d, Y, H:i') }}</span>
                        </div>
                        <p class="text-yellow-500 text-lg my-1">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                            <span class="text-sm text-gray-600 dark:text-gray-300 ml-1">({{ $review->rating }}/5)</span>
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm prose prose-sm dark:prose-invert max-w-none">{{ $review->comment }}</p>
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
                @endforeach
            </div>

            <div class="mt-8">
                {{ $reviews->links() }} {{-- Ensure your pagination views are styled with Tailwind --}}
            </div>
        @endif
    </div>
@endsection