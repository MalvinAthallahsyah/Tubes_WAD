        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="admin-brand">Admin Panel</a>
            </div>
            <ul class="admin-sidebar-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="nav-link-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Users</a></li>
                <li><a href="#" class="nav-link-item">Products</a></li> {{-- nanti ini juga akan kita buat --}}
            </ul>
            <div class="admin-sidebar-footer">
                <span>Hello, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-logout-button">Logout</button>
                </form>
            </div>
        </aside>
