<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Telkom Marketplace</title>
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
    <!-- Font Awesome buat icon mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Container utama -->
    <div class="container">
        <!-- Kotak login -->
        <div class="login-box">
            <!-- Bagian kiri (form login) -->
            <div class="left-side">
                <!-- Title disini -->
                <div class="logo">
                    <img src="{{ asset('images/logomarketplace.png') }}" alt="Telkom Marketplace Logo">
                </div>
                <!-- Header form login -->
                <h3 class="login-header">Login to Your Account</h3>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf <!-- directive Blade yang menghasilkan input hidden -->

                    <!-- Input email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="student@student.telkomuniversity.ac.id" required>

                        <!-- Ini buat nampilin pesan error -->
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="form-input"
                                   placeholder="Enter your password" required>
                            <span class="password-toggle" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye" id="togglePassword"></i>
                            </span>
                        </div>
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="button login-button">
                        Login
                    </button>
                </form>
                <!-- Pembatas OR -->
                <div class="divider">or</div>
                <!-- Tombol Login SSO -->
                <button class="button sso-button">
                    Login with iGracias SSO
                </button>
                <!-- register -->
                <div class="register-section">
                    <p class="register-text">Don't have an account? <a href="{{ route('register') }}" class="register-link">Register here</a></p>
                </div>
            </div>

            <!-- Bagian kanan (banner) -->
            <div class="right-side">
                <!-- Header banner -->
                <div class="text-center margin-bottom">
                    <h2 class="banner-title">Welcome to Telkom Marketplace</h2>
                    <p>Buy, sell, and exchange with the Telkom University community</p>
                </div>

                <!-- Fitur-fitur disini ya -->
                <div class="feature-box">
                    Student-to-student marketplace
                </div>

                <div class="feature-box">
                    Direct chat with sellers
                </div>

                <div class="feature-box">
                    Secure campus trading
                </div>
            </div>
        </div>
    </div>

    <script>
        // buat liatin password
        function togglePasswordVisibility() {
            // Ambil input password
            var passwordInput = document.getElementById("password");
            // Ambil icon mata
            var eyeIcon = document.getElementById("togglePassword");

            // Cek tipe inputnya apa
            if (passwordInput.type == "password") {
                // Ubah jadi text biar keliatan
                passwordInput.type = "text";
                eyeIcon.className = "fa fa-eye-slash";
            } else {
                // Ubah balik jadi password biar ga keliatan
                passwordInput.type = "password";
                eyeIcon.className = "fa fa-eye";
            }
        }
    </script>
</body>
</html>
