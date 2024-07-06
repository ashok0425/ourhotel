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
    })
    ->orderBy('testimonial_avg.rating', 'DESC')
    ->orderBy('price', 'asc')
    ->limit(65)
    ->get();

    $places->map(function ($place) {
        $amenityIds = $place->amenities;
        $place->list_amenities = Amenity::whereIn('id', $amenityIds)->select('id', 'thumbnail as icon')->get();
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

    public function search(Request $request)
    {
        $cityname = "";
        $keyword = $request->keyword;
        $filter_category = $request->category;
        $filter_amenities = $request->amenities;
        $filter_place_type = $request->place_type;
        $filter_city = $request->city;

        // $cityname = $filter_city;

        $filter_search = $request->search;
        if ($request->get('hotel')) {
            $filter_hotel = $request->get('hotel');
        }
        $categories = Category::where('type', Category::TYPE_PLACE)->get();

        $place_types = PlaceType::query()
            ->get();

        $amenities = Amenities::query()
            ->get();

        $cities = City::query()
            ->get();

        $places = Place::select('properties.*', 'properties.id as place_id')->where('properties.status', 1)->where('rooms.onepersonprice', '>', 0)->join('cities', 'properties.city_id', 'cities.id')
            ->select("properties.*", "rooms.onepersonprice as price")->leftjoin('rooms', 'rooms.property_id', 'properties.id');
        if (isset($keyword)) {
            $places = $places->where('properties.name', 'LIKE', "%{$keyword}%")->orwhere('properties.slug', 'LIKE', "%{$keyword}%")->orwhere('cities.slug', 'LIKE', "%{$keyword}%");
        }
        if (isset($request->lat) && isset($request->lng)) {
            $latitude =   $request->lat;
            $longitude =   $request->lng;

            $placess = Place::selectRaw("properties.* , rooms.onepersonprice as price , properties.slug, properties.city_id,properties.address, '2hotel' as type,( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$latitude, $longitude, $latitude])->leftJoin('rooms', 'rooms.property_id', 'properties.id')
                ->having("distance", "<", '2')
                ->orderBy("distance", 'asc')->get();
            $data = [
                'cityname' => $cityname,
                'keyword' => $keyword,
                'places' => $placess,
                'categories' => $categories,
                'place_types' => $place_types,
                'amenities' => $amenities,
                'cities' => $cities,
                'filter_category' => $filter_category,
                'filter_amenities' => $filter_amenities,
                'filter_place_type' => $filter_place_type,
                'filter_city' => $request->city,
            ];

            return $this->success_response('Fetched Data', $data);
        }
        $places = $places->get();
        $data = [
            'cityname' => $cityname,
            'keyword' => $keyword,
            'places' => $places,
            'categories' => $categories,
            'place_types' => $place_types,
            'amenities' => $amenities,
            'cities' => $cities,
            'filter_category' => $filter_category,
            'filter_amenities' => $filter_amenities,
            'filter_place_type' => $filter_place_type,
            'filter_city' => $request->city,
        ];

        return $this->success_response('Fetched Data', $data);
    }



    public function locationSearch(Request $request) {
    $keyword =   $request->get('keyword');
    $cities= Property::searchSuggestion($keyword) ;
   return $this->success_response("feteched", $cities);
    }




    // public function nearbyplace(Request $request, $radius = 8000)
    // {
    //     $latitude = $request->lat;
    //     $longitude = $request->lng;

    //     $places = Place::query()
    //         ->selectRaw("properties.id,place_id,properties.user_id,city_translations.name as cityname,place_translations.name,properties.slug,address,properties.lat,properties.lng,properties.status,properties.city_id,properties.country_id,place_translations.description,properties.thumb,amenities,( 6371000 * acos( cos( radians(?) ) * cos( radians( properties.lat ) ) * cos( radians( properties.lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( properties.lat ) ) )) AS distances", [$latitude, $longitude, $latitude])
    //         ->select("properties.*", "city_translations.name as city_name", "hotel_reviews.avg_rating", "hotel_reviews.rating_count", "rooms.onepersonprice as price", "rooms.discount_percent")
    //         ->leftjoin(DB::raw("(SELECT avg(rating) as avg_rating,hotel_reviews.product_id,count(*) as rating_count FROM hotel_reviews ) as hotel_reviews"), function ($join) {
    //             $join->on("hotel_reviews.product_id", "=", "properties.id");
    //         })->join('cities', 'properties.city_id', 'cities.id')->join('city_translations', 'city_translations.city_id', 'cities.id')
    //         ->join('rooms', 'rooms.property_id', 'properties.id')
    //         ->limit(8)
    //         ->get();

    //     $data = [
    //         'places' => $places
    //     ];

    //     return $this->success_response('NearBy hotel fetched', $data);
    // }


    public function filter(Request $request)
    {
        $price = explode(',', $request->price_filter);

        $places = Place::with([
            'list_amenities' => function ($query) {
                $query->select('id', 'icon');
            }
        ])->join('place_translations', 'place_translations.place_id', 'properties.id')
            ->join('rooms', 'rooms.property_id', 'properties.id')->select('properties.id', 'properties.amenities', 'rooms.onepersonprice as price', 'rooms.discount_percent', 'city_translations.name as city_name',
             'properties.address','properties.rating', 'place_translations.name as name', 'properties.thumb','properties.couple_friendly','properties.pet_friendly','properties.corporate')->where('rooms.onepersonprice', '!=', null)->join('cities', 'properties.city_id', 'cities.id')->join('city_translations', 'city_translations.city_id', 'cities.id');


        if (isset($request->price_filter) && $request->price_filter != null) {
            $places = $places->whereBetween('rooms.onepersonprice', [$price[0], $price[1]]);
        }

        if (isset($request->star) && $request->star != null) {
            $star = $request->star;
            $places = $places->whereIn('properties.rating', [$star]);
        }
        if (isset($request->city_id) && $request->city_id != null) {
            $city_id = $request->city_id;
            $places = $places->where('properties.city_id', $city_id);
        }

        if (isset($request->place_type) && $request->place_type != null) {
            $place_type = $request->place_type;
            $places = $places->where('place_type', 'LIKE',  "%$place_type%");
        }

          if (isset($request->couple_friendly) && $request->couple_friendly != null) {
            $places = $places->where('couple_friendly', 1);
        }


   if (isset($request->pet_friendly) && $request->pet_friendly != null) {
            $places = $places->where('pet_friendly', 1);
        }

           if (isset($request->corporate) && $request->corporate != null) {
            $places = $places->where('corporate', 1);
        }


        $places = $places->limit(60);
        $places = $places->get();


 return $this->success_response('Filter data', $places);
    }
}
