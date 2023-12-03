<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">BH Finder and Reservation</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('admin.dashboard') }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}" wire:navigate>
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('admin.boarding-house') }}">
        <a class="nav-link" href="{{ route('admin.boarding-house') }}" wire:navigate>
            <i class="fa fa-list-ul" aria-hidden="true"></i>
            <span>{{ __('Boarding House') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
