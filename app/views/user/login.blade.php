@extends('layouts.master')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

@sdection('head')
	@parent
	<title>Register Page</title>
@stop
<!-- Login page -->
@section('content')
	<div class="container">
		<h1>Login</h1>
		<div align = "right" style="float: right; margin-right:100px; " >
		<img src="https://sep.altairsl.us/resources/common/picutres/m_logo_primary_rwd.png" alt="" style="width:600px;height:228px;">
		</div>
		<div style="float: left">
		<form role="form" method="post" action="{{ URL::route('postLogin') }}">
			<div class="form-group {{ ($errors->has('username')) ? ' has-error' : '' }}">
				<label for="username">Username: </lable>
					<input id="username" name="username" type="text" class="form-control">
					@if($errors->has('username'))
						{{ $errors->first('username') }}
					@endif
			</div>
			<div class="form-group {{ ($errors->has('pass1')) ? ' has-error' : '' }}">
				<label for="pass1">Password: </lable>
					<input id="pass1" name="pass1" type="password" class="form-control">
					@if($errors->has('pass1'))
						{{ $errors->first('pass1') }}
					@endif
			</div>
			<div class="checkbox">
				<label for="remember">
					<input type="checkbox" name="remember" id="remember">
					Remember me!
				</label>
				</label>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Login" class="btn btn-default">
			</div>
		</form>

  </div>
 
  <!-- Facebook login button -->
  
	</div>	
	  <a href="login/fb"><button class="btn btn-facebook"><i class="fa fa-facebook"></i> | Connect with Facebook</button></a>
@stop
