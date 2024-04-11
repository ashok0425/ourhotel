@foreach ($places as $place)

@if($place->roomsData->first()!=null)
<div class="row custom-border-radius-20 m-0 shadow-sm p-3 mb-3 bg-white ">
    <div class="col-12 col-sm-9 col-md-9">
        <div class="row">
            <div class="col-12 col-sm-5 col-md-5 nsnhotelsphoto pr-0">
                <div id=""
                    class="@if($place->couple_friendly===1) display_after @endif">
                    @if (isset($place->thumbnail))
                            <div class="nsnhotelsimagesliderbox ">
                                <img src="{{ getImageUrl($place->thumbnail) }}" alt="{{ $place->name }}" class="img-responsive"
                                    style="border-radius:5px"height="189" width="269" />
                            </div>
                    @else
                        <div class="nsnhotelsimagesliderbox">
                            <img src="https://via.placeholder.com/1920x1200?text=NSN" alt="{{ $place->PlaceTrans->name }}"
                                class="img-responsive" height="189" width="269" />
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-sm-7 col-md-7 ">
                <div class="nsnhotelsname"><a href="{{ route('place_detail', $place->slug) }}"
                        class="custom-fs-20 custom-fw-800 custom-text-primary">{{ $place->name }}</a>

                </div>
                <h6 class="custom-fs-12 custom-fw-600 py-1 custom-text-secondary">{{ $place->address }}</h6>
                <div class="d-flex justify-content-between">

        <div class="my-2 mb-3">
            @if ($place->couple_friendly===1)
            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Couple Friendly</div>
            @endif


            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Local ID Accepted</div>


            <div class="text-success custom-fw-600 custom-fs-16"><i class="fas fa-check-circle fs-2z"></i><span></span> Pay At Hotel</div>
        </div>

                    &nbsp;
                    &nbsp;

                    <div class="nsnhotelsreviews text-right d-md-none d-inline">
                        <div class="product__rating ">


                            <div class="top">
                                <small>
                                        {{ number_format($place->ratings()->avg('rating'), 0) }}/5
                                </small>

                                <br>
                                <svg viewBox="0 0 9 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.25 9.5a.238.238 0 01-.12-.032L4.5 7.948l-2.63 1.52a.238.238 0 01-.265-.017.271.271 0 01-.102-.26l.48-3.042-1.91-2.021a.276.276 0 01-.061-.268.255.255 0 01.197-.18l2.874-.508L4.276.646A.25.25 0 014.5.5c.094 0 .181.057.223.146l1.194 2.526 2.874.508a.255.255 0 01.197.18.275.275 0 01-.061.268l-1.91 2.021.48 3.042c.015.1-.024.201-.102.26a.242.242 0 01-.145.049z">
                                    </path>
                                </svg>
                            </div>
                            <div class="bot">
                                {{ count($place->ratings) }} Ratings
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <ul class="">
                            @foreach (\App\Models\Amenity::whereIn('id',$place->amenities)->limit(20)->get() as $key => $item)
                                <li class="border float-left custom-border-radius-5 bg_animities mb-1 mx-1 p-1"><img
                                        src="{{ getImageUrl($item->thumbnail) }}" alt="{{ $item->name }}" width="26"
                                        height="26" /></li>
                            @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-sm-3 col-md-3 nsnhotelssearchdatarightarea">
        <div class="nsnhotelsreviews text-right">
            <div class="product__rating d-none d-md-block">


                <div class="top">
                    <small>
                            {{ number_format($place->ratings()->avg('rating'), 0) }}/5
                    </small>

                    <br>
                    <svg viewBox="0 0 9 10" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.25 9.5a.238.238 0 01-.12-.032L4.5 7.948l-2.63 1.52a.238.238 0 01-.265-.017.271.271 0 01-.102-.26l.48-3.042-1.91-2.021a.276.276 0 01-.061-.268.255.255 0 01.197-.18l2.874-.508L4.276.646A.25.25 0 014.5.5c.094 0 .181.057.223.146l1.194 2.526 2.874.508a.255.255 0 01.197.18.275.275 0 01-.061.268l-1.91 2.021.48 3.042c.015.1-.024.201-.102.26a.242.242 0 01-.145.049z">
                        </path>
                    </svg>
                </div>
                <div class="bot">

                    {{ count($place->ratings) }} Ratings
                </div>
            </div>
        </div>
        <!--<div class="nsnhotelspernightprice">Price per night as low as</div>-->
        <div class="nsnhotelspernightpricevalue">
            <p
                class="custom-text-primary custom-fs-18 custom-fw-600 mb-0 pb-0 line-height-1 mb-2">
            {{    $place->roomsData->first()->onepersonprice}}
                <span class="custom-fs-12"> + GST / Per Night</span></p>

@php
    $discount_amount=($place->roomsData->first()->discount_percent/100)*$place->roomsData->first()->onepersonprice;
    $before_price=$place->roomsData->first()->onepersonprice+$discount_amount;
@endphp
                @if (isset($place->roomsData->first()->discount_percent))
                    <p class="my-0 py-0 line-height-1 mb-2">
                        <s class="custom-fs-14 custom-fw-600 text-danger">
                            {{$place->roomsData->first()->before_discount_price }}  </s>
                        <span class="custom-fs-16 custom-fw-600 custom-text-primary"> {{ $place->roomsData->first()->discount_percent }}% off</span>
                    </p>
                @endif

                    @if (isset($place->roomsData->first()->hourlyprice))
                    <p class="my-0 py-0 line-height-1 ">
                        <span class=" ">
                            <span class="custom-fs-16 custom-fw-600">{{$place->roomsData->first()->hourlyprice}} + <span class="custom-fs-12">GST / Per 3
                                Hours</span></span>
                        </span><span>
                        </p>
                    @endif
        </div>

 <div class="d-flex justify-md-content-between justify-content-around mt-3">
    <div class="">
        <button class="px-3 py-2 btn custom-border-radius-20 custom-bg-primary hover-on-white" type="submit"><a href="{{ route('place_detail', $place->slug) }}" class="custom-fs-14 custom-text-white custom-fw-600">Book
                Now</a></button>
    </div>
    <div class="">
        <button class=" px-4 py-2 btn custom-border-radius-20 custom-text-white custom-bg-primary hover-on-white" id="assist" onclick="Assistance({{ $place->id }})"><i class="custom-fs-20 fab fa-whatsapp"
                aria-hidden="true"></i></button>
        <div class="supportareapopup">
            <div id="myDIV" class="showAssistance{{ $place->id }} hideAssistance">
                <h3 class=" custom-text-white custom-fs-14 ">Call or Whatsapp for Immediate Assistance</h3>
                <ul>
                    <li><a href="tel:(+91)9958277997">Call us</a></li>
                    <li><a href="https://wa.me/message/L5GH2A4JA3PLJ1" target="_blank">Chat on WhatsApp</a></li>
                </ul>
            </div>
        </div>
    </div>
 </div>

    </div>
</div>
@endif
@endforeach
