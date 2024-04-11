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
.list-style-disc{
    list-style: disc!important;
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
            background-color: #fff!important;
            background: linear-gradient(to right, #eeeeee 8%, #e4e4e4 18%, #ebebeb 33%);
            background-size: 800px 104px;
            height: 200px;
            position: relative;
        }
    </style>
@endpush
@section('main')
    @php
        if (session()->has('area_url')) {
            session()->forget('area_url');
        }
    @endphp

    {{-- upper search start --}}
    <div class="custom-bg-primary py-3" id="nsnhotelssearchdata">
        <div class="container header-search mt-5 mt-md-0 ">

            @include('frontend.partials.search_top_form')
        </div>
    </div>
    {{-- upper search End --}}
    @php
        $city = null;
        if (isset($_GET['city']) && ($_GET['city'] != null) & ($_GET['city'] != '')) {
            $city = $_GET['city'];
        }
        if (request()->segment(1) == 'city') {
            $city = DB::table('cities')
                ->where('slug', request()->segment(2))
                ->value('id');
        }
    @endphp
    <input type="hidden" value="{{ $city }}" id="city_ids">
    <div class="nsnsearchmidcontent">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3">
                    {{-- sidebar Filter  --}}
                    <div class="sticky-top d-none d-md-block">
                        @include('frontend.partials.search_filter')
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
        // whatsapp hide


        $(document).ready(function() {
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

            let isajax_applied = false;
            let place_type = $('.place_type_filter:checked').val();
            let star = $('.star_filter:checked').val();
            let price_filter = $('.price_filter:checked').val();
            let city = $('#city_ids').val()

            ajaxSeacrh();

            // place filter
            $('.place_type_filter').click(function() {
                place_type = $(this).val();
                ajaxSeacrh();

            })
            $('.price_filter').click(function() {
                price_filter = $(this).val();
                ajaxSeacrh();

            })
            $('.star_rating').click(function() {
                star_rating = $(this).val()
                star = star_rating;
                ajaxSeacrh();
            })


            function ajaxSeacrh() {
                isajax_applied = true;
                $.ajax({
                    url: '{{ url('ajax-search') }}',
                    dataType: "html",
                    data: {
                        star: star,
                        place_type: place_type,
                        price_filter: price_filter,
                        city_id: city
                    },
                    success: function(res) {
                        res = JSON.parse(res)
                        $('.total_places').html(res.count)
                        $('.nsnhotelssearchdata').html(res.view)
                        $(".hideAssistance").hide();

                    }
                })
            }

            let count = 0;
            let offset = 0;
            let limit = 2;

            loadData()


            function loadData() {
                limit = 5
                if (isajax_applied) {
                    return false;
                }
                if (offset > count) {
                    return false;
                }
                let route = $('#get_url').val();
                if (route.includes('?')) {
                    route = route + `&limit=${limit}&offset=${offset}`
                } else {
                    route = route + `?limit=${limit}&offset=${offset}`

                }
                $.ajax({
                    url: route,
                    success: function(res) {
                        $('.spinner').addClass('d-none')
                        limit = limit
                        offset = offset + 8
                        count = res.count
                        $('.total_places').html(res.count)
                        $('.nsnhotelssearchdata').append(res.view)
                        $(".hideAssistance").hide();
                         setTimeout(() => {
                    loadData()
                    }, 10)


                    }
                })

            }




        });
    </script>
@endpush
