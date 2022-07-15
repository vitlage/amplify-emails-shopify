<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.core._head')

        @include('layouts.core._script_vars')
    </head>
    <body class="bg-slate-800">
        <!-- Page container -->
        <div class="page-container login-container">
            @if (\Auth::check())
                <div class="text-end">
                    <a href="{{ url("/logout") }}"  class='text-white ml-20'><i class="icon-switch2"></i> {{ trans('messages.logout') }}</a>
                </div>
            @endif

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-2 col-md-4">

                        </div>
                        <div class="col-sm-8 col-md-4">

                            <div class="text-center login-header">
                                <a class="main-logo-big" href="{{ action('HomeController@index') }}">
                                    <img src="{{ URL::asset('images/logo_big.svg') }}" alt="">

                                </a>
                            </div>

                            @yield('content')

                        </div>
                    </div>
                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->


            <!-- Footer -->
            <div class="small">
                <div class="footer text-white text-center py-3" style="width: 100%">
                    {!! trans('messages.copy_right_light') !!}
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /page container -->


    </body>
</html>
