<ul class="navbar-nav bg-gradient-light sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center text-dark" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon text-primary">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="sidebar-brand-text mx-3 fw-bold">
            Trackify
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link text-dark" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt text-primary"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading text-muted">
        Master Data
    </div>

    <li class="nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
        <a class="nav-link text-dark" href="{{ route('activities.index') }}">
            <i class="fas fa-fw fa-history text-primary"></i>
            <span>Aktivitas</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 bg-secondary" id="sidebarToggle"></button>
    </div>

</ul>
