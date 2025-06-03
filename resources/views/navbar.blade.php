@once
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
@endonce
{{-- @once karena dia mastiin CSS navbar kita cuma diload sekali aja, jadi ga dobel2 kalo ada include navbar berkali2 --}}

@php use Illuminate\Support\Facades\Auth; @endphp
{{-- Nah kita pake Auth buat ngecek user udah login apa belom, penting banget --}}

<nav class="navbar">
    <div class="navbar__logo-wrapper">
        <a href="{{ route('dashboard') }}" class="navbar__logo-link">
            <img src="{{ asset('images/Telkom Marketplace Logo.png') }}" alt="Logo Telkom Marketplace" class="navbar__logo-img">
            <span class="navbar__logo-text">Telkom Marketplace</span>
        </a>
    </div>

    <div class="navbar__search-wrapper">
        <input type="text" class="navbar__search-input" placeholder="Find products, services, or users...">
        <button class="navbar__search-button">
            <span class="material-icons">search</span>
        </button>
    </div>

    <div class="navbar__actions-wrapper">
        <div class="navbar__icons-group">
            <span class="material-icons navbar__icon">chat_bubble_outline</span>
            <span class="material-icons navbar__icon">shopping_cart</span>
            <span class="material-icons navbar__icon">favorite_border</span>
        </div>

        {{-- Profile Dropdown --}}
                @if(Auth::check())
                    <div class="ml-2 relative group" tabindex="0"> {{-- Pake tabindex buat keyboard accessibility --}}
                        {{-- User profile button --}}
                        <button type="button" class="flex text-sm bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-red-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span> {{-- Screen reader text --}}
                            {{-- Display user's profile photo atau first letter of name --}}
                            @if(Auth::user()->profile_photo)
                                <img class="h-9 w-9 rounded-full object-cover" src="{{ asset('storage/profile_photos/'.Auth::user()->profile_photo) }}" alt="User profile"> {{-- Display user's profile photo if available --}}
                            @else
                                <span class="h-9 w-9 rounded-full bg-red-600 text-white flex items-center justify-center text-sm font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }} {{-- Display first letter of user's name if ga ada profile photo --}}
                                </span>
                            @endif
                        </button>
                        {{-- Dropdown menu --}}
                        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black dark:ring-gray-700 ring-opacity-5 focus:outline-none hidden group-hover:block group-focus-within:block py-1 z-20" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
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
                    {{-- Login/Register buttons if usernya not authenticated --}}
                    <a href="{{ route('login') }}" class="ml-4 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">Register</a>
                @endif
            </div>
        </div>
    </div>
</nav>