<div>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li id="parentDiv" class="nav-item dropdown no-arrow">
                <a id="toggleButton" class="nav-link dropdown-toggle" href="#" role="button"
                    aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->firstName }}</span>
                    <div class="img-profile rounded-circle avatar font-weight-bold" data-initial="">
                        <img src="{{ asset('storage/images/' . Auth::user()->profileImage) }}" alt="">
                        {{-- <img src="{{ asset('storage/images/public/images/' . Auth::user()->profileImage) }}" alt=""> --}}
                        {{-- <img src="{{ url('storage/images/public/images/' . Auth::user()->profileImage) }}" alt=""> --}}
                        {{-- <img src="{{ Storage::disk('s3')->url('photos/client/' . Auth::user()->profileImage) }}"
                            alt="Profile Image"> --}}
                    </div>
                </a>

                <div id="contentsss" class="dropdown-menu dropdown-menu-right shadow">
                    <a class="dropdown-item" href="#" wire:click="profile">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"
                        wire:click="">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Logout') }}
                    </a>
                </div>

            </li>

            {{-- <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow {{ $topBar ? 'show' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" role="button"
                    aria-expanded="{{ $topBar ? 'true' : 'false' }}" wire:click="onChangeUserOption">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->firstName }}</span>
                    <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial=""></figure>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow {{ $topBar ? 'show' : '' }}">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Settings') }}
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Activity Log') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"
                        wire:click="">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Logout') }}
                    </a>
                </div>

            </li> --}}

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true" data-navigate-track>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link" type="button"
                                data-dismiss="modal">{{ __('Cancel') }}</button>
                            <a class="btn btn-danger" href="#" wire:click="logout">{{ __('Logout') }}</a>
                        </div>
                    </div>
                </div>
            </div>

        </ul>

    </nav>
    <!-- End of Topbar -->

</div>

<script data-navigate-track>
    document.addEventListener('livewire:init', () => {
        var isOpen = false;
        var toggleButton = document.getElementById('toggleButton');
        var content = document.getElementById('contentsss');
        var parentDiv = document.getElementById('parentDiv');

        parentDiv.addEventListener('click', function() {

            if (!isOpen) {
                isOpen = true;
                content.classList.add("show");
                parentDiv.classList.add("show");
                toggleButton.setAttribute("aria-expanded", "true");
            } else {
                isOpen = false;
                content.classList.remove("show");
                parentDiv.classList.remove("show");
                toggleButton.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener('click', function(event) {
            var isClickInside = parentDiv.contains(event.target) || content.contains(event.target);

            if (!isClickInside && isOpen) {
                isOpen = false;
                content.classList.remove("show");
                parentDiv.classList.remove("show");
                toggleButton.setAttribute("aria-expanded", "false");
            }
        });
    })

    document.addEventListener('livewire:navigated', () => {
        var isOpen = false;
        var toggleButton = document.getElementById('toggleButton');
        var content = document.getElementById('contentsss');
        var parentDiv = document.getElementById('parentDiv');

        parentDiv.addEventListener('click', function() {

            if (!isOpen) {
                isOpen = true;
                content.classList.add("show");
                parentDiv.classList.add("show");
                toggleButton.setAttribute("aria-expanded", "true");
            } else {
                isOpen = false;
                content.classList.remove("show");
                parentDiv.classList.remove("show");
                toggleButton.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener('click', function(event) {
            var isClickInside = parentDiv.contains(event.target) || content.contains(event.target);

            if (!isClickInside && isOpen) {
                isOpen = false;
                content.classList.remove("show");
                parentDiv.classList.remove("show");
                toggleButton.setAttribute("aria-expanded", "false");
            }
        });
    })
</script>
