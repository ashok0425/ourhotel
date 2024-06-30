@extends('frontend.layouts.master')
@push('style')
    <link rel="preload stylesheet" href="{{ asset('frontend/css/search/search.css') }}" as="style">
    <style>
        .scroll_btn {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background: var(--color-primary);
            cursor: pointer;
            padding: 12px 15px;
            color: #fff;
            border-radius: 5px;
        }

        .list-style-disc {
            list-style: disc !important;
        }

        html,
        body {
            scroll-behavior: smooth;
        }

        .main-item {
            background-color: #fff;
            width: 100%;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            border-radius: 20px;
        }

        .background-masker {
            background-color: #fff;
            position: absolute;
        }



        @keyframes placeHolderShimmer {
            0% {
                background-position: -800px 0
            }

            100% {
                background-position: 800px 0
            }
        }

        .animated-background {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            border-radius: 20px;
            animation-duration: 2s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: placeHolderShimmer;
            animation-timing-function: linear;
            background-color: #fff !important;
            background: linear-gradient(to right, #eeeeee 8%, #e4e4e4 18%, #ebebeb 33%);
            background-size: 800px 104px;
            height: 200px;
            position: relative;
        }
    </style>
@endpush
@section('main')


    {{-- upper search start --}}
    <div class="custom-bg-primary py-3" id="nsnhotelssearchdata">
        <div class="container header-search mt-5 mt-md-0 ">

            @include('frontend.search.partial.search_top_form')
        </div>
    </div>
    {{-- upper search End --}}
    @php
        $id = $id;
        $type = $type;
        $cityname = $cityname;
    @endphp
    <div class="nsnsearchmidcontent">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3">
                    {{-- sidebar Filter  --}}
                    <div class="sticky-top d-none d-md-block">
                        @include('frontend.search.partial.search_filter')
                    </div>
                    {{-- sidebar filter End  --}}
                </div>


                <div class="col-12 col-sm-9 col-md-9">
                    {{-- <h1 class="nsnsearchhttext text-center py-2"></h1> --}}
                    <div class="nsnhotelssorting ">
                        <ul class="p-2 d-block custom-bg-white shadow-sm">
                            <li class="cutom-fs-20 custom-fw-600 custom-text-primary d-flex align-items-center">
                                <span class="custom-fs-24 custom-fw-800 custom-text-primary total_places">
                                    <div class="spinner-border  custom-text-primary " role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </span>
                                &nbsp;&nbsp;&nbsp; properties found
                            </li>
                            {{-- {{$cityname? "in $cityname":''}} --}}
                        </ul>
                    </div>
                    <div class="nsnhotelssearchdata">
                        <div class="spinner">
                            <div class="main-item">
                                <div class="animated-background">
                                    <div class="background-masker btn-divide-left"></div>
                                </div>
                            </div>
                            <div class="main-item mt-4">
                                <div class="animated-background">
                                    <div class="background-masker btn-divide-left"></div>
                                </div>
                            </div>

                            <div class="main-item mt-4">
                                <div class="animated-background">
                                    <div class="background-masker btn-divide-left"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (isset($faq) && count($faq) > 0)

                        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
      @php
      $num_of_items = count($faq);
      $num_count = 0;
      @endphp
      @foreach($faq  as $faqs)
      {
    "@type": "Question",
    "name": "{{$faqs->question}}",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "{{$faqs->answer}}"
    }
  }
  <?php   $num_count = $num_count + 1;
    if($num_count < $num_of_items)
      echo ","; ?>
  @endforeach
  ]
}
</script>
                        <hr>
                        <div class=" mt-5">
                            <div class="row">
                                <div class="col">
                                    <p class="lead">Frequently asked questions</p>
                                </div>
                                <div class="col text-right">
                                    <p>Ask a question <i class="fa fa-pencil" aria-hidden="true"></i></p>
                                </div>
                            </div>

                            @php $i = 1;@endphp
                            @foreach ($faq as $faqs)
                                <button type="button" class="collapsible border-none"><b>{{ $i }})
                                        {{ $faqs->question }}</b></button>
                                <div class="content formatedtxt">
                                    <p class="mt-2" style="font-size: 80%;">@php echo $faqs->answer; @endphp</p>
                                </div>
                                @php $i++;@endphp
                            @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="scroll_btn">
        <a href="#nsnhotelssearchdata" class="text-white">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    <input type="hidden" id="get_url" value="{{ request()->fullUrl() }}">
@stop

@push('scripts')
    <script>
        function Assistance(id) {
            $(".hideAssistance").hide();
            var myClasses = document.querySelectorAll('.hideAssistance'),
                i = 0,
                l = myClasses.length;
            for (i; i < l; i++) {
                myClasses[i].style.display = 'none';
            }
            $(".showAssistance" + id).show();
        }

        // whatsapp hide
        $(document).ready(function() {
            $("#load_more").click(function(e) {
                e.preventDefault();
                $('.more_content').toggleClass('d-none')
            })

            let isajax_applied = false;
            let place_type = [];
            let star = [];
            let price_filter = $('.price_filter:checked').val();

            ajaxSearch();

            // place filter
            $('.place_type_filter').click(function() {
                var value = $(this).val();
                if ($(this).is(':checked')) {
                    place_type.push(value); // Add to array if checked
                } else {
                    var index = place_type.indexOf(value);
                    if (index !== -1) {
                        place_type.splice(index, 1); // Remove from array if unchecked
                    }
                }
                ajaxSearch();
            })
            $('.price_filter').click(function() {
                price_filter = $(this).val();
                ajaxSearch();

            })
            $('.star_rating').click(function() {
                var value = $(this).val();
                if ($(this).is(':checked')) {
                    star.push(value); // Add to array if checked
                } else {
                    var index = place_type.indexOf(value);
                    if (index !== -1) {
                        star.splice(index, 1); // Remove from array if unchecked
                    }
                }
                ajaxSearch();
            })


            function ajaxSearch() {
                isajax_applied = true;
                $.ajax({
                    url: '{{ url('ajax-search') }}',
                    data: {
                        star: star,
                        place_type: place_type,
                        price_filter: price_filter,
                        city_id: "{{ $cityId }}",
                        area_id: "{{ $areaId }}",
                    },
                    success: function(res) {
                        $('.total_places').html(res.meta.total)
                        let html = ``;
                        res.data.forEach(item => {
                            html += generatePlaceCard(item)
                        })
                        $('.nsnhotelssearchdata').html(html)
                        $(".hideAssistance").hide();

                    }
                })
            }



            function generatePlaceCard(place) {
                // Initialize variables
                let html = '';

                // Start building the HTML structure
                html += `<div class="row custom-border-radius-20 m-0 shadow-sm p-3 mb-3 bg-white ">
        <div class="col-12 col-sm-9 col-md-9">
            <div class="row">
                <div class="col-12 col-sm-5 col-md-5 nsnhotelsphoto pr-0">
                    <div id="${place.couple_friendly === 1 ? 'display_after' : ''}">
                        <div class="nsnhotelsimagesliderbox ">
                            <img src="${place.thumbnail ? place.thumbnail : 'https://via.placeholder.com/1920x1200?text=NSN'}" alt="${place.name}" class="img-responsive pr-2" style="border-radius:5px" height="189" width="269" loading='lazy' />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-md-7 ">
                    <div class="nsnhotelsname"><a href="${place.route}" class="custom-fs-20 custom-fw-800 custom-text-primary">${place.name}</a></div>
                    <h6 class="custom-fs-12 custom-fw-600 py-1 custom-text-secondary">${place.address}</h6>
                    <div class="d-flex justify-content-between">
                        <div class="my-2 mb-3 ${place.couple_friendly === 1 ? 'd-block' : 'd-none'}">
                            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Couple Friendly</div>
                            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Local ID Accepted</div>
                            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Pay At Hotel</div>
                        </div>
                        &nbsp;
                        &nbsp;
                        <div class="nsnhotelsreviews text-right d-md-none d-inline">
                            <div class="product__rating ">
                                <div class="top">
                                    <small>${place.avg_rating}/5</small>
                                    <br>
                                    <svg viewBox="0 0 9 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.25 9.5a.238.238 0 01-.12-.032L4.5 7.948l-2.63 1.52a.238.238 0 01-.265-.017.271.271 0 01-.102-.26l.48-3.042-1.91-2.021a.276.276 0 01-.061-.268.255.255 0 01.197-.18l2.874-.508L4.276.646A.25.25 0 014.5.5c.094 0 .181.057.223.146l1.194 2.526 2.874.508a.255.255 0 01.197.18.275.275 0 01-.061.268l-1.91 2.021.48 3.042c.015.1-.024.201-.102.26a.242.242 0 01-.145.049z"></path>
                                    </svg>
                                </div>
                                <div class="bot">${place.rating_count} Ratings</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul>`;

                // Iterate over amenitiesList and add items to the HTML
                place.amenitiesList.forEach(item => {
                    html +=
                        `<li class="border float-left custom-border-radius-5 bg_animities mb-1 mx-1 p-1"><img src="{{ config('services.s3.url') . 'uploads/' }}${item.thumbnail}" alt="${item.name}" width="26" height="26" loading='lazy'/></li>`;
                });

                // Complete the HTML structure
                html += `</ul>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-3 col-md-3 nsnhotelssearchdatarightarea">
    <div class="nsnhotelsreviews text-right">
        <div class="product__rating d-none d-md-block">
            <div class="top">
                <small>${place.avg_rating}/5</small>
                <br>
                <svg viewBox="0 0 9 10" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.25 9.5a.238.238 0 01-.12-.032L4.5 7.948l-2.63 1.52a.238.238 0 01-.265-.017.271.271 0 01-.102-.26l.48-3.042-1.91-2.021a.276.276 0 01-.061-.268.255.255 0 01.197-.18l2.874-.508L4.276.646A.25.25 0 014.5.5c.094 0 .181.057.223.146l1.194 2.526 2.874.508a.255.255 0 01.197.18.275.275 0 01-.061.268l-1.91 2.021.48 3.042c.015.1-.024.201-.102.26a.242.242 0 01-.145.049z"></path>
                </svg>
            </div>
            <div class="bot">${place.rating_count} Ratings</div>
        </div>
    </div>
    <div class="nsnhotelspernightpricevalue">
        <p class="custom-text-primary custom-fs-18 custom-fw-600 mb-0 pb-0 line-height-1 mb-2">
            ${place.price}
            <span class="custom-fs-12"> + GST / Per Night</span>
        </p>`;

                // Check for discount_percent and add if available
                if (place.discount_percent) {
                    html += `<p class="my-0 py-0 line-height-1 mb-2">
            <s class="custom-fs-14 custom-fw-600 text-danger">${place.price_before_discount}</s>
            <span class="custom-fs-16 custom-fw-600 custom-text-primary"> ${place.discount_percent}% off</span>
        </p>`;
                }

                // Check for hourly price and add if available
                if (place.hourlyprice) {
                    html += `<p class="my-0 py-0 line-height-1">
            <span>
                <span class="custom-fs-16 custom-fw-600">${place.hourlyprice} + <span class="custom-fs-12">GST / Per 3 Hours</span></span>
            </span>
        </p>`;
                }

                // Complete the HTML structure
                html += `</div>
    <div class="d-flex justify-md-content-between justify-content-around mt-3">
        <div>
            <button class="px-3 py-2 btn custom-border-radius-20 custom-bg-primary hover-on-white" type="submit"><a href="${place.route}" class="custom-fs-14 custom-text-white custom-fw-600">Book Now</a></button>
        </div>
        <div>
            <button class=" px-4 py-2 btn custom-border-radius-20 custom-text-white custom-bg-primary hover-on-white" id="assist" onclick="Assistance(${place.id})"><i class="custom-fs-20 fab fa-whatsapp" aria-hidden="true"></i></button>
            <div class="supportareapopup">
                <div id="myDIV" class="showAssistance${place.id} hideAssistance">
                    <h3 class="custom-text-white custom-fs-14">Call or Whatsapp for Immediate Assistance</h3>
                    <ul>
                        <li><a href="tel:(+91)9958277997">Call us</a></li>
                        <li><a href="https://wa.me/message/L5GH2A4JA3PLJ1" target="_blank">Chat on WhatsApp</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>`;

                // Return the generated HTML
                return html;
            }

        });
    </script>
@endpush
