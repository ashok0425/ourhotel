<?php

namespace App\Http\Controllers\API;


use App\Commons\Response;
use App\HotelReview;
use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\City;
use App\Models\city_location;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Location;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Property;
use App\Models\Review;
use App\Models\Room;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{


    public function placeBycity(Request $request,$cityid=null)
    {

    $type=$request->type;
    $id=$request->id;

    $places = Property::join('rooms', 'rooms.property_id', '=', 'properties.id')
    ->join('cities', 'properties.city_id', '=', 'cities.id')
    ->leftJoin(DB::raw('(SELECT property_id, AVG(rating) as rating FROM testimonials GROUP BY property_id) as testimonial_avg'),
        'testimonial_avg.property_id', '=', 'properties.id')
    ->select(
        'properties.id',
        'properties.amenities',
        'rooms.onepersonprice as price',
        'rooms.discount_percent',
        'properties.address',
        'cities.name as city_name',
        'properties.name as name',
        'properties.thumbnail as thumb',
        'properties.couple_friendly',
        'properties.pet_friendly',
        'properties.corporate',
        'testimonial_avg.rating'
    )
    ->where('rooms.onepersonprice', '!=', null)
    ->where('rooms.onepersonprice', '!=', 'null')
    ->where('rooms.onepersonprice', '!=', 0)
    ->when($cityid,function($query) use ($cityid){
        $query->where('properties.city_id', $cityid);
    })
    ->when($type!=null&&$type=='area',function($query) use ($id){

        $location = Location::find($id);
            if ($location) {
                $query->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$location->latitude, $location->longitude, $location->latitude])
                      ->having('distance', '<=', 2);
            }
    })
    ->when($type!=null&&$type=='city',function($query) use ($id){
        $query->where('properties.city_id', $id);
    })->when(isset($request->price_filter) && $request->price_filter != null,function($query) use ($request){
        $price=explode(',',$request->price_filter);
        $query->whereBetween('rooms.onepersonprice', [$price[0], $price[1]]);
    })->when(isset($request->star) && $request->star != null,function($query) use ($request){
        $star = $request->star;
        $query->whereIn('testimonial_avg.rating', [$star]);
    })->when(isset($request->city_id) && $request->city_id != null,function($query) use ($request) {
        $city_id = $request->city_id;
        $query->where('properties.city_id', $city_id);
    })->when(isset($request->property_type) && $request->property_type != null,function($query) use ($request) {
        $place_type = $request->property_type;
        $query->where('property_type_id',  $place_type);
    })->when(isset($request->amenities) && $request->amenities ==1,function($query) use ($request) {
        $query->where('couple_friendly', 1);
    })->when(isset($request->amenities) && $request->amenities ==2,function($query) use ($request) {
        $query->where('pet_friendly', 1);
    })->when(isset($request->amenities) && $request->amenities==3,function($query) use ($request){
        $query->where('corporate', 1);
    })
    ->orderBy('testimonial_avg.rating', 'DESC')
    ->orderBy('price', 'asc')
    ->get();

    $places->map(function ($place) {
        $amenityIds = $place->amenities;
        $place->list_amenities = Amenity::whereIn('id', $amenityIds??[])->select('id', 'thumbnail as icon')->get();
        return $place;
    });
        return $this->success_response('Data ', $places);
    }


    public function PlaceBytype($id, $is_toprated = null)
    {
        $places = Property::join('rooms', 'rooms.property_id', '=', 'properties.id')
        ->join('cities', 'properties.city_id', '=', 'cities.id')
        ->leftJoin(DB::raw('(SELECT property_id, AVG(rating) as rating FROM testimonials GROUP BY property_id) as testimonial_avg'),
            'testimonial_avg.property_id', '=', 'properties.id')
        ->select(
            'properties.id',
            'properties.amenities',
            'rooms.onepersonprice as price',
            'rooms.discount_percent',
            'properties.address',
            'cities.name as city_name',
            'properties.name as name',
            'properties.thumbnail as thumb',
            'properties.couple_friendly',
            'properties.pet_friendly',
            'properties.corporate',
            'testimonial_avg.rating'
        )
        ->where('rooms.onepersonprice', '!=', null)
        ->where('rooms.onepersonprice', '!=', 'null')
        ->where('rooms.onepersonprice', '!=', 0)
        ->where('testimonial_avg.rating', '>=', 3)
        ->orderBy('price', 'asc')
        ->limit(10);

        if (isset($is_toprated) && $is_toprated == 1) {
            $places = $places->where('top_rated', 1)->where('testimonial_avg.rating', '>=', 4);
        } else {
            $places = $places->where('property_type_id', $id);
        }
        $places = $places->limit(10)->get();

        $places->map(function ($place) {
            $amenityIds = $place->amenities;
            $place->list_amenities = Amenity::whereIn('id', $amenityIds)->select('id', 'thumbnail as icon')->get();
            return $place;
        });
        return $this->success_response('Data fetched', $places, 200);
    }

    public function detail($id)
    {
        $place = Property::find($id);
        if (!$place) abort(404);
        $rooms = Room::where('property_id', $id)->get();

        $amenities = Amenity::query()
            ->whereIn('id', $place->amenities ? $place->amenities : [])
            ->get(['id', 'name', 'thumbnail as icon']);

        $reviews = Testimonial::where('property_id', $id)->join('users', 'users.id', 'testimonials.user_id')->select('testimonials.*', 'users.name', 'users.profile_photo_path as avatar', 'users.id as uid')->orderBy('testimonials.id', 'desc')->get();
        $avg = Testimonial::where('property_id', $id)->avg('rating');
        $avg1 = Testimonial::where('property_id', $id)->where('rating',1)->avg('rating');
        $avg2 = Testimonial::where('property_id', $id)->where('rating',2)->avg('rating');
        $avg3 = Testimonial::where('property_id', $id)->where('rating',3)->avg('rating');
        $avg4 = Testimonial::where('property_id', $id)->where('rating',4)->avg('rating');
        $avg5 = Testimonial::where('property_id', $id)->where('rating',5)->avg('rating');
        if($place->full_booked_from&&$place->full_booked_to){
            $place['is_full_booked']=1;
        }else{
            $place['is_full_booked']=0;
        }
        $data= [
            'place' => $place,
            'rooms' => $rooms,
            'amenities' => $amenities,
            'reviews' => $reviews,
            'avg_rating' => $avg,
            'avg_rating1' => $avg1,
            'avg_rating2' => $avg2,
            'avg_rating3' => $avg3,
            'avg_rating4' => $avg4,
            'avg_rating5' => $avg5
        ];

        return $this->success_response('Data fetched', $data, 200);
    }


    public function locationSearch(Request $request) {
    $keyword =   $request->get('keyword');
    $cities= Property::searchSuggestion($keyword) ;
   return $this->success_response("feteched", $cities);
    }




    public function nearbyplace(Request $request, $radius = 8000)
    {
        $latitude = $request->lat;
        $longitude = $request->lng;
 $places = Property::join('rooms', 'rooms.property_id', '=', 'properties.id')
        ->join('cities', 'properties.city_id', '=', 'cities.id')
        ->leftJoin(DB::raw('(SELECT property_id, AVG(rating) as rating FROM testimonials GROUP BY property_id) as testimonial_avg'),
            'testimonial_avg.property_id', '=', 'properties.id')
        ->select(
            'properties.id',
            'properties.amenities',
            'rooms.onepersonprice as price',
            'rooms.discount_percent',
            'properties.address',
            'cities.name as city_name',
            'properties.name as name',
            'properties.thumbnail as thumb',
            'properties.couple_friendly',
            'properties.pet_friendly',
            'properties.corporate',
            'testimonial_avg.rating'
        )
        ->where('rooms.onepersonprice', '!=', null)
        ->where('rooms.onepersonprice', '!=', 'null')
        ->where('rooms.onepersonprice', '!=', 0)
        ->where('testimonial_avg.rating', '>=', 3)
        ->orderBy('price', 'asc')
        ->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
        ->having('distance', '<=', 20000000)
        ->limit(10)
        ->get();


        $places->map(function ($place) {
            $amenityIds = $place->amenities;
            $place->list_amenities = Amenity::whereIn('id', $amenityIds)->select('id', 'thumbnail as icon')->get();
            return $place;
        });

        return $this->success_response('NearBy hotel fetched', ['places' => $places]);
    }


}
