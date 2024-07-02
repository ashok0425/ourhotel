@extends('frontend.layouts.master')

@section('main')
    <style>
        #razorpay-payment-button {
            display: none;
        }
    </style>
    <form action="{!! route('payment.rozer', ['booking_id' => $booking->booking_id]) !!}" method="POST" id='rozer-pay' style="display: block;">

        @php
                $total = $booking->final_amount
        @endphp
        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_KEY') }}"
            data-amount={{ $total * 100 }} data-currency="INR" data-buttontext="" data-name="NSN HOTELS"
            data-amount={{ $total * 100 }} data-currency="INR" data-buttontext="" data-orderId="$booking->uuid"
            data-description="Cart Payment"
            data-image="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
            data-prefill.name="{{ $booking->name }}" data-prefill.email="{{ $booking->email }}"
            data-prefill.contact="{{ $booking->phone_number }}" data-theme.color="#ff7529"></script>
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" class="d-none">
    </form>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#rozer-pay').submit()
        });
    </script>
@endpush
