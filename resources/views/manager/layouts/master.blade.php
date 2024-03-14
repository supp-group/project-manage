<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="الحزب الديمقراطي السوري">
    <meta property="og:description" content="ديمقراطية، عدالة، تنمية">
    <meta property="og:image" content="{{ asset('assets/img/media/team.jpg') }}">
    <title>الحزب الديمقراطي السوري</title>


		@include('manager.layouts.head')
	</head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('manager.layouts.main-sidebar')		
		<!-- main-content -->
		<div class="main-content app-content">
			@include('manager.layouts.main-header')			
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				
				@include('manager.layouts.models')
            	@include('manager.layouts.footer')
				@include('manager.layouts.footer-scripts')	
	</body>
</html>