@extends('layouts.master')

@section('head')
	@parent
	<title>Register Page</title>
@stop
<!-- Registration Page -->
@section('content')
	<div class="container">
		<h1>Register</h1>
		<div align = "right" style="float: right; margin-right:100px; " >
		<img src="https://sep.altairsl.us/resources/common/picutres/m_logo_primary_rwd.png" alt="" style="width:600px;height:228px;">
		</div>
<div style="float: left">
		<form role="form" method="post" action="{{ URL::route('postCreate') }}">
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
			<div class="form-group {{ ($errors->has('pass2')) ? ' has-error' : '' }}">
				<label for="pass2">Confirm Password: </lable>
					<input id="pass2" name="pass2" type="password" class="form-control">
					@if($errors->has('pass2'))
						{{ $errors->first("Password confirmation") }}
					@endif
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Register" class="btn btn-default">
			</div>
			</div>
		</form>
	</div>	
@stop