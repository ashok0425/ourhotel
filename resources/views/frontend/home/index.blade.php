@extends('frontend.layouts.master')
@push('style')
    <style>
        .location_title {
            font-weight: bold;
            font-size: 18px;
            line-height: 24px;
            -webkit-letter-spacing: -0.35px;
            -moz-letter-spacing: -0.35px;
            -ms-letter-spacing: -0.35px;
            letter-spacing: -0.35px;
            margin-bottom: 16px;
            margin-top: 0px;
        }

        .splide__list {
            height: auto !important;
        }

        .modal {
            z-index: 9999;
        }

        .font_20 {
            font-size: 20px;
            color: #000;
        }

        .modal-content {
            width: 100%;
            padding: 5px;
        }

        .modal {
            padding: 0px;
        }

        .modal-dialog {
            margin: 0;
        }

        .cla {
            text-decoration: none;
            width: calc(100% - 32px);
            font-weight: 600;
            font-size: 16px;
            color: rgb(33, 33, 33);
            line-height: 32px;
            opacity: 1;
            padding: 12px 16px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .search_class {
            border: 0px;
            outline: none;
            border-radius: 5px;
            border: 1px solid gray;
        }

        .radius_50 {
            border-radius: 50%;
            min-height: 70px !important;
            width: 70px !important;
        }

        .nsnrecentstoriesboxcontent h2 {
            margin-top: 120px;
            background: rgba(0, 0, 0, .5);
            padding: 0.5rem;
            height: 80px;
        }

        .nsnrecentstoriesbox img {
            border-radius: 20px;
        }

        .hotel_card {
            height: 250px
        }

        @media (max-width:760px) {
            .hotel_card {
                height: 345px
            }
        }

        #mobile_location_modal {
            background-color: #fff;
            width: 98%;
            margin: auto;
            position: fixed;
            z-index: 9999;
            top: 100px;
            left: 5px;
            border-radius: 10px;

        }

        .bg-gradient {
            background: rgb(92, 196, 235);
            background: linear-gradient(310deg, rgba(92, 196, 235, 0.9864320728291317) 13%, rgba(30, 82, 157, 0.9668242296918768) 59%);
        }
    </style>
@endpush
@section('main')
    <div class="nsnnavi bg-white mb-0 d-none d-md-block">
        <div class="container city_list">
        </div>
    </div>
    <div class="bg-gradient pb-5 ">
        <div class="nsnbannerbackground ">
            <div class="nsnbannercontent mt-2 mt-md-0">
                <div class="col-12 mt-5  mt-md-4">
                    <h1 class="nsnhttext custom-fw-800 text-center">India's Fastest Growing Hotel Chain</h1>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        @include('frontend.home.partials.search')
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- offer section  --}}
    <div class="container mt-5">
        <div class="offer_section">

        </div>
    </div>

    <div id="mobile_location"></div>

    <div>
        @php
              use Jenssegers\Agent\Agent;
                $agent = new Agent();
        @endphp
        @include('frontend.home.partials.nearByhotel')
        @include('frontend.home.partials.top_rated')
        @include('frontend.home.partials.offer2')
        @include('frontend.home.partials.nsn_resort')
        @include('frontend.home.partials.offer1')
        @include('frontend.home.partials.downloadapp')
        @if (!$agent->isMobile())
        @include('frontend.home.partials.popular_location')
        @include('frontend.home.partials.blog')
        @endif
        @include('frontend.home.partials.offer3')




    </div>

    <div id="testimonial_section"></div>

    <div id="mobile_location_modal" class="d-none">
        <div class="modal-content">
            <div class="d-flex justify-content-around">
                <a href="#" type="button" class="back_modal text-dark" class="font_20">⬅</a>
                <input type="search" class="from-control py-1 w-100 search_class" placeholder="Search city or location">
            </div>
            <div class="modal-body all_location">

            </div>

        </div>
    </div>
@stop
@push('scripts')
    <script>
        setTimeout(() => {
            loadOfferAndTestimonial()
        }, 2000);


        function loadOfferAndTestimonial() {

            let offer =
                '<h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3 ">NSN Exclusive Offer</h2><div id="offer_bannerslider" class="owl-carousel mt-3 mb-2 mt-md-0 mb-md-0" >   ';
                    @foreach (coupons()->where('descr','!=',null)->take(4) as $item)
                offer += `<div class="card p-2 pb-0 border-0 shadow-sm">
                <div class="row pb-0">
                <div class="col-md-5">
                <img height="100" width="100" src="{{getImageUrl($item->mobile_thumbnail)}}" alt="offer image" class="img-fluid img_height" loading="lazy"></div>
                <div class="col-md-7 pb-0">
                <strong>use promocode </strong>
                <div style="border:1px dotted black;width:80px;" class="p-1 my-2" onclick='copyPromocode(this.innerHTML)' title="click to copy">{{$item->coupon_name}}</div>
                <p class="mt-2">{{$item->descr}}</p>
                <p class="mt-4 text-right pb-1 mb-0"><small>Valid till:{{Carbon\Carbon::parse($item->expired_at)->format('d M Y')}}</small></p>
                </div>
                </div>
            </div>

        `;
            @endforeach
            offer += `</div>`;
            $('.offer_section').html(offer)

            jQuery("#offer_bannerslider").owlCarousel({
                nav: true,
                dots: false,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 2000,
                navText: [],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        loop: true
                    },
                    600: {
                        items: 2,
                        nav: false,
                        loop: true
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        loop: true
                    },
                    1300: {
                        items: 3,
                        nav: false,
                        loop: true
                    }
                }
            });

            let testimonial =
                `<div class="nsnhotelspeoplessays mt-3 mt-md-0 container"><div class=""><h2 class="pl-0 pl-md-3 font-weight-bold text-dark custom-fs-20 custom-fw-600  mb-3">People Talking About Us</h2><div id="nsnhotelspeoplessays" class="owl-carousel">`;
                    @foreach (testimonials()->take(4) as $item)
                testimonial +=
                    `<div class="nsnhotelspeoplessaysbox"><div class="nsnhotelsclientname d-flex"><div><div class="user_icon"><i class="fas fa-user "></i></div></div> <div class="ml-2"><p class="mb-0">{{$item->name}}</p>"{{$item->feedback}}"</div></div></div>`
            @endforeach


            testimonial += `</div></div></div>`
            $('#testimonial_section').html(testimonial)
            jQuery("#nsnhotelspeoplessays").owlCarousel({
                items: 2,
                itemsMobile: [599, 1],
                nav: false,
                navText: true,
                margin: 20,
                navigationText: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        loop: true
                    },
                    600: {
                        items: 1,
                        nav: false,
                        loop: true
                    },
                    1000: {
                        items: 2,
                        nav: false,
                        loop: true
                    }
                }
            });
        }



        // loading city with images
        $(window).on('load', function() {
            let cityList =
                '<div class="nsnnavi bg-white mb-0 d-none d-md-block"><div class="container"><div id="bannerslider" class="owl-carousel">';
            @foreach (popular_cities() as $city)
                cityList += '<div class="nsnpopulabox mt-5 mt-md-0">';
                @php
                    $url_city = 'city=' . $city->id;
                @endphp
                cityList +=
                    '<a href="{{ route('city-search', strtolower($city->name)) }}" class="nav-link"><img src="{{ getImageUrl($city->thumb) }}" alt="{{ $city->name }}" /><span>{{ $city->name }}</span> </a></div>';
            @endforeach
            cityList += '</div></div></div>';
            $('.city_list').html(cityList);
            jQuery("#bannerslider").owlCarousel({
                nav: true,
                dots: false,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 2000,
                navText: [],
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 5
                    },
                    1000: {
                        items: 10
                    }
                }
            });
        })





        if ($(window).width() < 560) {
            setTimeout(() => {
                $.ajax({
                    url: '{{ url('load-mobile-content') }}/',
                    success: function(res) {
                        $html = `<div class=""><h2 class="container font-weight-bold text-dark custom-fs-20 custom-fw-600 py-3">Explore your next destination</h2><div class="product__slider">
                             <div class="owl-carousel" id="mobile_location_slider">`;

                        res.map((item) => {
                            $html += `<a href="https://d27s5h82rwvc4v.cloudfront.net/uploads/${item.thumb}" class="shadow-sm location_tab w-25" data-id="${item.id}" data-toggle="modal" data-target="#location_modal">

                      <img src="https://d27s5h82rwvc4v.cloudfront.net/uploads/${item.thumb}" class="img-fluid radius_50 " alt="${item.name}" >
                      <p class="text-center mt-1 text-dark font-weight-bold">${item.name}</p>
                  </a>`;
                        })

                        $html += `
          </div>
      </div>
   </div>`;
                        $('#mobile_location').append($html);
                        jQuery("#mobile_location_slider").owlCarousel({
                            items: 2,
                            itemsMobile: [599, 1],
                            nav: false,
                            navText: true,
                            margin: 20,
                            navigationText: true,
                            autoplay: true,
                            autoplayTimeout: 5000,
                            autoplayHoverPause: true,
                            responsiveClass: true,
                            responsive: {
                                0: {
                                    items: 4,
                                    nav: false,
                                    loop: true
                                },
                            }
                        });
                    }
                })

            }, 1000);
        }
    </script>



    <script>
        let id;
        $(document).on('click', '.location_tab', function() {
            id = $(this).data('id')
            $('.search_class').val('')
            loadcity(id)
            $('#mobile_location_modal').removeClass('d-none')
            $('#mobile_location_modal').addClass('d-block')

        })

        $(document).on('keyup', '.search_class', function() {
            let keyword = $(this).val()
            loadcity(id, keyword)
        })


        function loadcity($id, $keyword = '') {
            $.ajax({
                url: '{{ url('load-subcity') }}',
                data: {
                    id: $id,
                    search: $keyword
                },
                success: function(res) {
                    console.log(res);
                    $('.all_location').html(res)
                }
            })
        }

        $('.back_modal').click(function() {
            $('#mobile_location_modal').removeClass('d-block')
            $('#mobile_location_modal').addClass('d-none')
        })
    </script>

    <script>

 function copyPromocode(val) {


  // Copy the text inside the text field
  navigator.clipboard.writeText(val);

  // Alert the copied text
  toastr.success("Copied the text: " + val);
}

    </script>
@endpush
