<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="الحزب الديمقراطي السوري">
    <meta property="og:description" content="ديمقراطية، عدالة، تنمية">
    <meta property="og:image" content="{{ asset('assets/img/media/team.jpg') }}">
    <title>الحزب الديمقراطي السوري</title>


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