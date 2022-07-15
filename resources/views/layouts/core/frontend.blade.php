<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.core._head')

	@include('layouts.core._script_vars')

	@yield('head')


    <meta name="theme-color" content="#eff3f5">


    <script>
        var ECHARTS_THEME = 'dark';
    </script>
</head>
<body class="theme-light leftbar
	leftbar-open

	mode-light
">
	@include('layouts.core._menu_frontend')

	@include('layouts.core._middle_bar')

	<main class="container page-container px-3">
		@include('layouts.core._headbar_frontend')

		@yield('page_header')

		<!-- display flash message -->
		@include('layouts.core._errors')

		<!-- main inner content -->
		@yield('content')

		<!-- Footer -->
		@include('layouts.core._footer')
	</main>

	<!-- Admin area -->
	@include('layouts.core._admin_area')

	<!-- Notification -->
	@include('layouts.core._notify')
	@include('layouts.core._notify_frontend')

	<!-- display flash message -->
	@include('layouts.core._flash')

	<script>
		var wizardUserPopup;

		$(function() {
			// auto detect dark mode


			// Customer color scheme | menu layout wizard
			@if (false)
				$(function() {
					wizardUserPopup = new Popup({
						url: '{{ action('AccountController@wizardColorScheme') }}',
					});
					wizardUserPopup.load();
				});
			@endif

			@if (null !== Session::get('orig_admin_id') && Auth::user()->admin)
				notify({
					type: 'warning',
					message: `{!! trans('messages.current_login_as', ["name" => Auth::user()->displayName()]) !!}<br>{!! trans('messages.click_to_return_to_origin_user', ["link" => action("Admin\AdminController@loginBack")]) !!}`,
					timeout: false,
				});
			@endif

			@if (null !== Session::get('orig_admin_id') && Auth::user()->admin)
				notify({
					type: 'warning',
					message: `{!! trans('messages.site_is_offline') !!}`,
					timeout: false,
				});
			@endif
		})

	</script>

{{--	{!! \Acelle\Model\Setting::get('custom_script') !!}--}}
</body>
</html>
