<div class="card shadow-sm mt-3 border-0 custom-border-radius-10">
    <div class="card-body">

        @if (count($areas) > 0)

            <div class="">
                <p class=" custom-fs-22 border-bottom custom-fw-800 py-2">Where in {{ Str::ucfirst($cityname) }}
                </p>
                <ul class="my-1 px-3 d-block list-style-disc">
                    @foreach ($areas as $item)
                        <li class="list-style-disc {{ $loop->index > 3 ? 'more_content d-none' : '' }}">
                            <a href="{{"/search-listing?location_search=$item->name&type=area&id=$item->id"}}" target="_blank" class="custom-text-gray-2 custom-fw-800">
                                {{ $item->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if (count($areas) > 4)
                    <div style="text-align: center;font-weight:700">
                        <a href="#" id="load_more" class="text-dark"><i class="fa fa-plus"></i> Load More</a>
                        <br>
                    </div>
                @endif
            </div>
        @endif

        <p class=" custom-fs-24 border-bottom custom-fw-800 py-2">Filters </p>

        {{-- filter by property type --}}
        <div class="type_filter border-bottom py-2">
            <p class=" custom-fs-18 custom-fw-800 mb-1">Property Type</p>
            <div class="filter_wrapper">
                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="49" class="place_type_filter">&nbsp; Hotel</label>

                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="42" class="place_type_filter">&nbsp; Banquet</label>

                </div>


                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="41" class="place_type_filter">&nbsp; Resort</label>

                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="43" class="place_type_filter">&nbsp; Homestay</label>

                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="40" class="place_type_filter">&nbsp; Lodge</label>

                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" value="35" class="place_type_filter">&nbsp; Luxury</label>

                </div>

            </div>
        </div>
        {{-- filter by property type End --}}





        {{-- filter by Price range type --}}
        <div class="type_filter border-bottom py-2">
            <p class=" custom-fs-18  custom-fw-800 mb-1">Price Range</p>
            <div class="filter_wrapper">
                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="radio" value="0,2000" name="price_filter" class="price_filter">&nbsp; upto &nbsp;
                        2000</label>

                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="radio" value="2001,5000" name="price_filter"  class="price_filter">&nbsp;&nbsp; 2001 -
                        &nbsp; 5000</label>

                </div>


                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="radio" value="5001,8000" name="price_filter"  class="price_filter">&nbsp;&nbsp; 5001 -
                        &nbsp; 8000</label>

                </div>


                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="radio" value="8001,12000" name="price_filter"  class="price_filter">&nbsp;&nbsp; 8001 -
                        &nbsp; 12000</label>
                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="radio" value="12000,50000" name="price_filter"  class="price_filter">&nbsp;&nbsp;
                        12000+</label>

                </div>
            </div>
        </div>
        {{-- filter by property Price range End --}}






        {{-- filter by Star rating type --}}
        <div class="type_filter border-bottom py-2">
            <p class=" custom-fs-18  custom-fw-800 mb-1">Star Rating</p>
            <div class="filter_wrapper">
                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" name="" value="5" class="star_rating">&nbsp;
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                    </label>
                </div>

                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" name="" value="4" class="star_rating">&nbsp;
                        @for ($i = 0; $i < 4; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                    </label>
                </div>


                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" name="" value="3" class="star_rating">&nbsp;
                        @for ($i = 0; $i < 3; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor
                    </label>
                </div>


                <div class="my-1">
                    <label class="text-uppercase custom-fs-14 custom-fw-800 d-flex align-items-center"><input
                            type="checkbox" name="" value="2" class="star_rating">&nbsp; Less then 3
                        Star
                    </label>
                </div>
            </div>
        </div>
        {{-- filter by star rating End --}}

    </div>
</div>
