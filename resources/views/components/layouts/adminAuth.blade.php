<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Geo Dev">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'BH Locator & Reservation' }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/bh-favicon.png') }}" rel="icon" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Mapbox --}}
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('components.admin.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper"
            style="background-image: linear-gradient(to right, #03045e,#023e8a,#0077b6,#0096c7,#00b4d8, #48cae4, #90e0ef, #ade8f4, #caf0f8);"
            class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <livewire:admin.layout.topbar />

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('components.management.footer')
        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- @stack('scripts') --}}
</body>

</html>
