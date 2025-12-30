@extends('layouts.main')
@section('content')

<!-- Banner Section -->
<section class="banner-about" style="background-image: url('{{ asset('farnt/images/jaipur-banner.jpg') }}'); text-align: left;">
  <div class="container">
    <div class="banner-content">
      <div class="row">
        <div class="col-xl-12 text-lg-center">
          <h1>Ticket Payment</h1>
          <p>Near Annapurna Temple, Khole ke Hanuman Ji Temple, Delhi Road Jaipur, Rajasthan</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Add a description paragraph here -->
<div class="container mt-5">
  <p class="lead text-center">
    Please proceed with the payment to complete your ticket booking. You can choose from a variety of payment methods including UPI, Credit/Debit Cards, Net Banking, and Wallets. Once your payment is successfully processed, your booking will be confirmed.
  </p>
</div>

<!-- Add an image before payment form -->
<div class="container text-center mt-4">
  <img src="{{ asset('farnt/images/logo.png') }}" alt="Payment Methods" class="img-fluid" style="max-width: 80%;">
</div>

<!-- Payment Form -->
<div class="card card-default">
  <div class="card-body text-center">
    <form action="{{ route('razorpay.payment.store',$orders_id) }}" method="POST">
      @csrf
      @php
      $getUser = \App\Helpers\Helper::getUser();
      $pay = $payPricec ?? $payPrice;

      @endphp
      @if($getUser)
      <input type="hidden" name="payPrice" value="{{ $pay }}">
      <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="{{ env('RAZORPAY_KEY') }}"
        data-amount="{{ $pay * 100 }}"
        data-currency="INR"
        data-buttontext=""
        data-name="Khole ke Hanuman Ji Ropeway"
        data-description="Ticket Booking Payment"
        data-image="{{ asset('farnt/images/logo.png') }}"
        data-prefill.name="{{ $getUser->name . ' ' . $getUser->last_name }}"
        data-prefill.email="{{ $getUser->email }}"
        data-prefill.contact="{{ $getUser->nubhar }}"
        data-theme.color="#86121b"
        data-methods='{"upi": true, "card": true, "netbanking": true, "wallet": true}'>
      </script>
      @endif
      <!-- Inline CSS to hide the button -->
      <button type="button" id="payNow" class="btn btn-primary" style="display: none;">Pay with Razorpay</button>
    </form>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".razorpay-payment-button").trigger('click');
    }, 100);

    $("#payNow").hide();
  });
</script>

@endsection