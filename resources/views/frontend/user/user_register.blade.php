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

                        <form class="loginform" method="POST" action="{{ route('user_register') }}" style="width:100%">
                            @csrf
                            <p class="login-title">Signup  to continue</p>
                            <x-errormsg/>
                      <div class="form-group otp" >
                                <input type="text" class="form-control" name="name"
                                    placeholder="Enter Your Full Name" required value="{{ old('name') }}" style="border-bottom:2px solid #6838af"  />
                            </div>
                      {{-- <div class="form-group otp">
                                <input type="email" style="min-width:100%!important" class="form-control" name="email"
                                    required placeholder="Enter Your Email Address" value="{{ old('email') }}" />
                            </div> --}}

                            <div class="form-group ">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <select name="phone_code" id="phone_code" class="form-select input-group-text text-white bg-purple" style="border:2px solid #6838af">
                                        <option value="91">+91</option>
                                        <option value="977">+977</option>
                                    </select>
                                    </div>
                                    <input type="text" class="form-control px-3" aria-describedby="basic-addon1"  name="phone_no" id="phone_no" placeholder="Enter your phone number" maxlength="10" minlength="10"
                                    pattern="[1-9]{1}[0-9]{9}" autocomplete="off" required autofocus
                                    value="{{ isset($_GET['phone'])?$_GET['phone']:'' }}" style="border-bottom:2px solid #6838af" >

                                  </div>
                            </div>


                            <div class="form-group otp">
                                @if (isset($_GET['q']))
                                <label for="">Referral Code (optional)</label>
                                @endif

                                @php
                                    $q=$_GET['q']??null;
                                @endphp
                                <input type="text" class="form-control"
                                    name="referral_code" placeholder="Referral Code (optional"
                                    {{isset($_GET['q']) ? 'value='.$q.'':''}}  {{isset($_GET['q'])?'readonly':''}} style="border-bottom:2px solid #6838af"/>
                            </div>

                            <div class="form-group otp">
                                <button type="submit" class="btn commonbtn bg-purple custom-fw-600 text-white">{{ __('SignUp') }}</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
