<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	 <meta name="csrf-token" content="{{ csrf_token() }}">
	 <title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Global stylesheets -->
	@include('crm.inc.crm_asset')
	<!-- /global stylesheets -->

</head>

<body class="sidebar-right-visible">
	<!-- Main navbar -->
	@include('crm.inc.header')

	<!-- /main navbar -->
	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
			@include('crm.inc.side_nav')
		</div>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">
			<!-- content area -->
			@yield('content')
			<!-- /content area -->
			<!-- Footer -->
            @include('crm.inc.delete_modal')
			@include('crm.inc.footer')
			<!-- /footer -->
		</div>
        @yield('sidebar-right')
		<!-- /main content -->
	</div>
    <script>
        $(".flash-container").fadeTo(3000, 1000).slideUp(3000, function(){
            $(".flash-container").slideUp(3000);
        });
    </script>
	<!-- /page content -->
    @stack('js')
</body>
</html>
