@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 md:p-8">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2 text-center">
            @if(isset($review))
                Update Your Feedback for: {{ $reviewable->name }}
            @else
                Share Your Feedback on: {{ $reviewable->name }}
            @endif
        </h1>
        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-6">
            Your honest feedback helps other Telkom University students and supports student entrepreneurs on campus!
        </p>

        <form action="{{ isset($review) ? route('reviews.update', $review) : route('reviews.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @if(isset($review))
                @method('PUT')
            @endif

            {{-- Hidden product_id/seller_id --}}
            @if($type === 'product' && !isset($review))
                <input type="hidden" name="product_id" value="{{ $reviewable->id }}">
            @elseif($type === 'seller' && !isset($review))
                <input type="hidden" name="seller_id" value="{{ $reviewable->id }}">
            @endif

            {{-- Temporary User ID input - REMOVE WHEN AUTH IS INTEGRATED --}}
            @if(!isset($review))
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Your User ID (sementara aja ini buat ngetes) <span class="text-red-500">*</span>
                    (<a href="{{ route('show-users-for-id') }}" target="_blank" class="text-blue-500 hover:underline">Find Test IDs</a>)
                </label>
                <input type="number" name="user_id" id="user_id" value="{{ old('user_id', $review->user_id ?? '') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm @error('user_id') border-red-500 @enderror"
                       placeholder="Enter your user ID (e.g., 1)">
                @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @endif

            {{-- Overall Rating --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Your Rating for this {{ $type }} <span class="text-red-500">*</span>
                </label>
                {{-- Container for stars - Apply flex-row-reverse and justify-end for LTR visual order --}}
                <div class="mt-1 flex flex-row-reverse justify-end rating-stars-group">
                    @for ($i = 5; $i >= 1; $i--) {{-- Loop 5 down to 1 for correct DOM order with flex-row-reverse --}}
                    <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="sr-only rating-input" 
                           {{ (old('rating', $review->rating ?? 0) == $i) ? 'checked' : '' }} required>
                    <label for="rating{{ $i }}" class="star-label cursor-pointer p-0.5 sm:p-1 text-gray-300 dark:text-gray-600"> {{-- Reduced padding slightly --}}
                        <svg class="w-8 h-8 sm:w-9 sm:h-9 svg-star transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20"> {{-- Slightly smaller stars for denser packing if needed --}}
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    </label>
                    @endfor
                </div>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Review Title (Optional) --}}
             <div>
                <label for="review_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Feedback Headline <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span>
                </label>
                <input type="text" name="title" id="review_title" value="{{ old('title', $review->title ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm @error('title') border-red-500 @enderror"
                       placeholder="e.g., Great Service! or Item as Described">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Your Review Comment --}}
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Detailed Feedback <span class="text-xs text-gray-500 dark:text-gray-400">(Optional, but very helpful!)</span>
                </label>
                <textarea name="comment" id="comment" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm @error('comment') border-red-500 @enderror"
                          placeholder="What did you like or dislike? How was the service? Your insights help other students and support fellow student entrepreneurs.">{{ old('comment', $review->comment ?? '') }}</textarea>
                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Placeholder for Image/Video Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Add Photos <span class="text-xs text-gray-500 dark:text-gray-400">(Optional, max 3 files)</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label for="review_images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 dark:focus-within:ring-offset-gray-800 focus-within:ring-indigo-500">
                                <span>Upload files</span>
                                <input id="review_images" name="review_images[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG up to 5MB each. Max 3 images.</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex items-center justify-end space-x-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ $type === 'product' ? route('products.show', $reviewable->id) : route('sellers.show', $reviewable->id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                         <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    {{ isset($review) ? 'Update Feedback' : 'Submit Feedback' }}
                </button>
            </div>
        </form>
    </div>
@endsection