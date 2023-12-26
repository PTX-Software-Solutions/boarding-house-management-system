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
    <li class="nav-item {{ Nav::isRoute('user.home') }}">
        <a class="nav-link" href="{{ route('user.home') }}" wire:navigate>
            <i class="fa fa-search" aria-hidden="true"></i>
            <span>{{ __('Find Boarding House') }}</span></a>
    </li>

    <li class="nav-item {{ Nav::isRoute('user.reservation*') }}">
        <a class="nav-link" href="{{ route('user.reservation') }}" wire:navigate>
            <i class="fas fa-list-alt"></i>
            <span>{{ __('Reservations') }}</span></a>
    </li>

    <li class="nav-item {{ Nav::isRoute('user.transaction') }}">
        <a class="nav-link" href="{{ route('user.transaction') }}" wire:navigate>
            <i class="fas fa-ticket"></i>
            <span>{{ __('Transactions') }}</span></a>
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
