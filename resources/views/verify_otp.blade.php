@extends('layouts.main')

@section('content')

<section class="banner-about" style="background-image: url(farnt/images/login-banner.jpg); text-align: left;">

    <div class="container">

        <div class="banner-content">

            <div class="row ">

                <div class="col-xl-7">

                    <h1>Login</h1>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="login-form">
    <div class="container">
        <div class="inner-text">
            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <div class="innder-div">
                        <h3>OTP Verification</h3>
                        <form action="{{ route('verify.otp') }}" method="POST">
                            @csrf
                            <input type="hidden" name="nubhar" value="{{ old('nubhar', request('nubhar')) }}">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required maxlength="6">
                                <label for="otp">Enter OTP:</label>
                                <span class="error" id="numberError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-yellow">Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection