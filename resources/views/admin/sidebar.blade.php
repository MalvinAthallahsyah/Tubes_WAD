<aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                {{-- Link brand ke dashboard pake route() helper --}}
                <a href="{{ route('admin.dashboard') }}" class="admin-brand">Admin Panel</a>
            </div>
            <ul class="admin-sidebar-nav">
                {{-- Ini triknya nih! Pake request()->routeIs() buat highlight menu aktif, jadi keliatan lagi dimana --}}
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="nav-link-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Users</a></li>
                {{-- Nah kalo ini pake Request::routeIs() sama aja sih fungsinya, cuman ini bisa detect semua route yg dimulai dgn admin.products. --}}
                <li class="sidebar-menu-item {{ Request::routeIs('admin.products.*') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}" class="nav-link-item"><i class="fas fa-box"></i><span>Products</span></a></li>
            </ul>
            <div class="admin-sidebar-footer">
                {{-- Nampilin nama user yg lagi login pake Auth::user() --}}
                <span>Hello, {{ Auth::user()->name }}</span>
                {{-- Form logout deh, pake POST krn lebih aman drpd GET --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-logout-button">Logout</button>
                </form>
            </div>
        </aside>
