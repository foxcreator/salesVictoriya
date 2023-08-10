<?php
$cart = session()->get('cart');
?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales CRM | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- main -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">

{{--    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">--}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
{{--    <div class="preloader flex-column justify-content-center align-items-center">--}}
{{--        <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">--}}
{{--    </div>--}}
    @if (session('status'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('status') }}");
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}");
            });
        </script>
    @endif
    <!-- Navbar -->
    @auth()
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">{{__('messages.Sales_page')}}</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('cart') }}">
                    {{__('messages.Open_check')}}

                    <i class="fas fa-receipt"></i>
                    @if(session()->get('cart', []))
                        <span class="badge badge-warning navbar-badge">{{ count($cart) }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">


            <!-- Notifications Dropdown Menu -->

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    @endauth

    <!-- /.navbar -->

    @auth()
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            {{--            <i class="fas fa-record-vinyl fa-lg"></i>--}}
{{--            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
            <span class="brand-text font-weight-light">BSV-CRM</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-olive"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>

            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="
                        @if(Auth::user()->role === 'admin')
                        {{ route('admin.home') }}
                        @else
                        {{ route('home') }}
                        @endif
                            " class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('messages.Home') }}
                            </p>
                        </a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                {{ __('messages.Products') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.product') }}" class="nav-link">
                                    <i class="nav-icon fas fa-stream"></i>
                                    <p>{{ __('messages.All_products') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.product.create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-folder-plus"></i>
                                    <p>{{ __('messages.Add_product') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.category.create') }}" class="nav-link">
                                    <i class="nav-icon far fa-plus-square"></i>
                                    <p>{{ __('messages.Add_category') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                {{ __('messages.Reports') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.reports') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-day"></i>
                                    <p>{{ __('messages.Daily_report') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.monthly') }}" class="nav-link">
                                    <i class="nav-icon far fa-calendar"></i>
                                    <p>{{ __('messages.Monthly_report') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                {{ __('messages.Stock') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.stock.first_step') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plus-square"></i>
                                    <p>{{ __('messages.New_delivery') }}</p>
                                </a>
                            </li>
                            @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.stock') }}" class="nav-link">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>{{ __('messages.Deliveries') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers') }}" class="nav-link">
                                    <i class="nav-icon fas fa-male"></i>
                                    <p>{{ __('messages.Suppliers') }}</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link disabled">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Расходы
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/forms/general.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Elements</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/advanced.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Advanced Elements</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/editors.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Editors</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/forms/validation.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Validation</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">Авторизация</li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('messages.Users') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="pages/tables/simple.html" class="nav-link">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>{{ __('messages.Add_employee') }}</p>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>{{ __('messages.Logout') }}</p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li class="nav-item">
                                <a href="pages/tables/jsgrid.html" class="nav-link disabled">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <p>{{ __('messages.Info') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                {{ __('messages.Language') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('change.language', 'en') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>English</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('change.language', 'uk') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Українська</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('change.language', 'ru') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Русский</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @endauth
    @yield('content')
    <footer class="main-footer">
        <strong>Copyright &copy; 2018-{{ now()->year }} <a href="https://adminlte.io">BSV-CRM </a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.3
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

{{--<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>--}}

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    const urlParams = new URLSearchParams(window.location.search);
    const locale = urlParams.get('locale');
    if (locale) {
        document.documentElement.lang = locale;
        window.localStorage.setItem('locale', locale);
    } else {
        const storedLocale = window.localStorage.getItem('locale');
        if (storedLocale) {
            document.documentElement.lang = storedLocale;
        }
    }
</script>
</body>
</html>
