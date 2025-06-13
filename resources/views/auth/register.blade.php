<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telkom Marketplace</title>
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Cara import CSS langsung (untuk pemula) -->
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
    <style>
        /* Style tambahan untuk halaman register */
        body {
            font-family: 'Poppins', sans-serif;
        }
        .form-group-half {
            width: 48%;
            display: inline-block;
        }
        .form-group-half:first-child {
            margin-right: 3%;
        }
    </style>
</head>
<body>
    <!-- Container utama -->
    <div class="container">
        <!-- Kotak register -->
        <div class="login-box">
            <!-- Bagian kiri (form register) -->
            <div class="left-side">
                <!-- Judul -->
                <div class="logo">
                    <img src="{{ asset('images/Telkom Marketplace Logo.png') }}" alt="Telkom Marketplace Logo" style="width: 50px; height: 50px; object-fit: contain;">
                </div>
                <!-- Header form register -->
                <h3 class="login-header">Create Your Account</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="name">Username</label>
                        <input type="text" id="name" name="name" class="form-input"
                               value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input"
                               placeholder="student@student.telkomuniversity.ac.id"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Min. 8 characters" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input konfirmasi password -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-input" required>
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit" class="button login-button">
                        Register
                    </button>
                </form>

                <div class="register-section">
                    <p class="register-text">Already have an account? <a href="{{ route('login') }}" class="register-link">Login here</a></p>
                </div>
            </div>

            <!-- Bagian kanan (banner) -->
            <div class="right-side">
                <div class="text-center margin-bottom">
                    <h2 class="banner-title">Join Telkom Marketplace</h2>
                    <p>The place where Telkom University students buy and sell</p>
                </div>

                <!-- Fitur-fitur -->
                <div class="feature-box">
                    Create your own shop
                </div>

                <div class="feature-box">
                    Buy and sell without hassle
                </div>

                <div class="feature-box">
                    Verified campus community
                </div>
            </div>
        </div>
    </div>
</body>
</html>
