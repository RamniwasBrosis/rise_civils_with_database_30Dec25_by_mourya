@extends('layouts.main')

@section('content')

<!-- main-area -->
        <main class="fix">
            <section class="login__area-one">
				<div class="container">
					<div class="text-center mb-55">
						<h1 class="text-48-bold">Welcome back!</h1>
					</div>
					<div class="box-form-login">
						<div class="head-login">
							<h3>Sign in</h3>
							<p>Sign in with your email and password</p>
							<div class="form-login">
							<form id="loginForm" method="POST" action="{{ route('front.frontlogin') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control account" placeholder="Email Address" name="email" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password" />
                                    <span class="view-password"></span>
                                </div>
                                <div class="box-forgot-pass">
                                    <label> 
                                        <input type="checkbox" class="cb-remember" name="remember" value="1" /> Remember me
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-login" value="Sign In" />
                                </div>
                            </form>

							<p>Don’t have an account? <a href="{{ route('front.signup') }}" class="link-bold">Sign up</a> now</p>
							</div>
						</div>
					</div>
				</div>
			</section> 
        </main>



@endsection