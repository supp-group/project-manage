<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

        <meta property="og:title" content="الحزب الديمقراطي السوري">
        <meta property="og:description" content=" ديمقراطية_عدالة_تنمية">
        <meta property="og:image" content="{{URL::asset('assets/img/media/team.jpg')}}">

	</head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('admin.layouts.main-sidebar')		
		<!-- main-content -->
		<div class="main-content app-content">
			@include('admin.layouts.main-header')			
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				
				@include('admin.layouts.models')
            	@include('admin.layouts.footer')
				@include('admin.layouts.footer-scripts')	
	</body>
</html>