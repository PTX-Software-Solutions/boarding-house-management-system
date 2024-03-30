<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">BH Locator and Reservation</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('management.dashboard') }}">
        <a class="nav-link" href="{{ route('management.dashboard') }}" wire:navigate>
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Nav Item - Boarding-House -->
    <li class="nav-item {{ Nav::isRoute('management.boarding-house') }}">
        <a class="nav-link" href="{{ route('management.boarding-house') }}" wire:navigate>
            <i class="fa fa-list-ul" aria-hidden="true"></i>
            <span>{{ __('Boarding Houses') }}</span></a>
    </li>

    <!-- Nav Item - Reservations -->
    <li class="nav-item {{ Nav::isRoute('management.reservations') }}">
        <a class="nav-link" href="{{ route('management.reservations') }}" wire:navigate>
            <i class="fa-solid fa-bars-progress"></i>
            <span>{{ __('Reservations') }}</span></a>
    </li>

    <!-- Nav Item - Confirmation -->
    <li class="nav-item {{ Nav::isRoute('management.confirmations') }}">
        <a class="nav-link" href="{{ route('management.confirmations') }}" wire:navigate>
            <i class="fa fa-check-square" aria-hidden="true"></i>
            <span>{{ __('Confirmations') }}</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
