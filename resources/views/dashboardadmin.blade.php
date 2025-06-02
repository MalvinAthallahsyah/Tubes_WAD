{{-- filepath: c:\Users\Agung Wira\Desktop\TUBESSS\WAD GITHUB\resources\views\dashboardadmin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>

    {{-- adalah container utama yang akan membungkus sidebar dan konten --}}
    <div class="admin-layout-container">
        @include('admin.sidebar')

        {{-- konten Utama Halaman (sebelah kanan sidebar) --}}
        <main class="admin-main-content">

            {{-- Judul Halaman --}}
            <div class="admin-page-header">
                <h1>Admin Dashboard</h1>
            </div>

            {{-- Pesan Selamat Datang --}}
            <div class="admin-welcome-box">
                <p>Selamat datang di dashboard admin, {{ Auth::user()->name }}!</p>
            </div>

            {{-- Wadah untuk Info Card --}}
            <div class="admin-info-cards-container">
                {{-- card total Users --}}
                <div class="admin-info-card card-users">
                    <h5>Total Users</h5>
                    <p class="info-card-count">{{ \App\Models\User::count() }}</p>
                </div>

                {{-- card total Admins --}}
                <div class="admin-info-card card-admins">
                    <h5>Total Admins</h5>
                    <p class="info-card-count">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>

                {{-- card total Products --}}
                <div class="admin-info-card card-products">
                    <h5>Total Products</h5>
                    <p class="info-card-count">
                        @if(class_exists('App\Models\Product'))
                            {{ \App\Models\Product::count() }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>

        </main>

    </div>
</body>
</html>
