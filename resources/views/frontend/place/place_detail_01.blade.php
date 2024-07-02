@extends('frontend.layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ filepath('frontend/splide.css') }}">
    <link rel="stylesheet" href="{{ filepath('frontend/jquery.lightbox.css') }}">
    <style>
        @media (max-width: 767px) {
            .nsnhotelsleftsearch .form-control {
                font-size: 14px !important;
            }
        }

        .product__booking__container .product__booking__login {
            background: radial-gradient(ellipse at 30% 80%, var(--color-primary) 0%, var(--color-secondary) 50%, var(--color-primary) 100%);
        }

        .lightbox__nav--prev {
            background: url("{{ asset('previous.png') }}") !important
        }

        .lightbox__nav--next {
            background: url("{{ asset('next.png') }}") !important
        }

        .banquet_contact input,
        .banquet_contact select,
        .banquet_contact textarea {
            border-radius: 0px;
            outline: none;
            box-shadow: none;
            background: rgb(12, 32, 66);
            border: 0px;
            text-transform: uppercase;
            color: rgb(192, 186, 186) !important;

        }

        .banquet_contact input::placeholder,
        .banquet_contact select::placeholder,
        .banquet_contact textarea::placeholder {
            color: rgb(192, 186, 186) !important;
        }

        .banquet_contact input:focus,
        .banquet_contact textarea:focus {
            background: rgb(12, 32, 66);
            outline: none;
            box-shadow: none;
            border: 0px;
        }

        html,
        body {
            scroll-behavior: smooth;
        }
    </style>
@endpush
@section('main')
    @php
        $name = $place->name;
    @endphp

    <div class="product__slider splide">
        <div class="splide__track">
            <ul class="splide__list gallery" id="productSlider">

                @if (isset($place->gallery) && $place->gallery != '')
                    @foreach ($place->gallery as $gallery)
                        <a href="{{ getImageUrl($gallery) }}" class="splide__slide shadow-sm">
                            <img src="{{ getImageUrl($gallery) }}" class="img-fluid" alt="{{ $place->name }}">
                        </a>
                    @endforeach
                @else
                    <li class="">
                        <img src="https://via.placeholder.com/1280x480?text=NSN" alt="{{ $place->name }}"
                            class="img-responsive" width="1920" height="576" />
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="product__main custom-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__info info__container">
                        <div class="row">
                            <div class="col-8 col-sm-10">
                                <h1 class="custom-fs-24 custom-fw-800">{{ $place->name }}</h1>
                                <p>
                                    {{ $place->address }}
                                </p>
                            </div>
                            <div class="col-3 col-sm-2">
                                <div class="product__rating">


                                    <small>
                                        <div class="top">
                                            @if (count($place->ratings) > 0)
                                                {{ number_format($place->avgReview, 1) }}
                                            @else
                                                0
                                            @endif/5
                                    </small> <svg viewBox="0 0 9 10" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.25 9.5a.238.238 0 01-.12-.032L4.5 7.948l-2.63 1.52a.238.238 0 01-.265-.017.271.271 0 01-.102-.26l.48-3.042-1.91-2.021a.276.276 0 01-.061-.268.255.255 0 01.197-.18l2.874-.508L4.276.646A.25.25 0 014.5.5c.094 0 .181.057.223.146l1.194 2.526 2.874.508a.255.255 0 01.197.18.275.275 0 01-.061.268l-1.91 2.021.48 3.042c.015.1-.024.201-.102.26a.242.242 0 01-.145.049z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="bot">
                                    {{ count($place->ratings) }} Ratings
                                </div>
                                <div class="d-md-none d-block">
                                    <a href="#booking_form_dev" class="btn btn-primary custom-bg-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__description info__container">
                    <h3>Description</h3>

                    {!! Str::substr($place->description,0, 320) !!}<span class="d-none toggle_content">{!! Str::substr($place->description, 320) !!}
                    </span>
                    @if (strlen(strip_tags($place->description)) >= 325)
                    <a  class="link__red" onclick="toggleContent(this,'toggle_content')">Show More</a>
                    @endif

                </div>
                <div class="product__amenities info__container">
                    <h3>Amenities</h3>

                    <div class="">
                        <div class="nsnhotelsamenities  row">
                            @if ($amenities)
                                @foreach ($amenities as $key => $item)
                                    @if ($key < 6)
                                        <div class="place__amenity col-md-4 col-6 my-2">
                                            <img src="{{ getImageUrl($item->thumbnail) }}" alt="{{ $item->name }}"
                                                width="20" height="26" loading="lazy">
                                            <span
                                                class="text-dark font-weight-bold @if($item->id == 15)  text-success @endif">{{ $item->name }}</span>
                                        </div>
                                    @else
                                        <div class="place__amenity col-md-4 col-6 my-2 d-none toggle_amenity">
                                            <img src="{{ getImageUrl($item->thumbnail) }}" alt="{{ $item->name }}"
                                                width="20" height="26" loading="lazy">
                                            <span
                                                class="font-weight-bold @if ($item->id == 15) text-success @endif">{{ $item->name }}</span>
                                        </div>
                                    @endif
                                @endforeach

                            @endif
                        </div>
                        @if (count($amenities)>6)
                        <div class="mt-2">
                          <a  class="link__red " onclick="toggleContent(this,'toggle_amenity')">Show More</a>
                        </div>
                      @endif

                    </div>
                </div>
                <div class="choose__room info__container" id="room_type_list">
                    <h3>Choose your room</h3>

                    @if ($place->roomsData)
                        @foreach ($place->roomsData as $item)
                            <div class="room__cat">
                                <div class="top">
                                    <div class="left">
                                        <div class="cat">
                                            {{ $item->name }} <i
                                                class="fa fa-check-circle mx-1  text-success name_checked @if ($loop->index == 0) d-inline-block
                                            @else
                                            d-none @endif"
                                                id="room{{ $item->id }}"></i>
                                        </div>


                                        <div class="amenities">
                                            <div class="product__amenities info__container">
                                                <h3>Amenities</h3>

                                                @if ($item->amentity)
                                                        <div class="row">
                                                            @foreach (App\Models\Amenity::whereIn('id',$item->amentity)->limit(4)->get() as $key => $items)
                                                                    <div
                                                                        class=" col-md-3 col-6 my-2">
                                                                        <img src="{{ getImageUrl($items->thumbnail) }}"
                                                                            alt="{{ $items->name }}" width="26"
                                                                            height="26">
                                                                        <span>{{ $items->name }}</span>
                                                                    </div>
                                                            @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="right gallerys">
                                        <!-- ONLY FIRST IMAGE WILL BE SHOWN  -->
                                        @if ($item->thumbnail && file_exists(getImageUrl($item->thumbnail)))
                                            <a href="{{ getImageUrl($item->thumbnail) }}">
                                                <img src="{{ getImageUrl($item->thumbnail) }}" alt="{{ $place->name }}"
                                                    class="img-fluid" loading="lazy">

                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13"
                                                        viewBox="0 0 16 13">
                                                        <path fill="white" fill-rule="evenodd"
                                                            d="M1.016.467h14.48c.267 0 .483.207.483.463v10.978c0 .256-.216.678-.483.678H1.016c-.266 0-.483-.422-.483-.678V.93c0-.256.217-.463.483-.463zm.483 8.984v2.142h9.025L5.183 6.096a.404.404 0 00-.295-.128.403.403 0 00-.291.135L1.499 9.45zm9.653-2.494c-1.065 0-1.93-.832-1.93-1.855 0-1.022.865-1.854 1.93-1.854s1.931.832 1.931 1.854c0 1.023-.866 1.855-1.93 1.855zm0-2.782c-.532 0-.965.417-.965.927 0 .511.433.928.965.928s.966-.417.966-.928c0-.51-.434-.927-.966-.927zm3.862 7.418v-10.2H1.499v6.662l2.376-2.568a1.374 1.374 0 011.001-.446c.385-.004.744.146 1.013.423l5.955 6.129h3.17z">
                                                        </path>
                                                    </svg>
                                                </span>

                                            </a>
                                        @endif
                                        @if ($item->gallery)
                                            @foreach ($item->gallery as $subitem)
                                                <a href="{{ getImageUrl($subitem) }}">
                                                    <img src="{{ getImageUrl($subitem) }}" alt="{{ $place->name }}etewtr"
                                                        class="img-fluid" loading="lazy">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="13" viewBox="0 0 16 13">
                                                            <path fill="white" fill-rule="evenodd"
                                                                d="M1.016.467h14.48c.267 0 .483.207.483.463v10.978c0 .256-.216.678-.483.678H1.016c-.266 0-.483-.422-.483-.678V.93c0-.256.217-.463.483-.463zm.483 8.984v2.142h9.025L5.183 6.096a.404.404 0 00-.295-.128.403.403 0 00-.291.135L1.499 9.45zm9.653-2.494c-1.065 0-1.93-.832-1.93-1.855 0-1.022.865-1.854 1.93-1.854s1.931.832 1.931 1.854c0 1.023-.866 1.855-1.93 1.855zm0-2.782c-.532 0-.965.417-.965.927 0 .511.433.928.965.928s.966-.417.966-.928c0-.51-.434-.927-.966-.927zm3.862 7.418v-10.2H1.499v6.662l2.376-2.568a1.374 1.374 0 011.001-.446c.385-.004.744.146 1.013.423l5.955 6.129h3.17z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </a>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                                <div class="bot">
                                    <div class="left">
                                        <div class="price">
                                            ₹ {{ $item->onepersonprice }}
                                            <span>{{ $item->before_discount_price }}</span>
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn__primary d-flex align-items-center select_room_btn @if ($loop->index == 0) border-success
                                    @else
                                    border-secondary @endif"
                                        data-id="{{ $item->id }}" data-oneprice="{{ $item->onepersonprice }}"
                                        data-twoprice="{{ $item->twopersonprice }}"
                                        data-threeprice="{{ $item->threepersonprice }}" data-name="{{ $item->name }}"
                                        data-hourlyprice="{{ $item->hourlyprice }}">
                                        <i
                                            class="fa fa-check-circle mx-1  text-success

                                  @if ($loop->index == 0) d-inline-block
                                            @else
                                            d-none @endif"></i>
                                        SELECT
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="hotel__policies info__container">
                    <h3>Hotel policies</h3>
                    @if ($place->city->slug == 'puri')
                        <div class="check__time">
                            <div class="time">
                                Check-in
                                <span>08:00 AM onwards</span>
                            </div>
                            <div class="br"></div>
                            <div class="time">
                                Check-out
                                <span>07:00 AM </span>
                            </div>
                        </div>
                    @else
                        <div class="check__time">
                            <div class="time">
                                Check-in
                                <span>12:00 PM onwards</span>
                            </div>
                            <div class="br"></div>
                            <div class="time">
                                Check-out
                                <span>11:00 AM </span>
                            </div>
                        </div>
                    @endif


                    <ul class="policies">
                        <li>
                            All prices are inclusive of taxes.
                        </li>
                        <li>
                            Couples are welcome
                        </li>
                        <li>Guests can check in using any Government issued ID proof
                        </li>
                    </ul>

                    <a href="https://www.nsnhotels.com/post/privacy-policy-16" class="link__red">View Guest Policy</a>
                </div>


                <div class="">
                    @include('frontend.place.review', $place)
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product__booking__container p-0  ">
                    {{-- <div class="product__booking__login  text-center mx-auto d-flex justify-content-center">
                        <div class=" text-center">


                            <span class="custom-fs-22 custom-fw-800 text-center ">
                                Booking Details
                            </span>

                        </div> <span class="btn cutom-bg-primary custom-fw-600  w-25 py-1"
                                onclick="window.location='{{ route('user_login') }}'">
                                LOGIN
                            </span>
                    </div> --}}

                    @if (Carbon\Carbon::parse($place->o_u_s_from) >= today() && Carbon\Carbon::parse($place->o_u_s_to) <= today())
                        <div class="  mt-1 bg-danger text-white custom-fw-600 p-2 px-3">No
                            Room Left, Property Fully Booked</div>
                    @else
                        <div class="  mt-1 custom-bg-primary text-white custom-fw-600 p-2 px-3">Booking Detail</div>
                    @endif

                    <div class="product__booking p-0" id="booking_form_dev">

                        <div class="">
                            <div class="bookingonline p-0">

                                <div class="nsnhotelsleftsearch">

                                    <form class="leftsearchform" name="bookRoomForm" action="{{ route('book.now') }}"
                                        method="GET">
                                        @csrf
                                        <div class="row">
                                        <div class="col-12 mt-1 mb-3">
                                            <div class="text-dark font-weight-bold custom-fs-18">
                                                ₹ <span id="price" class="custom-fs-22"></span>
                                                <div class="custom-fs-14 custom-fw-500">Inclusive of all taxes
                                                </div>
                                            </div>
                                        </div>
                                            @if (isset($place->roomsData[0]))
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <a class="form-group" href="#room_type_list">
                                                        <div class="product__booking__type">
                                                          <i class="fas fa-hotel"></i>

                                                            <span id="room_name">
                                                                {{ isset($place->roomsData[0]) ? $place->roomsData[0]->name : '' }}
                                                            </span>

                                                            <span class="fas fa-edit text-right ml-auto"></span>
                                                        </div>
                                                    </a>
                                                </div>


                                                <div class="col-12 col-sm-12 col-md-12" id="">
                                                    <div class="form-group booking_type_div">
                                                        <label>Booking Type:</label>
                                                        <select class="form-control" name="booking_type"
                                                            id="booking_type">
                                                            <option value="1">Select Booking Type</option>

                                                            @if (isset($place->roomsData->first()->hourlyprice))
                                                                <option value="hourlyprice"
                                                                    @if (Request::segment(3) == 'hourly') selected @endif>3
                                                                    Hours Price</option>
                                                            @endif
                                                            <option value="night_price" selected>Night
                                                                Price</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6">
                                                    <div class="form-group">

                                                        <label>No. of Room:</label>
                                                        <div>
                                                            <div class="d-flex">
                                                                <button type="button"
                                                                    class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                    id="room_minus"><i
                                                                        class="text-white fas fa-minus"></i></button>
                                                                <input type="number" readonly
                                                                    class="form-control  w-50 text-center custom-fs-26"
                                                                    min="1" max="5" value="1"
                                                                    id="number_of_room" name="number_of_room">
                                                                <button type="button"
                                                                    class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                    id="room_plus"><i
                                                                        class="text-white fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Adult:</label>
                                                        <div>
                                                            <div class="d-flex">
                                                                <button type="button"
                                                                    class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                    id="adult_minus"><i
                                                                        class="text-white fas fa-minus"></i></button>
                                                                <input type="number" readonly
                                                                    class="form-control w-50 text-center" min="1"
                                                                    id="number_of_adult" value="1"
                                                                    name="number_of_adult">
                                                                <button type="button"
                                                                    class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                    id="adult_plus"><i
                                                                        class="text-white fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>




                                        <div class="row">
                                            <div class="col-10 offset-2 offset-md-0 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Children:</label>
                                                    <div>
                                                        <div class="d-flex">
                                                            <button type="button"
                                                                class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                id="child_minus"><i
                                                                    class="text-white fas fa-minus"></i></button>
                                                            <input type="number" readonly
                                                                class="form-control text-center w-50" id="number_of_child"
                                                                value="0" name="number_of_child">
                                                            <button type="button"
                                                                class="border-none border-0 shadow-none outline-none px-2 custom-bg-primary py-2 "
                                                                id="child_plus"><i
                                                                    class="text-white fas fa-plus"></i></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group bookdate-container">
                                                    <label>Check-In / Check Out</label>
                                                    <input type="text" class="form-control" autocomplete="off"
                                                        placeholder="Date In-Out" name="bookdates" id="checkInOuts"
                                                        value="" onchange="">
                                               <input type="hidden"  id="price_input" name="price" >

                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row m-0">
                                            <div class="form-group">
                                                <label data-toggle="tooltip" data-placement="top"
                                                    title="Extra Charges is Applicable depends upon the Availability of Rooms."><input
                                                        type="checkbox" name="" id="is_early" /> Request of early
                                                    check in/check out:</label>

                                                <textarea name="reason_for_early_checkout" id="reason_for_early_checkout" class="form-control d-none w-100"
                                                    rows="1"></textarea>
                                            </div>
                                        </div> --}}

                                        <div class="form-group mb-0">

                                            @php
                                                $rooms = json_encode($place->roomsData);

                                                $segment = Request::segment(3);
                                            @endphp
                                            <input type="hidden" id="place_id" name="place_id"
                                                value="{{ $place->id }}">
                                            <input type="hidden" id="room_id" name="room_id"
                                                value="{{ $place->roomsData[0]->id }}">
                                            <input type="hidden" id="room_type" name="room_type"
                                                value="{{ $place->roomsData[0]->name }}">

                                                <div class="form-group mt-4 ">
                                                    <div class="row">

                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 text-center">
                                                        <button class="btn custom-bg-primary text-white d-block w-100 px-5"
                                                            onclick=""
                                                            @if (Carbon\Carbon::parse($place->o_u_s_from) >= today() && Carbon\Carbon::parse($place->o_u_s_to) <= today()) type="button"
                                                                disabled @endif>Book
                                                            Now</button>
                                                    </div>
                                                </div>
                                        </div>


                                        @include('frontend.place.offer')

                                    </form>
                                </div>
                                @endif
                            </div>



                            <p class="guest__policie px-2 py-1">By proceeding, you agree to our <a
                                    href="https://www.nsnhotels.com/Cancellation-and-Reservation.pdf"
                                    class="link__red">Guest
                                    Policies.</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>


            <div class="nsnrecentlyadded pb-5 mt-5">
                    <h2 class="mb-3 font-weight-bold">Other Nearest Hotels</h2>
                <div>
                    <div class="row mx-2">
                        @foreach ($similar_places as $place)
                            <div class="col-md-3 col-lg-3 col-6 col-sm-6 mx-0 px-0">
                                @include('frontend.partials.card1', ['place' => $place])

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </div>
    </div>


    <br>

@endsection
@push('scripts')
    <script src="{{ filepath('frontend/jss/plugins.js') }}"></script>
    <script src="{{ filepath('frontend/jss/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function() {

            //if booking type is selected to houly
            $('#booking_type').on('change', function() {
                if ($(this).val() == 'hourlyprice') {

                    let hrprice = $('.select_room_btn.border-success').data('hourlyprice');
                    if (hrprice != null) {
                        $('#price').html(hrprice)
                        $('#price_input').val(hrprice)

                    }
                }
            })

            let guest = sessionStorage.getItem('guest')
            let rooms = sessionStorage.getItem('guest')

            let price = 0;

            $(document).on('click', '.nav-tabs li a', function(e) {
                e.preventDefault()
                let href = $(this).attr('href')
                $(href).siblings().addClass('d-none')
                $(href).siblings().removeClass('d-block')
                $(href).removeClass('d-none')
                $(href).addClass('d-block')
                $(this).addClass('active')
                $(this).parent().siblings().children('a').removeClass('active')
            });
        });
    </script>
    <script src="{{ filepath('frontend/splide.min.js') }}"></script>
    <script src="{{ filepath('frontend/jquery.lightbox.js') }}"></script>


    <script>

   function toggleContent(ele,element){
    $(`.` + element).toggleClass('d-none');
    $(ele).html($(ele).html()=='Show More'?'Show Less':'Show More')

   }

        $(".close-btn, .bg-overlay").click(function() {
            $(".custom-model-main").removeClass('model-open');
        });

        $(function() {
            $('.gallery a').lightbox();
            $('.gallerys a').lightbox();

        });
        new Splide('.product__slider.splide', {
            type: 'loop',
            autoWidth: true,
            autoHeight: true,
            perPage: 2,
            focus: 'center',
            gap: 5,
            pagination: false,
        }).mount();


        $('#is_early').on('click', function() {
            $('#reason_for_early_checkout').toggleClass('d-none')
        })
    </script>



    <script>
        var no_of_room = $('#number_of_room');
        no_of_room.val(parseInt(sessionStorage.getItem('room')) || 1) //setting default number of room from sessionstorage

        var no_of_adult = $('#number_of_adult');
        no_of_adult.val(parseInt(sessionStorage.getItem('guest')) ||
            1) //setting default number of adult from sessionstorage

        var no_of_child = $('#number_of_child');
        var allowed_adult = 3
        var allowed_child = 2

        // increasing room value
        $('#room_plus').click(function() {
            var number_of_room = parseInt(no_of_room.val());

            if (number_of_room == 5) {
                toastr.error('Maximum 5 room can be added')
                return false;
            } else {
                no_of_room.val(number_of_room + 1)
                // console.log(number_of_room+1)

                allowedguestandchild() //method to dynamic change guest and child limit according to room
            }
            calculatePrice()
        })

        // decreasing room value
        $('#room_minus').click(function() {
            var number_of_room = parseInt(no_of_room.val());

            if (number_of_room == 1) {
                toastr.error('Minimum 1 room must be selected')
                return false;
            } else {
                no_of_room.val(number_of_room - 1)
                allowedguestandchild() //method to dynamic change guest and child limit according to room
                no_of_adult.val(1) //if user decreased room quantity then room and child chages to 1,0 respectively
                no_of_child.val(0)
            }
            calculatePrice()
        })



        // increasing adult value
        $('#adult_plus').click(function() {
            var number_of_adult = parseInt(no_of_adult.val())
            var number_of_room = parseInt(no_of_room.val());

            if (number_of_adult == allowed_adult) {
                toastr.error(`Maximum ${allowed_adult} adult  for ${number_of_room} room allowed`)
                return false;
            }
            no_of_adult.val(number_of_adult + 1)
            calculatePrice();

        })

        // decreasing room value
        $('#adult_minus').click(function() {

            var number_of_adult = parseInt(no_of_adult.val())
            if (number_of_adult == 1) {
                return false
            }
            no_of_adult.val(number_of_adult - 1)
            calculatePrice();

        })



        // increasing adult value
        $('#child_plus').click(function() {
            var number_of_child = parseInt(no_of_child.val())
            var number_of_room = parseInt(no_of_room.val());

            if (number_of_child == allowed_child) {
                toastr.error(`Maximum ${allowed_child} children  for ${number_of_room} room allowed`)
                return false;
            }
            no_of_child.val(number_of_child + 1)
        })

        // decreasing room value
        $('#child_minus').click(function() {
            var number_of_child = parseInt(no_of_child.val())
            if (number_of_child == 0) {

                return false
            }
            no_of_child.val(number_of_child - 1)
        })







        // change room on click

        $(document).on('click', '.select_room_btn', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#room_name').html(name)
            $('#room_type').val(name)
            $('#room_id').val(id)
            $('.select_room_btn i').addClass('d-none')
            $('.select_room_btn i').removeClass('d-inline-block')
            $(this).children('i').removeClass('d-none')
            $('.select_room_btn').removeClass('border-success')
            $(this).addClass('border-success')
            $(this).children('i').addClass('d-inline-block')
            $('.name_checked').addClass('d-none')
            $('.name_checked').removeClass('d-inline-block')
            $('#room' + id).removeClass('d-none')
            $('#room' + id).addClass('d-inline-block')
            calculatePrice();

        })

        calculatePrice();

        function calculatePrice() {
            let number_of_room = parseInt(no_of_room.val());
            let number_of_adult = parseInt(no_of_adult.val());
            let selected_room = $(".select_room_btn.border-success");

            let oneprice = parseInt(selected_room.data('oneprice'))
            let twoprice = parseInt(selected_room.data('twoprice')) || oneprice
            let diffinprice = selected_room.data('threeprice') ? selected_room.data('threeprice') - twoprice : twoprice -
                oneprice;
            let threeprice = selected_room.data('threeprice') ? parseInt(selected_room.data('threeprice')) : twoprice +
                diffinprice;
            let final_adult_price
            switch (number_of_adult) {
                case 1:
                    final_adult_price = number_of_room * oneprice
                    break;
                case 2:

                    if (number_of_room == 1) {
                        final_adult_price = twoprice
                    } else {
                        final_adult_price = 2 * oneprice
                    }

                    break;
                case 3:
                    if (number_of_room == 1) {
                        final_adult_price = threeprice
                    } else if (number_of_room == 2) {
                        final_adult_price = 2 * twoprice
                    } else {
                        final_adult_price = number_of_room * oneprice
                    }
                    break;

                case 4:
                    final_adult_price = number_of_room * twoprice
                    break;

                case 5:
                    if (number_of_room == 2) {
                        final_adult_price = (2 * twoprice) + diffinprice
                    } else {
                        final_adult_price = number_of_room * twoprice
                    }
                    break;

                case 6:
                    final_adult_price = number_of_room * threeprice
                    break;
                case 7:

                    if (number_of_room == 3) {
                        final_adult_price = (3 * twoprice) + diffinprice

                    } else {
                        final_adult_price = number_of_room * twoprice
                    }

                    break;
                case 8:

                    if (number_of_room == 3) {
                        final_adult_price = (3 * twoprice) + twoprice
                    } else {
                        final_adult_price = number_of_room * twoprice
                    }
                    break;
                case 9:

                    if (number_of_room == 3) {
                        final_adult_price = 3 * threeprice

                    } else {
                        final_adult_price = number_of_room * twoprice
                    }
                    break;
                case 10:

                    if (number_of_room == 4) {
                        final_adult_price = (2 * threeprice) + (2 * twoprice)

                    } else {
                        final_adult_price = number_of_room * twoprice
                    }

                    break;
                case 11:
                    final_adult_price = (2 * threeprice) + twoprice

                    if (number_of_room == 4) {
                        final_adult_price = (2 * threeprice) + (2 * twoprice) + diffinprice

                    } else {
                        final_adult_price = number_of_room * twoprice
                    }

                    break;
                case 12:
                    if (number_of_room == 4) {
                        final_adult_price = 4 * threeprice

                    } else {
                        final_adult_price = (3 * threeprice) + twoprice + diffinprice
                    }
                    break;
                case 13:
                    if (number_of_room == 4) {
                        final_adult_price = (4 * threeprice) + diffinprice

                    } else {
                        final_adult_price = (3 * threeprice) + (2 * twoprice)
                    }
                    break;
                case 14:
                    if (number_of_room == 4) {
                        final_adult_price = (3 * threeprice) + (2 * twoprice) + diffinprice

                    } else {
                        final_adult_price = (3 * threeprice) + (3 * twoprice)
                    }
                    break;
                case 15:
                    final_adult_price = 5 * threeprice
                    break;

                default:
                    final_adult_price = number_of_room * oneprice

                    break;
            }
            let from = sessionStorage.getItem("start_date");
            let to = sessionStorage.getItem("end_date");


            let diff = new Date(to).getTime() - new Date(from).getTime()
            let diffindays = diff / (1000 * 3600 * 24).toFixed(0);
            diffindays = diffindays != 0 ? diffindays : 1
            let final_price = diffindays * final_adult_price;
            $('#price').html(final_price)
            $('#price_input').val(final_price)

        }


        allowedguestandchild();
        // method to dynamic change guest and child limit according to room
        function allowedguestandchild() {
            var number_of_room = parseInt(no_of_room.val());
            allowed_adult = number_of_room * 3;
            allowed_child = number_of_room * 2;

        }
        var date = sessionStorage.getItem("start_date") ? sessionStorage.getItem("start_date") : new Date();
        var end_date = sessionStorage.getItem("end_date") ? moment(sessionStorage.getItem("end_date")) : (moment(date).add(
            1, 'days'));
        $('#checkInOuts').daterangepicker({
            "minDate": new Date(),
            "autoUpdateInput": true,
            "autoApply": true,
            "parentEl": "datecontiner",
            "startDate": moment(date),
            "endDate": end_date,
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('DD/MM/YYYY') + ' to ' + end.format(
                'DD/MM/YYYY') + ' (predefined range: ' + label + ')');
            sessionStorage.setItem("start_date", start.format('D MMMM, YYYY'));
            sessionStorage.setItem("end_date", end.format('D MMMM, YYYY'));
            calculatePrice()

        });
    </script>
@endpush
