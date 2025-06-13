@once
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
@endonce
{{-- @once keren dia mastiin CSS navbar kita cuma diload sekali aja, jadi ga dobel2 kalo ada include navbar berkali2 --}}

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
        <input type="text" class="navbar__search-input" placeholder="Cari produk, layanan, atau pengguna...">
        <button class="navbar__search-button">
            <span class="material-icons">search</span>
        </button>
    </div>

    <div class="navbar__actions-wrapper">
        <div class="navbar__icons-group">
            <span class="material-icons navbar__icon">shopping_cart</span>
            <span class="material-icons navbar__icon">favorite_border</span>
        </div>

        <div class="navbar__profile-group" tabindex="0">
            {{-- bagian penting! Kalo user udah login dan punya foto, kita tampilin fotonya. Kalo ga ada, kita kasih icon default. Tabindex="0" bikin elemen bisa di-focus pake keyboard --}}
            @if(Auth::check() && Auth::user()->profile_photo)
                <img src="{{ asset('profile_photos/'.Auth::user()->profile_photo) }}"
                         alt="Foto Profil Pengguna" class="navbar__profile-img">
            @else
                <span class="material-icons navbar__profile-icon-default">person</span>
            @endif

            <div class="navbar__dropdown-menu">
                {{-- dropdown menu buat profile, bakal muncul pas di-hover atau di-focus --}}
                <div class="navbar__dropdown-item">
                    <span class="material-icons">account_circle</span>
                    <a href="{{ route('dashboard.profile') }}">Profil Saya</a>
                </div>
                <div class="navbar__dropdown-item">
                    <span class="material-icons">inventory</span>
                    <a href="{{ route('products.index') }}">Produk Saya</a>
                </div>
                <div class="navbar__dropdown-divider"></div>
                <div class="navbar__dropdown-item">
                    <span class="material-icons">exit_to_app</span>
                    {{-- Nah cara bikin tombol logout yang aman, pake form + CSRF token, jadi ga bisa di-hack pake CSRF attack --}}
                    <form action="{{ route('logout') }}" method="POST" class="navbar__logout-form">
                        @csrf
                        <button type="submit" class="navbar__logout-button">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
