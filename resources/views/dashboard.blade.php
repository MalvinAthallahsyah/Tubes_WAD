<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom Marketplace</title>
    <!-- Google icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="navbar">
        <!-- Logo part -->
        <div class="logo">
            <div class="logo-img">
                <img src="{{ asset('images/logo.png') }}" alt="Telkom Marketplace Logo">
            </div>
            <div class="logo-text">Telkom Marketplace</div>
        </div>

        <!-- Search box part -->
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search for products, services...">
            <button class="search-button">
                <span class="material-icons">search</span>
            </button>
        </div>

        <!-- Right side icons -->
        <div class="profile">
            <span class="material-icons profile-icon">person</span>
        </div>

        <div class="icons">
            <span class="material-icons nav-icon">chat_bubble_outline</span>
            <span class="material-icons nav-icon">shopping_cart</span>
            <span class="material-icons nav-icon">favorite_border</span>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="container">
        <h2>Welcome, {{ auth()->user()->name }}!</h2>
        <p>Email: {{ auth()->user()->email }}</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
