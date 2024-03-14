<!DOCTYPE html>
<html lang="en">
	<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

        <meta property="og:title" content="الحزب الديمقراطي السوري">
        <meta property="og:description" content=" ديمقراطية_عدالة_تنمية">
        <meta property="og:image" content="{{URL::asset('assets/img/media/team.jpg')}}">


		@include('layouts.head')
	</head>
	
	<body class="main-body bg-primary-transparent">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@yield('content')		
		@include('layouts.footer-scripts')	
	</body>
</html>