<!DOCTYPE html>
<html>
<head lang="vi">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<base href="{{asset('')}}" >

	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/mystyle.css">

	<link href="public/css/glyphicons.css" rel="stylesheet" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="asset/font-awesome/css/fontawesome-all.min.css"> --> <!--not full icon-->
</head>
<body>
	<div class="loading-icon">
		<!-- <img src="images/loading-icon.gif"> -->
	</div>
	<div class="container-fluid">
		@include('layout.header')
		
		@yield('content')

		@include('layout.footer')
	</div>
	<script type="text/javascript" src='public/js/jquery.min.js'></script>
	<script type="text/javascript" src='public/js/bootstrap.min.js'></script>
	<script src='public/js/elevatezoom/jquery.elevatezoom.js'></script>
	<script type="text/javascript" src='public/js/myscript.js'></script>
	
		@yield('script')
	<script type="text/javascript">
		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});
	</script>

</body>
</html>