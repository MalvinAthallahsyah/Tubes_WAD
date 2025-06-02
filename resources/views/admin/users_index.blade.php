<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Bagian head berisi metadata dan link ke file CSS. --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>
    {{-- utama untuk tata letak halaman admin. --}}
    <div class="admin-layout-container">
        @include('admin.sidebar')

        {{--  area konten utama di sebelah kanan sidebar. --}}
        <main class="admin-main-content">
            <div class="admin-page-header">
                <h1>Users List</h1> {{-- Judul halaman. --}}
            </div>

            {{-- tempat tabel-tabel pengguna akan ditampilkan. --}}
            <div class="admin-content-area">

                {{-- menampilkan tabel untuk pengguna dengan peran 'Administrator'. --}}
                <h2>Administrators</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            {{-- baris header tabel berisi nama-nama kolom --}}
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Student ID</th>
                                <th>Phone</th>
                                <th>Faculty</th>
                                <th>Major</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if mengecek apakah ada data pengguna admin --}}
                            @if($adminUsers->count() > 0)
                                {{-- @foreach ini biar mengulang blok kode ini untuk setiap pengguna admin --}}
                                {{-- '$user' akan berisi data satu pengguna admin pada setiap putaran --}}
                                @foreach($adminUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nim ?: '-' }}</td>
                                    <td>{{ $user->phone ?: '-' }}</td>
                                    <td>{{ $user->faculty ?: '-' }}</td>
                                    <td>{{ $user->major ?: '-' }}</td>
                                    <td>{{ $user->role }}</td>
                                    {{-- Menampilkan tanggal pembuatan akun dengan format yang mudah dibaca. --}}
                                    <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') : '-' }}</td>
                                    <td class="action-buttons">
                                        {{-- 'route('admin.users.destroy', $user->id)' membuat URL buat penghapusan user --}}
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete user {{ $user->name }}?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                {{-- kalo ga ada pengguna admin, tampilkan pesan ini --}}
                                <tr>
                                    <td colspan="10" class="no-users">No users with admin role.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- menampilkan tabel untuk pengguna biasa Regular Users --}}
                {{-- Strukturnya mirip kek tabel Administrator di atas --}}
                <h2>Regular Users</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Student ID</th>
                                <th>Phone</th>
                                <th>Faculty</th>
                                <th>Major</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Mengecek apakah ada data pengguna biasa. --}}
                            @if($regularUsers->count() > 0)
                                {{-- Loop untuk setiap pengguna biasa. --}}
                                @foreach($regularUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nim ?: '-' }}</td>
                                    <td>{{ $user->phone ?: '-' }}</td>
                                    <td>{{ $user->faculty ?: '-' }}</td>
                                    <td>{{ $user->major ?: '-' }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') : '-' }}</td>
                                    <td class="action-buttons">
                                        {{-- tombol Delete untuk pengguna biasa. --}}
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete user {{ $user->name }}?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                {{-- Pesan jika tidak ada pengguna biasa. --}}
                                <tr>
                                    <td colspan="11" class="no-users">No regular users.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
