<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.core._head')

	@include('layouts.core._script_vars')

	@yield('head')


		<meta name="theme-color" content="#eff3f5">

    <style>
        .filter-box-1 {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .filter-box-1 input.search {
            width: 250px;
            display: inline-block;
            height: 33px;
            margin-left: 0;
            padding-right: 32px;
        }
    </style>
	<script>
			var ECHARTS_THEME = isDarkMode() ? 'dark' : null
	</script>
</head>
<body class="theme-light leftbar
	leftbar-open

	mode-light
">
	@include('layouts.core._menu_backend')

	@include('layouts.core._middle_bar')

	<main class="container page-container px-3">
{{--		@include('layouts.core._headbar_backend')--}}

		@yield('page_header')

		<!-- display flash message -->
		@include('layouts.core._errors')

		<!-- main inner content -->
		@yield('content')

		<!-- Footer -->
		@include('layouts.core._footer')
	</main>

	<!-- Notification -->
	@include('layouts.core._notify')

	<!-- display flash message -->
	@include('layouts.core._flash')
    <script>
        $(document).ready(function() {
            $(".search").on("keyup", function(e) {
                e.preventDefault();
                var value = $(this).val().toLowerCase();
                $("#myTableData tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
