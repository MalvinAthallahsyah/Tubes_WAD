@extends('layouts.app')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 md:p-10 text-center max-w-3xl mx-auto">
        <h1 class="text-3xl sm:text-4xl font-bold text-red-600 dark:text-red-500 mb-6">
            Welcome to the Rating & Review System!
        </h1>

        <p class="text-lg text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
            This is where you'll manage and explore product and seller feedback.
        </p>
        <p class="text-gray-600 dark:text-gray-400 mb-8">
            If this is your first time, use the link in the header or the button below to set up some initial test data. This will allow you to see the review system in action.
        </p>

        <div class="space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('setup.test.data') }}"
               class="inline-block w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-md rounded-lg shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Setup Test Data (Dev)
            </a>
            {{-- You can add links to product/seller listing pages here once they exist --}}
            {{-- Example for "Browse Products" button:
            <a href="{{ route('products.index') }}"
               class="inline-block w-full sm:w-auto px-8 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-md rounded-lg shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Browse Products
            </a>
            --}}
        </div>

        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                After setting up data, try viewing examples:
                <a href="/products/1" class="text-indigo-600 hover:underline dark:text-indigo-400">View Product 1</a> or
                <a href="/sellers/1" class="text-indigo-600 hover:underline dark:text-indigo-400">View Seller 1</a>.
            </p>
        </div>
    </div>
@endsection