@once
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
@endonce
@php use Illuminate\Support\Facades\Auth; @endphp

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
      <span class="material-icons navbar__icon">chat_bubble_outline</span>
      <span class="material-icons navbar__icon">shopping_cart</span>
      <span class="material-icons navbar__icon">favorite_border</span>
    </div>

    <div class="navbar__profile-group" tabindex="0">
      @if(Auth::check() && Auth::user()->profile_photo)
        <img src="{{ asset('profile_photos/'.Auth::user()->profile_photo) }}"
             alt="Foto Profil Pengguna" class="navbar__profile-img">
      @else
        <span class="material-icons navbar__profile-icon-default">person</span>
      @endif

      <div class="navbar__dropdown-menu">
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
          <form action="{{ route('logout') }}" method="POST" class="navbar__logout-form">
            @csrf
            <button type="submit" class="navbar__logout-button">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>
