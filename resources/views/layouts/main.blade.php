<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Dashboard | Veltrix - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    @stack('top-style')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets')}}/images/favicon.ico">

    <link href="{{asset('assets')}}/libs/chartist/chartist.min.css" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="{{asset('assets')}}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('assets')}}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets')}}/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets')}}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    @yield('style')
</head>

<body data-sidebar="dark" style="min-height: 0 !important;">

<!-- Begin page -->
<div id="layout-wrapper">


    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('assets')}}/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{asset('assets')}}/images/logo-dark.png" alt="" height="17">
                                </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('assets')}}/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{asset('assets')}}/images/logo-light.png" alt="" height="18">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="d-none d-sm-block">
                    <div class="dropdown pt-3 d-inline-block">


                            <li class="nav-item d-none d-sm-inline-block">
                                <h5  class="nav-link text-dark">
                                    @if(!empty($page_title))
                                        {{$page_title}}
                                    @else
                                        Admin Panel
                                    @endif
                                </h5>
                            </li>


                    </div>
                </div>
            </div>

            <div class="d-flex">

                {{--Start Notifications --}}

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>

                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" style="">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-16"> Notifications </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar="init" style="max-height: 230px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">


                                                    <a href="#" class="text-reset notification-item">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="fa fa-bell"></i>
                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">topic</h6>
                                                                <div class="font-size-12 text-muted">
                                                                    <p class="mb-1">description.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>




                                            </div></div></div></div><div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none; height: 129px;"></div></div></div>
                        {{--                        <div class="p-2 border-top">--}}
                        {{--                            <div class="d-grid">--}}
                        {{--                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">--}}
                        {{--                                    View all--}}
                        {{--                                </a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>

                {{--End notifications --}}

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="rounded-circle header-profile-user fa fa-2x fa-user-circle" alt="Header Avatar"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                        <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog font-size-17 align-middle me-1"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{route('logout')}}"><i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                    </div>
                </div>



            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
@include('layouts.sidebar')
<!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">


                @yield('content')


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        © <script>document.write(new Date().getFullYear())</script> Accelle <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Tetralogicx.</span>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="{{asset('assets')}}/libs/jquery/jquery.min.js"></script>
<script src="{{asset('assets')}}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets')}}/libs/metismenu/metisMenu.min.js"></script>
<script src="{{asset('assets')}}/libs/simplebar/simplebar.min.js"></script>
<script src="{{asset('assets')}}/libs/node-waves/waves.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
    alertify.set('notifier','position', 'top-center');
    @if($msg =Session::get('success'))
    alertify.success("{{ $msg }}" );
    @endif
    @if($msg =Session::get('error'))
    alertify.error("{{ $msg }}" );
    @endif

    @if(count($errors->all()) > 0)
    @foreach ($errors->all() as $error)
    alertify.error("{{ $error }}");
    @endforeach
    @endif
</script>
<script src="{{asset('assets')}}/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="{{asset('assets')}}/js/app.js"></script>
<script>
    $(document).ready(function () {

    });
</script>
@yield('script')
</body>

</html>
