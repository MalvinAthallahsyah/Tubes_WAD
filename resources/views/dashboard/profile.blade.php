<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Telkom Marketplace</title>
    <!-- Icon Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-profile.css') }}">

</head>
<body>

    @include('navbar')


    <!-- Container profil -->
    <div class="profile-container">
        <!-- Judul dan tombol kembali -->
        <div class="profile-title">
            <h1>Profile</h1>
            <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
        </div>

        <!-- Form edit profil - ubah action ke route update profile -->
        <form class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Tampilkan pesan sukses -->
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Bagian foto profil -->
            <div class="photo-section">
                <!-- Tampilkan foto profil dari database jika ada -->
                <img src="{{ $user->profile_photo ? asset('profile_photos/'.$user->profile_photo) : asset('images/avatar.png') }}"
                     alt="Foto Profil" class="profile-photo">
                <br>
                <!-- Gunakan label sebagai tombol yang terhubung ke input file -->
                <label for="profile-photo-input" class="photo-btn">Change Photo</label>
                <!-- Input file akan triggered saat label diklik -->
                <input type="file" name="profile_photo" id="profile-photo-input" accept="image/*" style="display: none;">
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ $user->name }}">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input input-disabled" value="{{ $user->email }}" readonly>
                <div class="form-note">Email cannot be changed</div>
            </div>

            <!-- NIM dan No Telepon dalam 1 baris -->
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label" for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" class="form-input" value="{{ $user->nim }}">
                </div>

                <div class="form-col">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-input" value="{{ $user->phone }}">
                </div>
            </div>

            <!-- Fakultas dan Jurusan dalam 1 baris -->
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label" for="faculty">Faculty</label>
                    <input type="text" id="faculty" name="faculty" class="form-input" value="{{ $user->faculty }}">
                </div>

                <div class="form-col">
                    <label class="form-label" for="major">Major</label>
                    <input type="text" id="major" name="major" class="form-input" value="{{ $user->major }}">
                </div>
            </div>

            <!-- Bio -->
            <div class="form-group">
                <label class="form-label" for="bio">Bio</label>
                <textarea id="bio" name="bio" class="form-input" rows="3">{{ $user->bio }}</textarea>
            </div>

            <!-- Bagian Alamat -->
            <div class="address-section">
                <h3 class="address-title">Address</h3>

                <!-- Alamat Jalan -->
                <div class="form-group">
                    <label class="form-label" for="street">Street Address</label>
                    <input type="text" id="street" name="street" class="form-input" value="{{ $user->street_address }}">
                </div>

                <!-- Kota, Provinsi, Kode Pos dalam 1 baris -->
                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label" for="city">City</label>
                        <input type="text" id="city" name="city" class="form-input" value="{{ $user->city }}">
                    </div>

                    <div class="form-col">
                        <label class="form-label" for="province">Province</label>
                        <input type="text" id="province" name="province" class="form-input" value="{{ $user->province }}">
                    </div>

                    <div class="form-col">
                        <label class="form-label" for="postal">Postal Code</label>
                        <input type="text" id="postal" name="postal" class="form-input" value="{{ $user->postal_code }}">
                    </div>
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="button-row">
                <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
