@if ($place->roomsData->first() != null)

    <div class="card custom-border-radius-0 hotel_card">
        <a class="card-body p-2" href="{{ route('place_detail', ['slug' => $place->slug]) }}">
            <div class="image_warpper">
                <img src="{{ getImageUrl($place->thumbnail) }}" class="img-fluid   border card_image_height custom-border-radius-10 w-100"
                    data-src="{{ getImageUrl($place->thumbnail) }}" alt="{{ $place->name }}"  loading='lazy'/>
            </div>

            <div class="text_wrapper mt-3">
                {{-- name and offer price row  --}}
                <div class="name_price d-flex">
                    <div class="w-75">
                        <p class="custom-fs-16 custom-fw-800 custom-text-dark mb-1 pb-0">
                            {{ Str::limit($place->name, 23, '...') }}</p>
                    </div>

                    <div class="w-25 text-right">

                        @php
                            $onepersonprice = $place->roomsData->first()->onepersonprice;
                        @endphp
                        @if ($place->roomsData->first()->discount_percent)
                            @php
                                $price = ($place->roomsData->first()->discount_percent * 100) / $onepersonprice;
                                $tprice = $price + $onepersonprice;
                            @endphp
                            <p class="custom-fs-16 custom-fw-600 custom-text-gray-2 mb-1 pb-0"><del>
                                    {{$place->roomsData->first()->before_discount_price}}
                                </del></p>
                        @endif
                    </div>
                </div>

                {{-- price and city row  --}}
                <div class="name_price d-flex mb-1 pb-0">

                    <div class="w-50">
                        <p class="mt-0 pt-0 custom-fs-14 custom-fw-600 custom-text-dark pt-0 mt-0 mb-0 pt-0">
                            {{ !empty($place->city) ? $place->city->name : '' }}</p>
                    </div>
                    <div class="w-50 text-right">

                        <p class="custom-fs-20 custom-text-dark custom-fw-600 pt-0 mt-0 mb-0 pt-0">
                            {{$onepersonprice}}
                            <small class="text-success custom-fs-14">{{ $place->roomsData->first()->discount_percent }}%
                                off</small>
                        </p>


                    </div>
                </div>

                {{-- rating  --}}
                <div class="rating_wrapper d-flex mt-0 pt-0">
                    <div class="w-50">
                        <div class="mt-0 pt-0 custom-fs-14 custom-fw-600 custom-text-dark">
                            <span
                                class="rating_inner custom-text-white bg-success p-1 custom-border-radius-1  custom-fs-12 custom-fw-600 text-center">
                                {{ number_format($place->rating, 1) }}/5

                            </span>
                            <span class="custom-text-gray-2 custom-fs-12 custom-fw-600 ml-1">
                                {{ number_format($place->rating, 1) }} Rating
                            </span>
                        </div>
                    </div>
                    <div class="w-50 text-right">
                        <small class="custom-text-12 custom-text-gray-2 custom-fw-600 mt-0 pt-0">1 room per
                            night</small>
                    </div>
                </div>

            </div>
        </a>
    </div>

@endif
