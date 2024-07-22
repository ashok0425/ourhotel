@extends('frontend.layouts.master')
@section('main')

	<div class="nsnhotelsbookinginformation container my-5 ">
					<div class="row">
						<div class="col-12 col-sm-3 col-md-3 ">
							@include('frontend.user.sidebar')
						</div>
						<div class="col-md-9 bg-white">
                            <div class="row">

                                <div class="col-md-6  pt-md-5 pt-2">
                                    <form action="{{route('user_profile_update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control custom-border-radius-0" placeholder="Your Name" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="file" name="avatar" id="" class="form-control custom-border-radius-0" placeholder="No of Guest">
                                                </div>
                                    <button class="custom-bg-secondary py-2 border-none boder-o outline-none  custom-text-white d-block w-100 text-center custom-fw-700">Submit</button>
                                    </form>
                                </div>
                                   <div class="col-md-6 border-left pt-md-5 pt-2" style="height: 300px">
                                    <div class="form-group input-group">
                                        <input type="email" name="email" value="{{auth()->user()->email}}" id="" class="form-control custom-border-radius-0" placeholder="Your Email Address" disabled>
                                        <a href="#demo-modal" type="button" class="rounded-0 btn bg-purple text-white" id="showModal" data-input='email'>Edit</a>
                                    </div>

                                    <div class="form-group input-group">
                                        <input type="text" disabled id="" class="form-control custom-border-radius-0" placeholder="Your Phone number" value="{{auth()->user()->phone_number}}" required>
                                        <a type="button" href="#demo-modal" class="rounded-0 btn bg-purple text-white" id="showModal" data-input='phone'>Edit</a>
                                    </div>
                                </div>
                            </div>

						</div>
					</div>
				</div>


                <div id="demo-modal" class="modal">
                    <div class="modal__content">
                        <p>
                        <form action="">
                            <div class="from-group mt-3 new_email">
                                <label for=""><strong>Enter New Email</strong></label>
                                <input type="email" name="email" class="form-control" required placeholder="example@email.com">
                            </div>

                            <div class="from-group mt-3 new_phone d-none">
                                <label for=""><strong>Enter New Phone number</strong></label>
                                <input type="number" name="phone" class="form-control" required placeholder="98*********">
                            </div>

                            <div class="from-group mt-3 d-none enter_otp">
                                <label for=""><strong>Enter Verification code</strong></label>
                                <input type="number" name="otp" placeholder="Enter code here" class="form-control" required>
                            </div>

                                <div class=" mt-2 text-right send_otp">
                                    <button class="btn bg-purple text-white">Send Verification code</button>
                                </div>
                                <div class=" mt-2 text-right d-none verify_otp d-none">
                                    <button class="btn bg-purple text-white">Verify Now</button>
                                </div>
                        </form>
                        </p>
                        <a href="#" class="modal__close custom-fs-28">&times;</a>
                    </div>
                </div>
@stop
@push('style')
    <style>
        .modal {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(77, 77, 77, .7);
            transition: all .4s;
        }

        .modal:target {
            visibility: visible;
            opacity: 1;
        }

        .modal__content {
            border-radius: 4px;
            position: relative;
            width: 500px;
            max-width: 90%;
            background: #fff;
            padding: 1em 2em;
        }

        .modal__footer {
            text-align: right;

            a {
                color: #585858;
            }

            i {
                color: #d02d2c;
            }
        }

        .modal__close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #585858;
            text-decoration: none;
        }

        .iti--allow-dropdown {
            width: 100% !important;
        }

        .main_content {
            z-index: 9999;
        }

        .custom-bg-secondary-400 {
            background: rgb(180, 216, 224);
        }

        .breadcrumarea:before {
            background: #1d4783;
            !important;

        }
    </style>
@endpush
@push('scripts')
<script>
    let input;
    let url="{{ route('user_profile_update') }}";

    $(document).on('click', "#showModal", function(){
        input = $(this).data('input')||'email';
        if(input === 'email'){
            $('.new_phone').removeClass('d-block').addClass('d-none');
            $('.new_email').removeClass('d-none').addClass('d-block');
        } else {
            $('.new_email').removeClass('d-block').addClass('d-none');
            $('.new_phone').removeClass('d-none').addClass('d-block');
        }
    });

    $('.send_otp').click(function(e){
        e.preventDefault();
        let phone = $('.new_phone input').val();
        let email = $('.new_email input').val();

        if(input === 'phone'){

            if(validatePhone(phone)){
                sendOTP(phone);
            } else {
                toastr.error('Please enter a valid phone number.');
            }
        } else {
            if(validateEmail(email)){
                sendOTP(null, email);
            } else {
                toastr.error('Please enter a valid email address.');
            }
        }
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        const re = /^\d{10}$/;  // Adjust regex according to your phone number format requirements
        return re.test(phone);
    }

    $('.verify_otp button').click(function(e){
        let phone = $('.new_phone input').val();
        let email = $('.new_email input').val();
        let otp =$('.enter_otp input').val();
        sendOTP(phone,email,otp);
    });

    function sendOTP(phone=null, email=null,otp=null) {
        $.ajax({
            url: url, // Replace with your server endpoint
            method: 'GET',
            data: {
                phone: phone,
                email: email,
                otp:otp
            },
            success: function(response) {

                toastr.success(response.message);
                if(otp){
                location.href='/user/profile';
                }
                $('.verify_otp').removeClass('d-none');
                $('.enter_otp').removeClass('d-none');
                $('.send_otp').addClass('d-none');

            },
            error: function(error) {
                toastr.error(error.responseJSON.message);
            }
        });
    }
</script>
@endpush
