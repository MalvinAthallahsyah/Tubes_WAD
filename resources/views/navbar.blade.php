@once
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
@endonce

@php use Illuminate\Support\Facades\Auth; @endphp
<!-- Navbar -->
<div class="navbar">
    <!-- Logo -->
    <div class="logo">
        <div class="logo-img">
            <img src="{{ asset('images/Telkom Marketplace Logo.png') }}" alt="Logo">
        </div>
        <div class="logo-text">Telkom Marketplace</div>
    </div>

    <!-- Kotak pencarian -->
    <div class="search-box">
        <input type="text" class="search-input" placeholder="Cari produk...">
        <button class="search-button">
            <span class="material-icons">search</span>
        </button>
    </div>

    <!-- Icon kanan -->
    <div class="profile" tabindex="0">
        @if(Auth::check() && Auth::user()->profile_photo)
            <img src="{{ asset('profile_photos/'.Auth::user()->profile_photo) }}"
                 alt="Foto Profil" class="profile-icon-img">
        @else
            <span class="material-icons profile-icon">person</span>
        @endif

        <!-- Menu dropdown profil -->
        <div class="profile-dropdown">
            <div class="dropdown-item">
                <span class="material-icons">account_circle</span>
                <a href="{{ route('dashboard.profile') }}">Profil Saya</a>
            </div>
            <div class="dropdown-item">
                <span class="material-icons">inventory</span>
                <a href="{{ route('products.index') }}">Produk Saya</a>
            </div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-item">
                <span class="material-icons">exit_to_app</span>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-dropdown-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Icon lainnya -->
    <div class="icons">
        <span class="material-icons nav-icon">chat_bubble_outline</span>
        <span class="material-icons nav-icon">shopping_cart</span>
        <span class="material-icons nav-icon">favorite_border</span>
    </div>
</div>
