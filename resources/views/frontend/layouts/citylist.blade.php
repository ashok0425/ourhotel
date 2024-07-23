<!--Special drop down menu start-->
<div class="dropdownspmenu">
    <div class="row mx-0 px-5" style="background: rgba(104,56, 175,.7)">
        @foreach (popular_cities()->take(8) as $city)
            <div class="dropdown col">
                <button class="dropbtn">{{ $city->name }}
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    @foreach ($city->locations()->limit(7)->select('slug','name')->get() as $location)
                        <a
                            href="{{ route('location.search', ['city_name' => $city->name, 'location' => $location['slug']]) }}">{{ $location['name'] }}</a>
                    @endforeach
                    <a href="{{ route('city-search', strtolower($city->name)) }}" class="color_primary"> All Of
                        {{ $city->name }}</a>
                </div>
            </div>
        @endforeach
        <!--<a href="#">All cities</a>-->
    </div>
</div>
<!--Special drop down menu end-->
