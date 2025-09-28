<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') · Rewarity</title>
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.css') }}">
    @stack('styles')
</head>
<body class="sidebar-main-active">
<div id="loading">
    <div id="loading-center">
        <div class="loader">
            <div class="cube">
                <div class="sides">
                    <div class="top"></div>
                    <div class="right"></div>
                    <div class="bottom"></div>
                    <div class="left"></div>
                    <div class="front"></div>
                    <div class="back"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    @include('admin.partials.sidebar')

    <div id="content-page" class="content-page">
        @php($pageHeading = trim($__env->yieldContent('page_heading', 'Dashboard')))
        @include('admin.partials.topbar', ['pageHeading' => $pageHeading])

        <div class="container-fluid">
            @include('admin.partials.flash')
            @yield('content')
        </div>
    </div>
</div>

<footer class="bg-white iq-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                Copyright {{ now()->year }} <a href="#">Rewarity</a> All Rights Reserved.
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.appear.js') }}"></script>
<script src="{{ asset('assets/admin/js/countdown.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/admin/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/smooth-scrollbar.js') }}"></script>
<script src="{{ asset('assets/admin/js/lottie.js') }}"></script>
<script src="{{ asset('assets/admin/js/chart-custom.js') }}"></script>
<script src="{{ asset('assets/admin/js/custom.js') }}"></script>
@stack('scripts')
</body>
</html>
