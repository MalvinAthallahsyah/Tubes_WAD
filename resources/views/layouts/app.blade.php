<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Telkom Marketplace</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    {{-- Link for Material Icons if you are using them in the navbar --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
                         'Segoe UI Symbol', 'Noto Color Emoji';
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 flex flex-col min-h-screen">
    @php use Illuminate\Support\Facades\Auth; @endphp {{-- Moved Auth import here for clarity --}}
    <div id="app" class="flex-grow">
        <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50"> {{-- Changed shadow-md to shadow-sm to match screenshot --}}
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            {{-- Ensure this path is correct if you use an image --}}
                            <img src="{{ asset('images/Telkom Marketplace Logo.png') }}" alt="Logo" class="h-8 w-auto">
                            <span class="ml-2 text-lg font-semibold text-red-600 dark:text-red-500">Telkom Marketplace</span>
                        </a>
                    </div>

                    <div class="flex-grow max-w-xl mx-4 hidden md:flex">
                        {{-- Assuming you have a search route defined as 'search.perform' --}}
                        <form action="{{-- route('search.perform') --}}" method="GET" class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400 dark:text-gray-500">search</span>
                            </div>
                            <input type="search" name="query"
                                   class="block w-full pl-10 pr-12 py-2.5 border border-gray-300 dark:border-gray-600 rounded-full leading-5 bg-gray-50 dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                   placeholder="Find products, services, or users...">
                            <button type="submit" aria-label="Search" class="absolute inset-y-0 right-0 flex items-center justify-center px-3 m-0.5 bg-red-600 hover:bg-red-700 text-white rounded-full h-9 w-9 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800">
                                <span class="material-icons text-xl">search</span>
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <a href="#" aria-label="Chat" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="material-icons">chat_bubble_outline</span>
                        </a>
                        <a href="#" aria-label="Cart" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="material-icons">shopping_cart</span>
                        </a>
                        <a href="#" aria-label="Wishlist" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="material-icons">favorite_border</span>
                        </a>

                        {{-- Profile Dropdown --}}
                        @if(Auth::check())
                            <div class="ml-2 relative group" tabindex="0">
                                <button type="button" class="flex text-sm bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-red-500" id="user-menu-button-layout" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    @if(Auth::user()->profile_photo)
                                        <img class="h-9 w-9 rounded-full object-cover border-2 border-transparent group-hover:border-red-500" src="{{ asset('storage/profile_photos/'.Auth::user()->profile_photo) }}" alt="User profile">
                                    @else
                                        <span class="h-9 w-9 rounded-full bg-red-600 text-white flex items-center justify-center text-sm font-semibold border-2 border-transparent group-hover:border-white">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    @endif
                                </button>
                                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black dark:ring-gray-700 ring-opacity-5 focus:outline-none hidden group-hover:block group-focus-within:block py-1 z-20" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button-layout">
                                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                        <span class="material-icons text-lg mr-3">account_circle</span>My Profile
                                    </a>
                                    <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                        <span class="material-icons text-lg mr-3">inventory_2</span>My Products
                                    </a>
                                    <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                            <span class="material-icons text-lg mr-3">exit_to_app</span>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="ml-4 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">Login</a>
                            <a href="{{ route('register') }}" class="px-3 py-1.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">Register</a>
                        @endif
                    </div>
                </div>
                <div class="py-2 md:hidden">
                     <div class="relative w-full">
                        <form action="{{-- route('search.perform') --}}" method="GET">
                            <input type="search" name="query_mobile" id="search_mobile"
                                   class="block w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-full leading-5 bg-gray-50 dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                   placeholder="Find products, services...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400 dark:text-gray-500">search</span>
                            </div>
                             <button type="submit" aria-label="Search Mobile" class="absolute inset-y-0 right-0 flex items-center justify-center px-3 m-0.5 bg-red-600 hover:bg-red-700 text-white rounded-full h-9 w-9 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800">
                                 <span class="material-icons text-xl">search</span>
                             </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-700/30 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 p-4 mb-6 rounded-md shadow-lg flex items-start" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500 dark:text-green-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-700/30 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 p-4 mb-6 rounded-md shadow-lg flex items-start" role="alert">
                     <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500 dark:text-red-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-700/30 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 p-4 mb-6 rounded-md shadow-lg" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500 dark:text-red-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        </div>
                        <div class="ml-3">
                             <p class="font-bold">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Telkom Marketplace') }}. All rights reserved.</p>
        </footer>
    </div>{{-- End #app --}}
</body>
</html>