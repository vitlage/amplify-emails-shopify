<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Form Wizard | Veltrix - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Bootstrap Css -->
    <link href="{{asset('')}}assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('')}}assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('')}}assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <style>
        .wizard>.steps>ul>li {
            width: 50%;
        }
    </style>
</head>

<body data-sidebar="dark">
<!-- Begin page -->
<div id="layout-wrapper">


    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('')}}assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{asset('')}}assets/images/logo-dark.png" alt="" height="17">
                                </span>
                    </a>

                    <a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('')}}assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{asset('')}}assets/images/logo-light.png" alt="" height="18">
                                </span>
                    </a>
                </div>


            </div>

            <div class="d-flex">

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    {{--<div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Main</li>

                    <li>
                        <a href="index.html" class="waves-effect">
                            <i class="ti-home"></i><span class="badge rounded-pill bg-primary float-end">2</span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="calendar.html" class=" waves-effect">
                            <i class="ti-calendar"></i>
                            <span>Calendar</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-email"></i>
                            <span>Email</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="email-inbox.html">Inbox</a></li>
                            <li><a href="email-read.html">Email Read</a></li>
                            <li><a href="email-compose.html">Email Compose</a></li>
                        </ul>
                    </li>

                    <li class="menu-title">Components</li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-package"></i>
                            <span>UI Elements</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="ui-alerts.html">Alerts</a></li>
                            <li><a href="ui-buttons.html">Buttons</a></li>
                            <li><a href="ui-cards.html">Cards</a></li>
                            <li><a href="ui-carousel.html">Carousel</a></li>
                            <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                            <li><a href="ui-grid.html">Grid</a></li>
                            <li><a href="ui-images.html">Images</a></li>
                            <li><a href="ui-lightbox.html">Lightbox</a></li>
                            <li><a href="ui-modals.html">Modals</a></li>
                            <li><a href="ui-offcanvas.html">Offcanvas</a></li>
                            <li><a href="ui-rangeslider.html">Range Slider</a></li>
                            <li><a href="ui-session-timeout.html">Session Timeout</a></li>
                            <li><a href="ui-progressbars.html">Progress Bars</a></li>
                            <li><a href="ui-sweet-alert.html">SweetAlert 2</a></li>
                            <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
                            <li><a href="ui-typography.html">Typography</a></li>
                            <li><a href="ui-video.html">Video</a></li>
                            <li><a href="ui-general.html">General</a></li>
                            <li><a href="ui-colors.html">Colors</a></li>
                            <li><a href="ui-rating.html">Rating</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ti-receipt"></i>
                            <span class="badge rounded-pill bg-success float-end">6</span>
                            <span>Forms</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="form-elements.html">Form Elements</a></li>
                            <li><a href="form-validation.html">Form Validation</a></li>
                            <li><a href="form-advanced.html">Form Advanced</a></li>
                            <li><a href="form-editors.html">Form Editors</a></li>
                            <li><a href="form-uploads.html">Form File Upload</a></li>
                            <li><a href="form-xeditable.html">Form Xeditable</a></li>
                            <li><a href="form-repeater.html">Form Repeater</a></li>
                            <li><a href="form-wizard.html">Form Wizard</a></li>
                            <li><a href="form-mask.html">Form Mask</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-pie-chart"></i>
                            <span>Charts</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="charts-morris.html">Morris Chart</a></li>
                            <li><a href="charts-chartist.html">Chartist Chart</a></li>
                            <li><a href="charts-chartjs.html">Chartjs Chart</a></li>
                            <li><a href="charts-flot.html">Flot Chart</a></li>
                            <li><a href="charts-knob.html">Jquery Knob Chart</a></li>
                            <li><a href="charts-sparkline.html">Sparkline Chart</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-view-grid"></i>
                            <span>Tables</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="tables-basic.html">Basic Tables</a></li>
                            <li><a href="tables-datatable.html">Data Table</a></li>
                            <li><a href="tables-responsive.html">Responsive Table</a></li>
                            <li><a href="tables-editable.html">Editable Table</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-face-smile"></i>
                            <span>Icons</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="icons-material.html">Material Design</a></li>
                            <li><a href="icons-fontawesome.html">Font Awesome</a></li>
                            <li><a href="icons-ion.html">Ion Icons</a></li>
                            <li><a href="icons-themify.html">Themify Icons</a></li>
                            <li><a href="icons-dripicons.html">Dripicons</a></li>
                            <li><a href="icons-typicons.html">Typicons Icons</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ti-location-pin"></i>
                            <span class="badge rounded-pill bg-danger float-end">2</span>
                            <span>Maps</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="maps-google.html"> Google Map</a></li>
                            <li><a href="maps-vector.html"> Vector Map</a></li>
                        </ul>
                    </li>

                    <li class="menu-title">Extras</li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-layout"></i>
                            <span>Layouts</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">Vertical</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="layouts-light-sidebar.html">Light Sidebar</a></li>
                                    <li><a href="layouts-compact-sidebar.html">Compact Sidebar</a></li>
                                    <li><a href="layouts-icon-sidebar.html">Icon Sidebar</a></li>
                                    <li><a href="layouts-boxed.html">Boxed Layout</a></li>
                                    <li><a href="layouts-colored-sidebar.html">Colored Sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">Horizontal</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="layouts-horizontal.html">Horizontal</a></li>
                                    <li><a href="layouts-hori-topbar-light.html">Light Topbar</a></li>
                                    <li><a href="layouts-hori-boxed.html">Boxed Layout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>



                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-archive"></i>
                            <span> Authentication </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="pages-login.html">Login 1</a></li>
                            <li><a href="pages-login-2.html">Login 2</a></li>
                            <li><a href="pages-register.html">Register 1</a></li>
                            <li><a href="pages-register-2.html">Register 2</a></li>
                            <li><a href="pages-recoverpw.html">Recover Password 1</a></li>
                            <li><a href="pages-recoverpw-2.html">Recover Password 2</a></li>
                            <li><a href="pages-lock-screen.html">Lock Screen 1</a></li>
                            <li><a href="pages-lock-screen-2.html">Lock Screen 2</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-support"></i>
                            <span>  Extra Pages  </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="pages-timeline.html">Timeline</a></li>
                            <li><a href="pages-invoice.html">Invoice</a></li>
                            <li><a href="pages-directory.html">Directory</a></li>
                            <li><a href="pages-starter.html">Starter Page</a></li>
                            <li><a href="pages-404.html">Error 404</a></li>
                            <li><a href="pages-500.html">Error 500</a></li>
                            <li><a href="pages-pricing.html">Pricing</a></li>
                            <li><a href="pages-gallery.html">Gallery</a></li>
                            <li><a href="pages-maintenance.html">Maintenance</a></li>
                            <li><a href="pages-comingsoon.html">Coming Soon</a></li>
                            <li><a href="pages-faq.html">FAQs</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-bookmark-alt"></i>
                            <span>  Email Templates  </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="email-template-basic.html">Basic Action Email</a></li>
                            <li><a href="email-template-alert.html">Alert Email</a></li>
                            <li><a href="email-template-billing.html">Billing Email</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ti-more"></i>
                            <span>Multi Level</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="javascript: void(0);">Level 1.1</a></li>
                            <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);">Level 2.1</a></li>
                                    <li><a href="javascript: void(0);">Level 2.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>--}}
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content1">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div id="" class="form-horizontal form-wizard-wrapper wizard clearfix">
                                    <div class="steps clearfix mb-5">
                                        <ul role="tablist">
                                            <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                                <a id="form-horizontal-t-0" href="#form-horizontal-h-0" aria-controls="form-horizontal-p-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Step 1</a>
                                            </li>
                                            <li role="tab" class="last done" aria-disabled="false" aria-selected="false">
                                                <a id="form-horizontal-t-1" href="#form-horizontal-h-1" aria-controls="form-horizontal-p-1">
                                                    <span class="number">2.</span> Step 2</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <form action="{{route('step_1.save')}}" method="post" class="form-horizontal">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Api Endpoint</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="api_end_point" type="text" placeholder="Enter api endpoint..." id="example-text-input" >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Api Token</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="api_token" type="text" placeholder="Enter api token..." id="example-text-input" >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 text-right" align="right">
                                            <button class="btn btn-primary me-2"> Next</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- row end -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



    </div>
    <!-- end main content-->

</div>

<!-- END layout-wrapper -->

<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- Right bar overlay-->


<!-- JAVASCRIPT -->
<script src="{{asset('')}}assets/libs/jquery/jquery.min.js"></script>
<script src="{{asset('')}}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('')}}assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{asset('')}}assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{asset('')}}assets/libs/node-waves/waves.min.js"></script>

<!-- form wizard -->
<script src="{{asset('')}}assets/libs/jquery-steps/build/jquery.steps.min.js"></script>

<!-- form wizard init -->
<script src="{{asset('')}}assets/js/pages/form-wizard.init.js"></script>

<script src="{{asset('')}}assets/js/app.js"></script>
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
</body>
</html>
