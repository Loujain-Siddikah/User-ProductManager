@extends('layouts.master')
@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="POST" action="{{ route('register_user') }}" class="login100-form validate-form" id='registerForm'>
					@csrf
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="first_name" required>
						<span class="focus-input100" data-placeholder="Name"></span>
						<span class="text-danger"> @error('first_name') {{ $message }} @enderror</span>
					</div>
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="last_name" required>
						<span class="focus-input100" data-placeholder="Name"></span>
						<span class="text-danger"> @error('last_name') {{ $message }} @enderror</span>
					</div>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" required>
						<span class="focus-input100" data-placeholder="Email"></span>
						<span class="text-danger"> @error('email') {{ $message }} @enderror</span>
					</div>

					<div class="wrap-input100 validate-input" >
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password" required>
						<span class="focus-input100" data-placeholder="Password"></span>
						<span class="text-danger"> @error('password') {{ $message }} @enderror</span>
					</div>

					<div class="wrap-input100 validate-input" >
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password_confirmation" required>
						<span class="focus-input100" data-placeholder="confirm_password"></span>
						<span class="text-danger"> @error('password') {{ $message }} @enderror</span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							{{-- <button class="login100-form-btn">
								Login
							</button> --}}
							<input type="submit" class="login100-form-btn" value="register">
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

						<a class="txt2" href="#">
							Sign Up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>

	
	
@endsection
