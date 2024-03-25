@php
use App\Models\City;
    $city1=City::where('popular',1)->orderBy('id','desc')->where('status',1)->first();
    $city2=City::where('popular',1)->orderBy('id','desc')->skip(1)->take(1)->where('status',1)->first();
    $city3=City::where('popular',1)->orderBy('id','desc')->skip(2)->take(1)->where('status',1)->first();
    $city4=City::where('popular',1)->orderBy('id','desc')->skip(3)->take(1)->where('status',1)->first();
    $city5=City::where('popular',1)->orderBy('id','desc')->skip(4)->take(1)->where('status',1)->first();
    $city6=City::where('popular',1)->orderBy('id','desc')->skip(5)->take(1)->where('status',1)->first();
    $city7=City::where('popular',1)->orderBy('id','desc')->skip(6)->take(1)->where('status',1)->first();
    $city8=City::where('popular',1)->orderBy('id','desc')->skip(7)->take(1)->where('status',1)->first();
    $city9=City::where('popular',1)->orderBy('id','desc')->skip(8)->take(1)->where('status',1)->first();
    $city10=City::where('popular',1)->orderBy('id','desc')->skip(9)->take(1)->where('status',1)->first();
    $city11=City::where('popular',1)->orderBy('id','desc')->skip(10)->take(1)->where('status',1)->first();

@endphp

<style>  

    .popular_location{
 gap: 10px;
 display: grid;
 grid-template-columns: 1fr 1fr 1fr 1fr;
 grid-template-rows: 1fr 1fr 1fr 1fr;
 width: 100%;
 height: 100%;
}
.popular_location a{
 background-size: cover;
 background-position: center;
 border-radius: 15px;
 background-color: rgba(55, 55, 56,.3);
 transition: 0.4s;
 box-shadow: 0 0 0px rgba(0,0,0,1);
 position: relative;
 background-blend-mode: multiply;
 height: 150px;
}
.popular_location  a p{
    position: absolute;
    top: 73%;
    left: 5%;
}
.one{
 background-image: url({{getImageUrl($city1->thumb)}});
 grid-area: 1 / 1 / span 2 / span 1;
}
.two{
 background-image:url({{getImageUrl($city2->thumb)}});
 grid-area: 3 / 1 / span 1 / span 1;
}
.three{
 background-image:url({{getImageUrl($city3->thumb)}});
 grid-area: 4 / 1 / span 1 / span 2;
}
.four{
 background-image: url({{getImageUrl($city4->thumb)}});
 grid-area: 3 / 2 / span 2 / span 2;
}
.five{
 background-image:url({{getImageUrl($city5->thumb)}});
 grid-area: 1 / 3 / span 1 / span 2;
}
.six{
 background-image:url({{getImageUrl($city6->thumb)}});
 grid-area: 2 / 3 / span 2 / span 1;
}
.seven{
 background-image: url({{getImageUrl($city7->thumb)}});
 grid-area: 2 / 1 / span 2 / span 2;

}
.eight{
 background-image: url({{getImageUrl($city8->thumb)}});
}
.nine{
 background-image:url({{getImageUrl($city9->thumb)}});
 grid-area: 4 / 3 / span 1 / span 2;
}
.ten{
 background-image: url({{getImageUrl($city10->thumb)}});
}
.eleven{
 background-image:url({{getImageUrl($city11->thumb)}});
}
</style>

<div class="container mt-5">
    <h2 class=" pl-0 pl-md-3 font-weight-bold text-dark custom-fs-20 custom-fw-600 mb-3">
        Popular Locations
    </h2>
<p class="pl-0 pl-md-3">
    We have selected some best locations around the world for you.
</p>
    <br>
    <br>
    <div class="d-none d-md-block">
<div class="popular_location">
        <a class="one" href="{{route('city-search',strtolower($city1->name))}}">
            <p href="" class="font-weight-bold custom-fs-18 text-white">{{$city1->name}}</p>
        </a>

        <a class="two"  href="{{route('city-search',strtolower($city2->name))}}" >
            <p class="font-weight-bold custom-fs-18 text-white">{{$city2->name}}</p>
        </a>
        <a class="three" href="{{route('city-search',strtolower($city3->name))}}" >
            <p class="font-weight-bold custom-fs-18 text-white">{{$city3->name}}</p>
        </a>
        <a class="four" href="{{route('city-search',strtolower($city4->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city4->name}}</p>
        </a>
        <a class="five" href="{{route('city-search',strtolower($city5->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city5->name}}</p>
        </a>
        <a class="six" href="{{route('city-search',strtolower($city6->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city6->name}}</p>
        </a>
        <a class="seven" href="{{route('city-search',strtolower($city7->name))}}" >
            <p class="font-weight-bold custom-fs-18 text-white">{{$city7->name}}</p>
        </a>
        <a class="eight" href="{{route('city-search',strtolower($city8->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city8->name}}</p>
        </a>
        <a class="nine" href="{{route('city-search',strtolower($city9->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city9->name}}</p>
        </a>
        <a class="ten" href="{{route('city-search',strtolower($city10->name))}}">
            <p  class="font-weight-bold custom-fs-18 text-white">{{$city10->name}}</p>
        </a>
        <a class="eleven" href="{{route('city-search',strtolower($city11->name))}}" >
            <p class="font-weight-bold custom-fs-18 text-white">{{$city11->name}}</p>
        </a>
</div>

    </div>
