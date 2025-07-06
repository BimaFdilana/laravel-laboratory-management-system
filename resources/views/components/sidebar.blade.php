<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        @if (Auth::user()->role_id == 1)
            <div class="sidebar-brand">
                <a href="">Admin Page</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="">AP</a>
            </div>
        @else
            <div class="sidebar-brand">
                <a href="">Mahasiswa</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="">M</a>
            </div>
        @endif
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role_id == 1)
                <li class="{{ Request::is('mahasiswa*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('mahasiswa.index') }}">
                        <i class="fa-solid fa-user-graduate"></i> <span>List Mahasiswa</span>
                    </a>
                </li>
                <li class="menu-header">Laboratorium</li>
                <li class="{{ Request::is('labors*') ? 'active' : '' }}"> {{-- Menggunakan 'labors*' agar aktif untuk semua route di bawah /labors --}}
                    <a class="nav-link" href="{{ route('labors.index') }}"><i class="fa-solid fa-school">
                        </i> <span>List Laboratorium</span>
                    </a>
                </li>
                <li class="{{ Request::is('peminjaman*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('peminjaman.index') }}">
                        <i class="fa-solid fa-calendar"></i> <span>List Peminjaman</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li class="{{ Request::is('profile*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('profile.index') }}">
                        <i class="fa-solid fa-user"></i> <span>Profile</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>
