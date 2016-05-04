<!doctype html>
<html lang="en">
<head>
	@section('head')
	<meta charset="UTF-8">
	
<!-- including scripts and css files needed to run the application via CDN -->
	<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://bootswatch.com/spacelab/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/social-buttons.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	@show
</head>
<body>
	<div class="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ URL::route('forum-home') }}" class="navbar-brand">Wedaduru Forum</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
				
			
				
			</ul>
			
			<!-- Main navigation bar -->
			<ul class="nav navbar-nav navbar-right">
				@if(!Auth::check())
					<li><a href="{{ URL::route('getCreate') }}">Register</a></li>
					<li><a href="{{ URL::route('getLogin') }}">Login</a></li>
				@else
					<li><a href="{{ URL::route('getLogout') }}">Logout</a></li>
				@endif
			</ul>
		</div>
		</div>
	</div>
<!-- Displaying alerts -->
	@if(Session::has('success'))
		<div align="center" class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('fail'))
		<div align="center" class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif
	
	<div class="container">@yield('content')</div>

	@section('javascript')
		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	@show
	<div align="center"> &copy;Wedaduru 2016</div>
</body>
</html>
