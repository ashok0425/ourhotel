@extends('frontend.layouts.master')
@push('style')
    <style>
        .iti--allow-dropdown {
            width: 100% !important;
        }

        .main_content {
            z-index: 9999;
        }

        .custom-bg-secondary-400 {
            background: rgb(180, 216, 224);
        }
        .breadcrumarea:before{
            background: #1d4783;!important;

        }
    </style>
@endpush

@section('main')
    @php
        $tax = (int) str_replace(',', '', $prices['tax']);
        $price = (int) str_replace(',', '', $prices['subtotal']);
        $discount_amount = (int) str_replace(',', '', $prices['discount']);
        $total_price = (int) str_replace(',', '', $prices['total']);
        $adult = $request->number_of_adult;
        $children = $request->number_of_child;
        $room = $request->number_of_room;
        $night = Carbon\Carbon::parse($checkout)->diffInDays(Carbon\Carbon::parse($checkin));
    @endphp
    @include('frontend.user.breadcrum', ['title' => 'Book now'])

    {{-- main page content  --}}
    <div class="container mt-3 mb-5">
        <div class="main_content ">

            <div class="row">
                <div class="col-md-8 order-md-1 order-2 mt-2 mt-md-0">
                    <form action="{{ route('payment.checkout') }}" method="POST">
                        @csrf

                        <div class="card  border-none border-0 shadow-m">
                            <a data-toggle="collapse" href="#hotelinfo" role="button" aria-expanded="false"
                                aria-controls="hotelinfo"
                                class="custom-fs-22 custom-fw-700 text-dark d-flex justify-content-between text-uppercase border-bottom px-3 p-2">
                                <span> Hotel Info</span>
                                <span class="custom-fs-22  p-1 "> <i class="fas fa-chevron-circle-down"></i></span>

                            </a>

                            <div class="collapse show" id="hotelinfo">
                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="hotel_img">
                                                <img src="{{ getImageUrl($hotel->thumbnail) }}" alt=""
                                                    class="img-fluid thumbnail custom-border-radius-20">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="hotel_detail my-3">
                                                <h1 class="custom-fs-20 custom-fw-700 ">{{ $hotel->name }}</h1>
                                                <p class="custom-fs-16 custom-fw-700 custom-text-gray-2 mt-1 "><i
                                                        class="fas fa-map-marker-alt"></i> {{ $hotel->address }}</p>

                                                <div class="rating_wrapper d-flex mt-0 pt-0">
                                                    <div class="w-50">
                                                        <div class="mt-0 pt-0 custom-fs-14 custom-fw-600 custom-text-dark my-2">
                                                            <span
                                                                class="rating_inner custom-text-white bg-success p-1 custom-border-radius-1  custom-fs-12 custom-fw-600 text-center">
                                                                {{  number_format($hotel->ratings()->avg('rating'), 0) }}/5

                                                            </span>
                                                            <span
                                                                class="custom-text-gray-2 custom-fs-12 custom-fw-600 ml-1">
                                                                out of {{ count($hotel->ratings, 1) }} Review
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    {{-- booking_detail --}}
                                    <div class="booking_detail">

                                        <div class="custom-bg-secondary-400 custom-border-radius-10 mt-3 p-2 py-4">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <p class="custom-fs-14 text-dark custom-fw-600 py-0 my-0">Check In</p>
                                                    <p class="custom-fs-18 text-dark custom-fw-600 py-0 my-0">
                                                       {{ Carbon\Carbon::parse($checkin)->format('d M Y')}}
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <p class="custom-fs-14 text-dark custom-fw-600 py-0 my-0">Check Out</p>
                                                    <p class="custom-fs-18 text-dark custom-fw-600 py-0 my-0">
                                                        {{ Carbon\Carbon::parse($checkout)->format('d M Y')}}
                                                    </p>
                                                </div>

                                                <div class="col-md-4">
                                                    <p class="custom-fs-14 text-dark custom-fw-600 py-0 my-0">Guest</p>
                                                    <p class="custom-fs-18 text-dark custom-fw-600 py-0 my-0">
                                                        {{ $adult }} Adult | {{ $room }} Room
                                                    </p>
                                                    <small>{{ $children }} Children <span
                                                            class="custom-fs-18 text-dark custom-fw-600 ">|</span>
                                                        {{ $night }} Night</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{-- hidden input field  --}}
                        <input type="hidden" name="place_id" value="{{ $hotel->id }}">
                        <input type="hidden" name="numbber_of_adult" value="{{ $adult }}">
                        <input type="hidden" name="numbber_of_children" value="{{ $children }}">
                        <input type="hidden" name="booking_start"
                            value="{{ Carbon\Carbon::parse($checkin)->format('Y-m-d') }}">
                        <input type="hidden" name="booking_end"
                            value="{{ Carbon\Carbon::parse($checkout)->format('Y-m-d') }}">
                        <input type="hidden" name="amount" value="{{ $total_price }}">
                        <input type="hidden" name="discountPrice" value="0">
                        <input type="hidden" name="tax" value="{{ $tax }}">
                        <input type="hidden" name="TotalPrice" value="{{ $price }}">
                        <input type="hidden" name="number_of_room" value="{{ $room }}">
                        <input type="hidden" name="is_check" value="0">
                        <input type="hidden" name="room_type" value="{{ $request->room_type }}">
                        <input type="hidden" name="room_id" value="{{ $request->room_id }}">

                        <input type="hidden" name="booking_type" value="{{ $request->booking_type }}">

                        <div class="card mt-4 border-none border-0 shadow-m">
                            <a data-toggle="collapse" href="#guest" role="button" aria-expanded="false"
                                aria-controls="guest"
                                class="custom-fs-22 custom-fw-700 text-dark d-flex justify-content-between text-uppercase px-3 p-2 border-bottom">
                                <span> Guest Detail</span> <span class="custom-fs-22  p-1 "> <i
                                        class="fas fa-chevron-circle-down"></i></span></a>

                            <div class="collapse show" id="guest">
                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="custom-fw-600 custom-fs-16 mb-1">First name
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" id=""
                                                    class="form-control   outline-none shadow-none custom-border-radius-0"
                                                    placeholder="Enter First name" required
                                                    value="{{ Auth::user()?->name }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="custom-fw-600 custom-fs-16 mb-1">Last
                                                    name</label>
                                                <input type="text" name="last_name" id=""
                                                    class="form-control   outline-none shadow-none custom-border-radius-0"
                                                    placeholder="Enter last name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="custom-fw-600 custom-fs-16 mb-1">Email
                                                    Address</label>
                                                <input type="email" name="email" id=""
                                                    class="form-control   outline-none shadow-none custom-border-radius-0"
                                                    placeholder="Enter Email Address" value="{{ Auth::user()?->email }}">
                                            </div>
                                        </div>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="custom-fw-600 custom-fs-16 mb-1">Phone number
                                                    <span class="text-danger">*</span></label>
                                                <br>
                                                <input type="text" name="phone_number" id="phone_no"
                                                    class="form-control   outline-none shadow-none custom-border-radius-0 w-100"
                                                    placeholder="Enter Your number" required
                                                    value="{{ Auth::user()?->phone_number }}">
                                                <input type="hidden" name="phone_code" id="phone_code" value="91">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="custom-fw-600 custom-fs-16 mb-1">
                                                    Message</label>
                                                <input type="text" name="nesssage" id=""
                                                    class="form-control   outline-none shadow-none custom-border-radius-0"
                                                    placeholder="Enter message if any"
                                                    value="{{ $request->reason_for_early_checkout }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="card mt-4 border-none border-0 shadow-m">

                            <a data-toggle="collapse" href="#payment" role="button" aria-expanded="false"
                                aria-controls="payment"
                                class="custom-fs-22 custom-fw-700 text-dark d-flex justify-content-between text-uppercase px-3 p-2 border-bottom">
                                <span> Payment Option</span>
                                <span class="custom-fs-22  p-1 "> <i class="fas fa-chevron-circle-down"></i></span>

                            </a>

                            <div class="collapse show" id="payment">
                                <div class="p-3">
                                    <div class="form-group">
                                        <div
                                            class="d-flex justify-content-between custom-bg-secondary-400  w-100 align-items-center">
                                            <label class=" px-3 py-2 custom-fs-18 custom-fw-600 cursor-pointer"><input
                                                    type="checkbox" name="is_check" id="is_check" checked
                                                    value="online"> REDEEM REFERAl EARNING </label>

                                        </div>
                                        <small>Only of Referral Earning can be use at a time.Oldest Referral Earning will be
                                            used first and only be used in case of online payment. <a
                                                href="{{ url('post/privacy-policy-16') }}" target="_blank"
                                                class="custom-text-primary custom-fw-600">T&C Applied</a></small>
                                    </div>
                                    <div class="form-group ">
                                        <label
                                            class="custom-bg-secondary-400 px-3 py-2 w-100 custom-fs-18 custom-fw-600 cursor-pointer"><input
                                                type="radio" name="payment_type" id="payment_type" checked
                                                value="online"> Pay Now</label>
                                    </div>

                                    <div class="form-group ">
                                        <label
                                            class="custom-bg-secondary-400 px-3 py-2 w-100 custom-fs-18 custom-fw-600 cursor-pointer"><input
                                                type="radio" name="payment_type" id="payment_type" class=""
                                                value="offline"> Pay At Hotel</label>
                                    </div>
                                    <button class="custom-bg-primary text-white btn w-100 custom-fw-700">Proceed</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 order-md-2 order-1">
                            <x-errormsg/>
                            <div class="card  border-none border-0 shadow-m">

                        <a data-toggle="collapse" href="#price" role="button" aria-expanded="false"
                            aria-controls="price"
                            class="custom-fs-22 custom-fw-700 text-dark d-flex justify-content-between text-uppercase px-3 p-2 border-bottom">
                            <span> Price Summary</span>
                            <span class="custom-fs-22  p-1 "> <i class="fas fa-chevron-circle-down"></i></span>

                        </a>

                        <div class="collapse show" id="price">
                            <div class="p-3 text-dark custom-fw-600 custom-fs-18">
                                <div class="d-flex justify-content-between my-2">
                                    <p>Sub Total</p>
                                    <p>
                                       {{ $price}}
                                    </p>

                                </div>
                                @if ($discount_amount != 0)
                                <div class="d-flex justify-content-between my-2">
                                    <p>Discount
                                    </p>
                                    <p>
                                          {{  $discount_amount}}

                                    </p>

                                </div>
                                @endif


                                <div class="d-flex justify-content-between my-2">
                                    <p>Taxes and Fees</p>
                                    <p>
                                        {{$tax}}
                                    </p>

                                </div>



                                <div
                                    class="d-flex justify-content-between border-top border-bottom custom-fw-700 custom-fs-20 my-3 pt-3 pb-2">
                                    <p>Payable Amount</p>
                                    <p>
                                        {{$total_price}}

                                    </p>

                                </div>

                                <div>
                                    @if (session()->has('discount'))
                                        <div class="alert alert-success d-flex justify-content-between align-items-center">
                                            <i class="fas fa-tag text-success"></i>
                                            {{ session()->get('discount.name') }} Promo Code Applied  <a href="{{route('coupon.remove')}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                        </div>
                                    @else
                                        <form action="{{ route('coupon.apply') }}"
                                            class="border d-flex justify-content-between py-2 px-3" method="POST">
                                            @csrf
                                            <input type="text" name="coupon" id=""
                                                class="border-none outline-none shadow-none"
                                                placeholder="Have a Promocode ?">
                                            <input type="hidden" name="price" value="{{ $price }}">
                                            <button
                                                class="custom-bg-primary btn text-white border-0 border-none outline-none shadow-none">Apply</button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>

@endsection
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
