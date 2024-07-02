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
                        <form class="loginform" method="POST" id="loginotpform" name="loginotpform">
                            @csrf
                            <p class="login-title">Please enter your phone to continue</p>
                            <div class="form-group ">

                                <input type="text" class="form-control custominput" style="width:100%!important"
                                    name="phone_no" id="phone_no" placeholder="Type Number" maxlength="10" minlength="10"
                                    pattern="[1-9]{1}[0-9]{9}" autocomplete="off" required autofocus
                                    @if (isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif />
                                <input type="hidden" name="phone_code" value="91" id="phone_code">

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="referral_code" id="referral_code"
                                    placeholder="Enter referral code" />
                            </div>
                            <div class="form-group otp">
                                <input type="tel" inputmode="numeric" style="min-width:100%!important"
                                    class="form-control" name="otp" id="otp" placeholder="One Time Password" />
                                <div class="icon-container">
                                    <i class="loader"></i>
                                </div>
                                <span id="errorMsg"></span>
                            </div>


                            <div class="form-group otp">
                                <button type="button" onclick="otpSubmit()"
                                    class="btn commonbtn bluebtn text-white">{{ __('Login') }}</button>


                            </div>
                            <button class="btn btn-info text-white" id="resendotps"
                                onclick="sendOtp(event)">{{ __('Resend Otp') }}</button>
                            <div class="form-group send-otp">
                                <button class="btn commonbtn bluebtn text-white" id="login"
                                    onclick="sendOtp(event)">{{ __('Send Otp') }}</button>

                            </div>
                            <div class="form-group">
                                    <a href="{{ route('login_social', 'google') }}" class="btn custom-fw-600 btn-danger d-block btn-block text-center w-100">
                                        <span
                                                class="fab fa-google"></span> SignIn with Google</a>
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
        $(document).ready(function() {



            $('#resendotps').hide();
            $('.icon-container').hide();
            $("#phone_no").keydown(function(event) {
                var keycode = event.which;
                if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 ||
                        keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                    event.preventDefault();
                }
                //Reference the Button.
                var btnSubmit = document.getElementById("login");

                //Verify the TextBox value.
                if (phone_no.value.trim() != "") {
                    //Enable the TextBox when TextBox has value.
                    btnSubmit.disabled = false;
                } else {
                    //Disable the TextBox when TextBox is empty.
                    btnSubmit.disabled = true;
                }
            });
        });
    </script>
    <script>
        function resendButtonShow() {
            $("#resendotps").attr("disabled", false);
            $("#resendotps").text('Resend OTP');
        };

        $('#referral_code').hide();
        $('.otp').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function sendOtp(e) {
            $('.icon-container').show();
            if ($('#phone_no').val().length < 10) {
                toastr.error('Phone No Should Be 10 Digit');
                return false;
            }

            e.preventDefault();
            $.ajax({
                url: '{{ route('send_otp') }}',
                type: 'post',
                data: {
                    phone_no: $('#phone_no').val(),
                    phone_code: $('#phone_code').val()
                },
                success: function(data) {
                    console.log(data)
                    $('.icon-container').hide();
                    if (data != 0) {
                        $('.otp').show();
                        $('#resendotps').show();
                        $('.send-otp').hide();
                        var counter = 120;
                        var interval = setInterval(function() {
                            counter--;
                            // Display 'counter' wherever you want to display it.
                            if (counter <= 0) {
                                clearInterval(interval);
                                return;
                            } else {
                                $('#login').hide();
                                $('#resendotps').text('Resend Verfication Code(' + counter + ':00)');
                                $('#resendotps').attr("disabled", true);

                            }
                        }, 1000);
                        setInterval(resendButtonShow, 120000);
                    } else {
                        $('.otp').show();
                        $('#referral_code').show();
                        $('.send-otp').hide();

                    }
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    if (response.message) {
                        alert(response.message);
                    }
                }
            });
        }

        function otpSubmit() {
            if ($('#otp').val().length === 6) {
                $.ajax({
                    url: '{{ route('loginWithOtp') }}',
                    type: 'post',
                    data: {
                        'phone_no': $('#phone_no').val(),
                        'otp': $('#otp').val(),
                        'referral_code': $('#referral_code').val()
                    },
                    success: function(data) {
                        var val = data['user'];
                        if (val == 400) {
                            $('#errorMsg').css('color', 'red');
                            $('#errorMsg').html('Wrong Otp');
                            return false;
                        } else {
                            window.location = "{{ session()->get('pre_url') }}";
                        }
                    }

                });
            } else {
                $('#errorMsg').css('color', 'red');
                $('#errorMsg').html('Otp must be 6 digit');
                return false;
            }
        };
    </script>

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
