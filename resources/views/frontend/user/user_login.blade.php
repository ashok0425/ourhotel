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
    <div class="login-wrap  mt-5 mt-md-0">
        <div class="container pt-5 mt-5 pt-md-0 pt-md-0">
            <div class="login-inner">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('frontend/images/tablet-login-rafiki.svg') }}" class="img-fluid"
                            alt="NSN Hotels Login" />
                    </div>
                    <div class="col-md-6">
                        <form class="loginform" method="POST" id="loginotpform" name="loginotpform" style="width: 100%">
                            @csrf
                            <p class="login-title">Signin to continue</p>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <select name="phone_code" id="phone_code" class="form-select input-group-text text-white bg-purple" style="border:2px solid #6838af">
                                        <option value="91">+91</option>
                                        <option value="977">+977</option>
                                    </select>
                                    </div>
                                    <input type="text" class="form-control px-3" aria-describedby="basic-addon1"  name="phone_no" id="phone_no" placeholder="Enter your phone number" maxlength="10" minlength="10"
                                    pattern="[1-9]{1}[0-9]{9}" autocomplete="off" required autofocus
                                    value="{{ isset($_GET['phone'])?$_GET['phone']:'' }}" style="border-bottom:2px solid #6838af;max-width:100%!important" >

                                  </div>
                            </div>

                            <div class="form-group otp">
                                <input type="tel" inputmode="numeric"
                                    class="form-control" name="otp" id="otp" placeholder="One Time Password" style="border-bottom:2px solid #6838af" />

                                <span id="errorMsg"></span>
                            </div>


                            <div class="form-group otp">
                                <button type="button" onclick="otpSubmit()"
                                    class="btn commonbtn bg-purple text-white">{{ __('Login') }}</button>
                            </div>
                            <button class="btn custom-bg-primary  text-white" id="resendotps"
                                onclick="sendOtp(event)">Resend Otp</button>
                            <div class="form-group send-otp">
                                <button class="btn commonbtn bg-purple text-white" id="login"
                                    onclick="sendOtp(event)">Send Otp</button>
                            </div>

                            <div class="form-group">
                                    <a href="{{ route('login_social', 'google') }}" class="btn custom-fw-600 btn-danger d-block btn-block text-center w-100">
                                        <span   class="fab fa-google"></span> SignIn with Google</a>
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
                var btnSubmit = document.getElementById("login");
                if (phone_no.value.trim() != "") {
                    btnSubmit.disabled = false;
                } else {
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
                    $('.otp').show();
                    $('.send-otp').hide();
                    $('#resendotps').show();
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
                            $('#errorMsg').html('Incorrect otp');
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

@endpush
