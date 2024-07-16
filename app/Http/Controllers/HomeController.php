<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResourceCollection;
use App\Models\Category;
use App\Models\City;
use App\Models\Faq;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

// use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view("frontend.home.index");
    }

    // ajax search

    public function locationSearch(Request $request)
    {
        $keyword =   $request->get('keyword');
        return Property::searchSuggestion($keyword) ;
    }


    public function ajaxSearch(Request $request){
        $price=explode(',',$request->price_filter);
         $city_id=$request->city_id;
         $area_id=$request->area_id;
         $minprice=$price[0]??null;
         $maxprice=$price[1]??null;
         $place_type=$request->place_type;
         $star=$request->star;

        $filterData= Property::propertyFilter($city_id,$area_id,$minprice,$maxprice,$star,$place_type);

        return new PropertyResourceCollection($filterData);
    }



    public function pageSearchListing(Request $request,$city_name=null,$area_name=null)
    {
        $type=$request->type;
        $id=$request->id;
        $areas=[];
        $cityname='';
        $areaId=null;
        $cityId=null;

        if($id==null&&$city_name==null&&$area_name==null && $request->top_rated){
          return redirect()->route('home');
        }

        if ($type=='area') {
            $location=Location::findOrFail($id);
            $seo=[
                'title'=>$location->meta_title??$location->name,
                'description'=>$location->meta_description??$location->name,
                'keyword'=>$location->meta_keyword??$location->name,
            ];
            $cityname=$location->name;
            $cityid=$location->city_id;
            $areaId=$location->id;
        }elseif($type=='city'){
            $city=City::findOrFail($id);
            $seo=[
                'title'=>$city->meta_title??$city->name,
                'description'=>$city->meta_description??$city->name,
                'keyword'=>$city->meta_keyword??$city->name,
            ];
            $areas=Location::where('city_id',$id)->get();
            $cityname=$city->name;
            $cityid=$city->id;
            $cityId=$city->id;
        }elseif($city_name){
            $city=City::where('name',$city_name)->firstOrFail();
            $seo=[
                'title'=>$city->meta_title??$city->name,
                'description'=>$city->meta_description??$city->name,
                'keyword'=>$city->meta_keyword??$city->name,
            ];
            $areas=Location::where('city_id',$id)->get();
            $cityname=$city->name;
            $cityid=$city->id;
            $cityId=$city->id;
        }elseif($area_name){
            $location=Location::where('name',$area_name)->firstOrFail();
            $seo=[
                'title'=>$location->meta_title??$location->name,
                'description'=>$location->meta_description??$location->name,
                'keyword'=>$location->meta_keyword??$location->name,
            ];
            $cityname=$location->name;
            $cityid=$location->city_id;
            $areaId=$location->id;
        }

       if(!isset($cityid)){
        return redirect()->route('home');
       }
        $faq=Faq::where('city_id',$cityid)->get();
        $categories=Category::all();
        $place_types=PropertyType::all();

        return view("frontend.search.search_01", [
            'type' => $type,
            'id' => $id,
            'cityname' => $cityname,
            'categories' => $categories,
            'place_types' => $place_types,
            'faq' => $faq,
            'seo'=>$seo,
            'areas'=>$areas,
             'areaId'=>$areaId,
             'cityId'=>$cityId,
        ]);
    }


    public function subCity(Request $request)
    {
        $keyword = $request->search;

        $cities = Location::with('getCity')->where('city_id', $request->id);

        if (isset($keyword)) {
            $cities->where('name', 'LIKE', "%{$keyword}%");
        }

        $cities = $cities->get();
        $data = '';
        foreach ($cities as $key => $value) {
            $data .= '<a class="cla" href="' . route("location.search", ["city" => $value->getCity->name, "location" => str_replace(" ", "_", $value->name)]) . '">' . $value->name . '</a><br>';
        }
        return $data;
    }


    public function mobileLocation()
    {
        $cities = Cache::get('cities');
        return $cities;
    }

    public function toprated(Request $request){
        $places = Property::where('status', 1)
    ->with('ratings')
    ->select('properties.*')
    ->selectSub(function ($query) {
        $query->from('testimonials')
            ->selectRaw('AVG(rating)')
            ->whereColumn('properties.id', 'testimonials.property_id');
    }, 'avg_rating')
    ->selectSub(function($query) {
        $query->from('rooms')
            ->select('onepersonprice')
            ->whereColumn('properties.id', 'rooms.property_id')
            ->limit(1);
    }, 'onepersonprice')
    ->havingRaw('avg_rating IN (4, 5)')
    ->limit(25)
    ->where('properties.status',1)
    ->get();
    return view('frontend.top_rated',compact('places'));
    }


    public function nsnResort(Request $request){
        $places = Property::where('status', 1)
    ->with('ratings')
    ->select('properties.*')
    ->selectSub(function ($query) {
        $query->from('testimonials')
            ->selectRaw('AVG(rating)')
            ->whereColumn('properties.id', 'testimonials.property_id');
    }, 'avg_rating')
    ->selectSub(function($query) {
        $query->from('rooms')
            ->select('onepersonprice')
            ->whereColumn('properties.id', 'rooms.property_id')
            ->limit(1);
    }, 'onepersonprice')
    ->havingRaw('avg_rating IN (3,4, 5)')
    ->where('property_type_id',41)
    ->limit(25)
    ->where('properties.status',1)
    ->get();
    return view('frontend.top_rated',compact('places'));
    }

    function nearbyHotel(){
        $latitude = Cache::get('latlon')['latitude'];
        $longitude =  Cache::get('latlon')['longitude'];
        if (Cache::get('latlon')) {
     $places = Property::where('status', 1)
     ->with('ratings')
     ->select('properties.*')
     ->selectSub(function ($query) {
         $query->from('testimonials')
             ->selectRaw('AVG(rating)')
             ->whereColumn('properties.id', 'testimonials.property_id');
     }, 'avg_rating')
     ->selectSub(function($query) {
         $query->from('rooms')
             ->select('onepersonprice')
             ->whereColumn('properties.id', 'rooms.property_id')
             ->limit(1);
     }, 'onepersonprice')
     ->havingRaw('avg_rating IN (3,4, 5)')
     ->where('property_type_id',41)
        ->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
        ->having('distance', '<=', 2)
        ->orderBy('distance','asc')
        ->limit(20)
        ->where('properties.status',1)
        ->get();
    }else{
  $places=[];
    }
        return view('frontend.top_rated',compact('places'));

    }

    public function storeLocation(Request $request){
        $lat=$request->latitude;
        $lon=$request->longitude;
        $data=[
            'latitude'=>$lat,
            'longitude'=>$lon
        ];
        Cache::put('latlon', $data, 3600);
    }
}
