@extends('layouts.main')

@section('content')

<main class="fix">
    <!-- slider-area -->
    <section class="register__area-one">
		<div class="container">
			<div class="text-center mb-55">
				<h1 class="text-48-bold">Create An Account</h1>
			</div>
			<div class="box-form-login">
				<div class="head-login">
					<h3>Register</h3>
					<p>Create an account today and start using our platform</p> 
					<div class="form-login">
					    <form id="loginForm" method="POST" action="{{ route('front.registration') }}">
                        @csrf
    						<div class="form-group">
    							<input type="text" class="form-control account" name="name" placeholder="Your First Name" />
    						</div>
    						<div class="form-group">
    							<input type="text" class="form-control account" name="last_name" placeholder="Your Last Name" />
    						</div>
    						<div class="form-group"> 
    							<input type="text" class="form-control email-address" name="email" placeholder="Email Address" />
    						</div>
    						<div class="form-group">
    							<input type="text" class="form-control account" placeholder="Mobile Number" name="nubhar" 
                                    maxlength="10" pattern="\d{10}" title="Enter Mobile no" />
    						</div>
    						<div class="form-group">
    							<input type="password" class="form-control" placeholder="Password" name="password" />
    							<span class="view-password"></span>
    						</div>
    						<div class="form-group">
    							<input type="password" class="form-control" placeholder="Confirm Password" name="RePassword" />
    							<span class="view-password"></span>
    						</div>
    						<div class="box-forgot-pass">
    							<label> <input type="checkbox" class="cb-remember" value="1" /> <span>I have read and agree to the Terms & Conditions and the Privacy Policy of this website.</span> </label>
    						</div>
    						<div class="form-group">
    							<input type="submit" class="btn btn-login" value="Sign up now" />
    						</div>
    					</form>
						<p>Already have an account? <a href="{{ route('front.login') }}" class="link-bold">Sign In</a> now</p>
					</div>
				</div>
			</div>
		</div>
	</section>  
</main>

@endsection