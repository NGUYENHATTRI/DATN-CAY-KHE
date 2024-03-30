<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ isset($title) ? $title : 'Trang chủ' }} - Admin</title>
    @yield('meta')
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin dashboard template,admin panel html,bootstrap dashboard,admin dashboard,html template,template dashboard html,html css,bootstrap 5 admin template,bootstrap admin template,bootstrap 5 dashboard,admin panel html template,dashboard template bootstrap,admin dashboard html template,bootstrap admin panel,simple html template,admin dashboard bootstrap">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/admin/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/admin/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/admin/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('assets/admin/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="{{ asset('assets/admin/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/jsvectormap/css/jsvectormap.min.css') }}">
    @yield('css')
    @notifyCss
    <style>
        .side-menu__icon {
            font-size: 20px !important;
            line-height: 20px !important;
        }

    </style>
</head>

<body>
    @include('notify::components.notify')



    <!-- Loader -->
    {{-- <div id="loader">
        <img src="{{ asset('assets/admin/images/media/loader.svg') }}" alt="">
    </div> --}}
    <!-- Loader -->

    <div class="page">
        <!-- app-header -->
        @include('admin.blocks.header')
        <!-- /app-header -->

        <!-- Start::Off-canvas sidebar-->
        @include('admin.blocks.switcher')
        <!-- End::Off-canvas sidebar-->
        @include('admin.blocks.offcanvas')
        @include('admin.blocks.modal')
        <!-- Start::app-sidebar -->
        @include('admin.blocks.sidebar')
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            @yield('content')
        </div>
        <!-- End::app-content -->

        <!-- Footer Start -->
        @include('admin.blocks.footer')
        <!-- Footer End -->

    </div>


    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="las la-angle-double-up"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Popper JS -->
    <script src="{{ asset('assets/admin/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('assets/admin/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('assets/admin/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/simplebar.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('assets/admin/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>


    <!-- Apex Charts JS -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- JSVector Maps JS -->
    <script src="{{ asset('assets/admin/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('assets/admin/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('assets/admin/js/us-merc-en.js') }}"></script>

    <!-- Chartjs Chart JS -->
    <script src="{{ asset('assets/admin/js/index.js') }}"></script>


    <!-- Custom-Switcher JS -->
    <script src="{{ asset('assets/admin/js/custom-switcher.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
    @yield('js')
    @notifyJs
</body>

</html>
