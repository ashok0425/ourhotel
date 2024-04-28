@extends('frontend.layouts.master')
@section('main')
    @php
        $pre_url = url()->previous();
        session()->put('pre_url', $pre_url);
    @endphp
    <style>
        .iti--allow-dropdown {
            width: 100% !important;
        }
    </style>
    <div class="login-wrap">
        <div class="container">
            <div class="login-inner">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('frontend/images/tablet-login-rafiki.svg') }}" class="img-fluid"
                            alt="NSN Hotels Login" />
                    </div>
                    <div class="col-md-6">
                        {{-- display error message  --}}

                        <form class="loginform" method="POST" action="{{ route('user_register') }}">
                            @csrf
                            <p class="login-title">Please fill the below form to continue...</p>
                            <x-errormsg/>

                            <div class="form-group otp">
                                <input type="text" style="min-width:100%!important" class="form-control" name="name"
                                    placeholder="Enter Your Full Name" required value="{{ old('name') }}" />
                            </div>

                            <div class="form-group otp">
                                <input type="email" style="min-width:100%!important" class="form-control" name="email"
                                    required placeholder="Enter Your Email Address" value="{{ old('email') }}" />
                            </div>

                            <div class="form-group ">

                                <input type="text" class="form-control custominput" style="min-width:100%!important"
                                    name="phone_no" id="phone_no" placeholder="Type Number" maxlength="10" minlength="10"
                                    pattern="[1-9]{1}[0-9]{9}" autocomplete="off" required value="{{ old('phone_no') }}" />
                            </div>


                            <div class="form-group otp">
                                <input type="hidden" id="phone_code" value="91" name="phone_code">

                                {{-- <input type="text" style="min-width:100%!important" class="form-control"
                                    name="referral_code" placeholder="Referral Code (optional)"
                                    value=" @if (isset($_GET['q'])) {{ $_GET['q'] }}
                            @else {{ old('referral_code') }} @endif
                            " /> --}}
                            </div>

                            <div class="form-group otp">
                                <button type="submit" class="btn commonbtn bluebtn text-white">{{ __('SignUp') }}</button>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@push('scripts')
    <script>
        var input = document.querySelector("#phone_no");
        let inpuFiled = window.intlTelInput(input, {
            preferredCountries: ['in', 'np', 'us'],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",

        });
        $(document).on('click', '.iti__country', function() {
            let code = inpuFiled.getSelectedCountryData()['dialCode'];
            $('#phone_code').val(code);
        })
    </script>
@endpush
