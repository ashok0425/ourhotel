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
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Property;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{


    public function placeBycity($id)
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
    ->where('properties.city_id', $id)
    ->where('testimonial_avg.rating', '>=', 3)
    ->orderBy('price', 'asc')
    ->limit(10)
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
        $place = Place::with(['list_amenities' => function ($query) {
            $query->select('id', 'icon');
        }])->join('place_translations', 'place_translations.place_id', 'properties.id')->select('properties.*', 'place_translations.name as name', 'place_translations.description as description')->find($id);
        if (!$place) abort(404);
        $rooms = Room::where('property_id', $id)->get();

        $amenities = Amenities::query()
            ->whereIn('id', $place->amenities ? $place->amenities : [])
            ->get(['id', 'name', 'icon']);

        $reviews = DB::table('hotel_reviews')->where('product_id', $id)->join('users', 'users.id', 'hotel_reviews.user_id')->select('hotel_reviews.*', 'users.name', 'users.avatar', 'users.id as uid')->orderBy('hotel_reviews.id', 'desc')->get();
        $avg = DB::table('hotel_reviews')->where('product_id', $id)->avg('rating');
        $avg1 = DB::table('hotel_reviews')->where('product_id', $id)->where('rating', 1)->avg('rating');
        $avg2 = DB::table('hotel_reviews')->where('product_id', $id)->where('rating', 2)->avg('rating');
        $avg3 = DB::table('hotel_reviews')->where('product_id', $id)->where('rating', 3)->avg('rating');
        $avg4 = DB::table('hotel_reviews')->where('product_id', $id)->where('rating', 4)->avg('rating');
        $avg5 = DB::table('hotel_reviews')->where('product_id', $id)->where('rating', 5)->avg('rating');


        $similar_places = Place::query()
            ->with('place_types')
            ->with('avgReview')
            ->withCount('reviews')
            ->withCount('wishList')
            ->where('city_id', $place->city_id)
            ->where('id', '<>', $place->id);
        foreach ($place->category as $cat_id) :
            $similar_places->where('category', 'like', "%{$cat_id}%");
        endforeach;
        $similar_places = $similar_places->limit(4)->get();

        return $this->response->formatResponse(200, [
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


        ]);
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

    $places = DB::table('places')->selectRaw('properties.id as property_id, place_translations.name , properties.slug, properties.name, properties.address,properties.city_id,properties.country_id, "2hotel" as type')->leftJoin('place_translations' , 'place_translations.place_id', 'properties.id')->where('place_translations.name', 'like', '%' . $keyword . '%');

    $citiess = DB::table('cities')->selectRaw('"" as property_id, city_translations.name , cities.slug, cities.id as city_id, "" as address, "1city" as type')
             ->leftJoin('city_translations' , 'city_translations.city_id', 'cities.id')
             ->where('city_translations.name', 'like', '%%' . $keyword . '%%')
             ->orderBy('city_translations.name', 'asc')
             ->limit(7)
             ->pluck('city_id')->toArray();
              $citiesssss = DB::table('cities')->selectRaw('"" as property_id, city_translations.name , cities.slug,cities.location,cities.country_id, cities.id as city_id, "" as address, "1city" as type')
             ->leftJoin('city_translations' , 'city_translations.city_id', 'cities.id')
             ->where('city_translations.name', 'like', '%' . $keyword . '%')

             ->union($places)
             // ->union($location)
             ->orderBy('type', 'asc')
             ->get();

$cities = DB::table('cities')->selectRaw('"" as property_id, city_translations.name, city_location.location_name,city_location.url , cities.slug, cities.id as city_id, "" as address, "1city" as type')
             ->leftJoin('city_translations' , 'city_translations.city_id', 'cities.id')
             ->leftJoin('city_location' , 'city_location.city_id', 'cities.id')
             ->where('city_translations.name', 'like', '%' . $keyword . '%')
             ->orwhere('city_location.location_name', 'like', '%' . $keyword . '%')
             ->union($places)
             // ->union($location)
             ->orderBy('type', 'asc')
             ->limit(30)
             ->get();




             if(count($cities)<=0){
                 $c = DB::table('city_location')->select('location_name as name','city_id','url',"type as type","location_name as location_name","location_name as address","location_name as slug"  )
                 ->where('location_name', 'LIKE', '%' . "$keyword" . '%')
                 ->get();
return $this->success_response("feteched", $c);

             }

             if(count($citiess)>0){

            $count=Place::where('city_id',$citiess[0])->get()->count();
            $city=City::find($citiess[0]);


                 $name = $city->name;
                 $names =$city->name.' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     '. $count."  Properties";
             $cities[0] = array("property_id" => "","name" =>$names,"slug" => "$city->name" ,"city_id" => $city->id ,"address" => "$names" ,"type" => "1city");

             if(isset($citiess[1])){
                $count1=Place::where('city_id',$citiess[1])->get()->count();
                $city1=City::find($citiess[1]);
                 $names1 =$city1->name.' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     '. $count1."  Properties";
                $cities[1] = array("property_id" => "","name" =>$names1,"slug" => "$city1->name" ,"city_id" => $city1->id ,"address" => "$names1" ,"type" => "1city");

             }


             }
if(isset($placess)  && !$citiess){
    return $this->success_response("feteched", $cities);

//    $name = $add;
$names = count($placess)."  Properties";
             $cities[0] = array("property_id" => "","name" =>$name,"slug" => "" ,"city_id" => "0" ,"address" => "$names" ,"type" => "3location");
}




return $this->success_response("feteched", $cities);
    }




    public function nearbyplace(Request $request, $radius = 8000)
    {
        $latitude = $request->lat;
        $longitude = $request->lng;

        $places = Place::query()
            ->selectRaw("properties.id,place_id,properties.user_id,city_translations.name as cityname,place_translations.name,properties.slug,address,properties.lat,properties.lng,properties.status,properties.city_id,properties.country_id,place_translations.description,properties.thumb,amenities,( 6371000 * acos( cos( radians(?) ) * cos( radians( properties.lat ) ) * cos( radians( properties.lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( properties.lat ) ) )) AS distances", [$latitude, $longitude, $latitude])
            ->select("properties.*", "city_translations.name as city_name", "hotel_reviews.avg_rating", "hotel_reviews.rating_count", "rooms.onepersonprice as price", "rooms.discount_percent")
            ->leftjoin(DB::raw("(SELECT avg(rating) as avg_rating,hotel_reviews.product_id,count(*) as rating_count FROM hotel_reviews ) as hotel_reviews"), function ($join) {
                $join->on("hotel_reviews.product_id", "=", "properties.id");
            })->join('cities', 'properties.city_id', 'cities.id')->join('city_translations', 'city_translations.city_id', 'cities.id')
            ->join('rooms', 'rooms.property_id', 'properties.id')
            ->limit(8)
            ->get();

        $data = [
            'places' => $places
        ];

        return $this->success_response('NearBy hotel fetched', $data);
    }







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