@extends('frontend.layouts.master')
@push('style')
<style>
    .google_form{
        animation: animate 1s ease infinite;
    }
    .custom-bg-primary-400{
        background: rgb(187, 243, 255);
    }
    @media  (min-width:760px){

    /* .text_wrapper_right{
        transform: translateX(-120px);

    }
    .text_wrapper_left{
        transform: translateX(120px)
    } */
    .banqute_row{
        width: 75%;
        margin: auto!important;
        margin-bottom: 2rem!important;
    }

}

    .banquet_contact input,.banquet_contact select,.banquet_contact textarea{
        border-radius: 0px;
        outline: none;
        box-shadow: none;
        /* background: rgb(12, 32, 66); */
        border: 0px;
        text-transform: uppercase;
        /* color: rgb(192, 186, 186)!important; */

    }

    .banquet_contact input::placeholder,.banquet_contact select::placeholder,.banquet_contact textarea::placeholder{
       /* color: rgb(192, 186, 186)!important; */
    }
    .banquet_contact input:focus,.banquet_contact    textarea:focus{
        /* background: rgb(12, 32, 66); */
        outline: none;
        box-shadow: none;
        border: 0px;
    }

    @keyframes animate{
        0%   {color:white; }

  100% {color:var(--color-primary); }
    }
</style>

@endpush
@section('main')

@php
use App\Models\Place;
$offer_image1 = DB::table('settings')->where('name', 'banquet_image')->first();
$banquet_places =Place::with(['categories', 'city','place_types', 'avgReview'])
->withCount(['reviews', 'wishList'])
->where('status', 1)
->where('place_type',json_encode(['42']))
->orderBy('id', 'desc')
->groupBy('places.id')
->paginate(8);
@endphp

<div class="banquote-banners">
<div class="banquote_image_wrapper">
    <img src="{{getImageUrl($offer_image1->val)}}" alt="" class="w-100 img-fluid" style="height: 94vh">
</div>

</div>


<div class="banquots_section my-4">
    <div class="container">
        <div class="row my-3">
           <p class="custom-fs-28 custom-text-primary custom-fw-600 text-center">
            A wedding with us has meant something special for generations. Elevate your big day into a memorable and momentous celebration with our iconic repertoire of grand palaces, world class resorts and iconic properties. Make your dreams come true with timeless weddings
           </p>
            <div class="col-md-4 offset-md-4 mt-5">
                <h1 class="d-flex justify-content-center custom-text-primary custom-fs-30 custom-fw-800 text-uppercase letter-spacing-1">Our banquets </h1>
                <div class="row mt-2">
                    <div class="col-md-3 offset-md-2 text-center px-0">
                        <p class="custom-border-bottom-primary-3px pt-3 pl-3 "></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-star custom-text-primary"></i>
                        <i class="fas fa-star custom-text-primary"></i>
                        <i class="fas fa-star custom-text-primary"></i>

                    </div>
                    <div class="col-md-3 px-0">
  <p class="custom-border-bottom-primary-3px pt-3 "></p>

                    </div>

                </div>
            </div>
        </div>


        <div class="gallery_section">
            @foreach ($banquet_places as $place)

            <div class="row   mb-3 m-md-5">

                <div class="col-md-4 @if ($loop->index%2==0)
                    order-md-1
                    @else
                    order-md-2
                @endif">
        <img src="" class="img-fluid lazy shadow-sm border  custom-border-radius-10"
            data-src="{{ getImageUrl($place->thumb) }}" alt="{{ $place->PlaceTrans->name }}" class="" />
            </div>

                <div class="col-md-8  @if ($loop->index%2==0)
                    text_wrapper_right
                    order-md-2
                    @else
                    text_wrapper_left
                    order-md-1
                @endif">

                    <div class=" shadow-sm bg-white p-md-2  custom-border-radius-5">
                        <div class="p-3">
                        {{-- name and offer price row  --}}
                        <div class="name_price">
                            <div class="w-75">
                                <p class="custom-fs-16 custom-fw-800 custom-text-dark mb-1 pb-0">
                                    {{ $place->PlaceTrans->name}}</p>
                            </div>

                            <p class="custom-bg-primary-400 p-2 custom-border-radius-5">
                                {{Str::limit(strip_tags($place->description),450)}}
                            </p>
                        </div>

            {{-- rating  --}}
                        <div class="rating_wrapper d-flex mt-2">
                            <div class="w-50">
                                <div class="mt-0 pt-0 custom-fs-14 custom-fw-600 custom-text-dark">
                                        <span class="rating_inner custom-text-white bg-success p-1 custom-border-radius-1  custom-fs-12 custom-fw-600 text-center">
                                            {{number_format($place->avgReview,1)}}/5

                                        </span>
                                        <span class="custom-text-gray-2 custom-fs-12 custom-fw-600 ml-1">
                                            {{number_format($place->avgReview,1)}} Rating
                                        </span>
                                </div>
                            </div>
                            <div class="w-50 text-right">
<div class="request-quote">
    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfP_liNAXZJvBORmsyL6wrDTZ7r-LiJwbfywt9qkprfx-WqEw/viewform" class="custom-bg-primary custom-border-radius-20 text-white p-2 px-3 custom-fw-600" target="_blank">Request Quote</a>
</div>
                            </div>

                        </div>

                    </div>
                </div>

                </div>
            </div>
        @endforeach

        {{$banquet_places->render('frontend.common.pagination')}}

    </div>


{{-- contact section  --}}

<br>
<div class="row mt-5">
    <div class="col-md-4 offset-md-4 ">
        <h1 class="d-flex justify-content-center custom-text-primary custom-fs-30 custom-fw-800 text-uppercase letter-spacing-1">Contact Us </h1>
        <div class="row mt-2">
            <div class="col-md-3 offset-md-2 text-center px-0">
                <p class="custom-border-bottom-primary-3px pt-3 pl-3 "></p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-star custom-text-primary"></i>
                <i class="fas fa-star custom-text-primary"></i>
                <i class="fas fa-star custom-text-primary"></i>

            </div>
            <div class="col-md-3 px-0">
<p class="custom-border-bottom-primary-3px pt-3 "></p>

            </div>

        </div>
    </div>
</div>


<div class="banquet_contact mb-5 pt-3">
    <div class="custom-bg-primary-400 pt-5 px-3 pb-3">
<form action="{{route('subscribe')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="name" required id="" class="form-control" placeholder="Your Name">
            </div>
        </div>

        <input type="hidden" name="type" value="3">

        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="phone" required id="" class="form-control" placeholder="Your Phone number">
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                @php
                    $arr=[
                        "Ring Ceremony",
"Marriage Ceremony",
"Corporate Events",
"Birthday Party",
"Marriage anniversary",
"Corporate Meetings",
"Farm House Party",
"Club Party",
"Destination Wedding",
"Destination Event",
"Group Party"
                    ]
                @endphp
                <select name="event" required id=""class="form-control" aria-placeholder="--Select Banquet--">
                    <option value="">--Select Event--</option>
                  @foreach ($arr as $item)
                    <option value="{{$item}}">{{$item}}</option>

                  @endforeach

                </select>
            </div>
            <p>Our team will connect you</p>
        </div>


        <div class="col-12">
<button class="custom-bg-secondary mt-4 py-2 border-none boder-o outline-none  custom-text-white d-block w-100 text-center custom-fw-700">Submit</button>

<div class="text-center ">
    <h2 class="text-white custom-fs-22 custom-fw-700 text-center my-2">OR</h2>
</div>

<a href="https://docs.google.com/forms/d/e/1FAIpQLSfP_liNAXZJvBORmsyL6wrDTZ7r-LiJwbfywt9qkprfx-WqEw/viewform" class="custom-bg-secondary google_form  py-2 border-none boder-o outline-none   d-block w-100 text-center custom-fw-700" target="_blank">Fill the form and submit your query</a>

        </div>
    </div>
</form>
    </div>
</div>



</div>




<div class="container mb-3 ">
    <div class="card border-0 shadow-none custom-border-radius-0">
        <div class="card-body px-md-5 px-2 accordion-title">
          <div>
            <a href="">Plan your wedding with Us</a>
            <p>
             NSN Hotels and Banquets is an Indian Wedding Planning Website  where you can find the best wedding vendors, with prices and reviews at the click of a button. Whether you are looking to hire wedding planners in India, or just some ideas and inspiration for your wedding. Wed can help you solve your wedding planning woes through its unique features.  you won't need to spend hours planning a wedding anymore.
            </p>
          </div>
          <div>
            <a href="">Planning an event - Event Management Company</a>
            <p>
                Dreamy destination wedding, flawless events in India NSN HOTELS and Banquets  by our experts. Wedding Experts - Venue Booking, Decoration, Entertainment, Events, Hospitality & Planning. Call Now for The quote.-9958277997
            </p>
          </div>

          <div>
            <a href="">
                How we plan
            </a>
            <p>
                We look forward to discussing your vision, matching it with our offerings, and making your event memorable. Known in the event management sector as one of the best event management companies in Delhi and NCR. We are able to plan your events because of our systematic strategy for event management. We design our services to provide you the flexibility to decide how we can best support the staging of your event, from planning to execution.
            </p>
          </div>
          <div>
            <a href="">How is our Quality</a>
            <p>
                We offer services of unimaginable quality, thus demonstrating our position as one of the best event . A Launch dome event is made by fusing original settings, artisanal vendors, and personalized décor accents with creative concepts. We offer an unparalleled level of service throughout the whole event process thanks to our attention to detail and understanding of our client’s demands.
            </p>
          </div>
        </div>
    </div>
</div>

@endsection
