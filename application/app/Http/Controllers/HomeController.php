<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Corporate;
use App\Models\Faq;
use App\Models\Location;
use App\Models\Place;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Models\Subscribe;
use App\Models\ReferelMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view("frontend.home.index");
    }

    public function refer()
    {
        $total = ReferelMoney::where('user_id', Auth::id())->sum('price');
        $referl_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 0)->sum('price');
        $used_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 1)->sum('price');

        return view('frontend.page.refer', [
            'referl_money' => $referl_money, 'used_money' => $used_money, 'total' => $total
        ]);
    }

    public function pageContact()
    {

        return view('frontend.page.contact');
    }

    public function corporate(Request $request)
    {

        return view('frontend.page.corporate');
    }


    public function corporateStore(Request $request)
    {
        $request->validate([
            'mobile'=>'required|unique:users,phone_number',
            'company'=>'required',
            'email'=>'required|unique:users,email'
        ]);
            $user = new User;
            $user->phone_number = $request->mobile;
            $user->name = $request->company;
            $user->email = $request->email;
            $user->save();

            $add = new Corporate;
            $add->name = $request->name;
            $add->user_id = $user->id;
            $add->address     = $request->address;
            $add->company_name     = $request->city;
            $add->save();


        $notification= array(
            'message'=>'Your query has been placed successfully. We will contact you soon!',
            'type'=>'success');
       return redirect()->route('corporate')->with($notification);
    }


    public function sendContact(Request $request)
    {
        $model = new Subscribe();
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->type = 2;
        $model->name = $request->name;
        $model->message = $request->message;

        $model->save();
        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Thanks for contacting us.We will get back to you as soon as possible.',

        );
        session()->put('messege', 'dddd');
        return back()->with($notification);
    }






    public function subscribe(Request $request)
    {

        $model = new Subscribe();
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->event = $request->event;
        $model->type = $request->type ? $request->type : 1;
        $model->name = $request->name;
        $model->message = $request->message;

        $model->save();
        if ($request->type == 0) {
            $notification = array(
                'alert-type' => 'success',
                'messege' => 'Thanks for for your query. we will get back to you as sson as possible',

            );

            return redirect()->back()->with($notification);
        }
        $message =  "Thanks for subscribing!  NSN hotels";
        Mail::send('frontend.mail.sub', [

            'email' =>  $request->email,


        ], function ($message) use ($request) {
            $email = $request->email;
            $message->to($email, "{$email}")->from('noreply@nsnhotels.com')->subject('Thanks for subscribing ' . 'Nsn Hotels ');
        });
        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Thanks for subscribing!',

        );

        return redirect()->back()->with($notification);
    }


    // ajax search

    public function locationSearch(Request $request)
    {
        $keyword =   $request->get('keyword');

        $places = DB::table('properties')->selectRaw('properties.id as hotel_id, properties.name , properties.slug, properties.address,properties.city_id,properties.state_id, "2hotel" as type')->where('properties.name', 'like', '%' . $keyword . '%');

        $citiess = DB::table('cities')->selectRaw('"" as hotel_id, cities.name , cities.slug, cities.id as city_id, "" as address, "1city" as type')
            ->where('cities.name', 'like', '%' . $keyword . '%')
            ->orderBy('type', 'asc')
            ->limit(7)
            ->limit(7)
            ->pluck('city_id')->toArray();


        $cities = DB::table('cities')->selectRaw('"" as hotel_id, cities.name, locations.name, cities.slug, cities.id as city_id, "" as address, "1city" as type')
            ->leftJoin('locations', 'locations.city_id', 'cities.id')
            ->where('cities.name', 'like', '%' . $keyword . '%')
            ->orwhere('locations.name', 'like', '%' . $keyword . '%')

            ->union($places)
            // ->union($location)
            ->orderBy('type', 'asc')
            ->limit(30)
            ->get();




        if (count($cities) <= 0) {
            $c = DB::table('locations')->select('name as name', 'city_id', 'url', "type as type", "name as location_name", "name as address", "name as slug")
                ->where('name', 'LIKE', '%' . "$keyword" . '%')
                ->get();
            return  $c;
        }


        if (count($citiess) > 0) {
            $count = Property::where('city_id', $citiess[0])->get()->count();
            $city = City::find($citiess[0]);


            $name = $city->name;
            $names = $city->name . ' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     ' . $count . "  Properties";
            $cities[0] = array("hotel_id" => "", "name" => $names, "slug" => "", "city_id" => $city->id, "address" => "$names", "type" => "1city");

            if (isset($citiess[1])) {
                $count1 = Property::where('city_id', $citiess[1])->get()->count();
                $city1 = City::find($citiess[1]);
                $names1 = $city1->name . ' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     ' . $count1 . "  Properties";
                $cities[1] = array("hotel_id" => "", "name" => $names1, "slug" => "", "city_id" => $city1->id, "address" => "$names1", "type" => "1city");
            }
        }
        if (isset($placess)  && !$citiess) {
            return $cities;
            //    $name = $add;
            $names = count($placess) . "  Properties";
            $cities[0] = array("hotel_id" => "", "name" => $name, "slug" => "", "city_id" => "0", "address" => "$names", "type" => "3location");
        }

        return $cities;
    }



    public function pageSearchListing(Request $request, $c = null, $l = null)
    {

        if (isset($request->lat) && isset($request->lng)) {
            if (isset($request->search_filter)) {
                $latitude = $request->lat;
                $longitude = $request->lng;
            } else {
                abort(404);
            }
        }
        if (isset($l)) {
            $c_location = Location::where('slug', str_replace('_', ' ', $l))->first();
            $latitude = $c_location->lat_n;
            $longitude = $c_location->long_e;
        }
        if ((isset($latitude) && isset($longitude)) && !$request->has('hotel')) {
            $city_locations = Location::where('lat_n', $latitude)->where('long_e', $longitude)->first();
            $title       = $city_locations->title ? $city_locations->title : $city_locations->name;
            $description = $city_locations->description ? $city_locations->description : "";
            $keywords    = $city_locations->keyword;
            // SEOMeta($title, $description, $keywords);
            $city_name = $city_locations->location_name;
        } elseif ($request->get('hotel') != null) {
            $city_name = Property::find($request->hotel)->value('slug');
        } else {
            $city_names = City::find($request->city);
            $city_name = $city_names ? $city_names->name : $request->search;
        }

        // storing data session for recent search section
        if (isset($request->search_filter)) {
            $data[] = [
                'url' => Request()->fullUrl(),
                'start_date' => $request->check_in_field,
                'end_date' => $request->check_out_field,
                'total_guest' => $request->total_guest,
                'total_room' => $request->total_room,
                'city_id' => null,
                'city_name' => $city_name ? $city_name : $request->search,
            ];

            $sessiondata = session()->get('search_history');
            if (isset($sessiondata) && count($sessiondata) > 0) {
                $sessiondata[] = [
                    'url' => Request()->fullUrl(),
                    'start_date' => $request->check_in_field,
                    'end_date' => $request->check_out_field,
                    'total_guest' => $request->total_guest,
                    'total_room' => $request->total_room,
                    'city_id' => null,
                    'city_name' => $city_name ? $city_name : $request->search,

                ];
                session()->put('search_history', $sessiondata);
            } else {
                session()->put('search_history', $data);
            }
        }
        $cityname = "";
        $keyword = $request->keyword;
        if ($request->get('hotel')) {
            $filter_hotel = $request->get('hotel');
        }
        $categories = Category::where('status', 1)->get();
        $place_types = PropertyType::query()
            ->get();
        $faq = [];
        if (isset($request->slug) || isset($request->city)) {
            $city = City::query()
                ->where('slug', $request->slug)
                ->orwhere('id', $request->city)
                ->first();
            // SEO Meta
            $title       = $city->seo_title ? $city->seo_title : $city->name;
            $description = $city->seo_description ? $city->seo_description : Str::limit($city->description, 165);
            $keywords    = $city->seo_keywords;
            // SEOMeta($title, $description, $keywords, getImageUrl($city->thumb));
            $cityname = $city->name;
            $faq = Faq::where('city_id', $city->id)->get();
        }

        if ($request->ajax()) {
            $places = Property::select('properties.*', 'properties.id as place_id')->leftjoin('rooms as po', 'po.hotel_id', '=', 'properties.id')->where('properties.status', 1)->where('po.onepersonprice', '>', 0);

            if ((isset($latitude) && isset($longitude)) && !$request->has('hotel')) {
                $placess = Property::selectRaw("properties.id as hotel_id, properties.name , properties.slug, properties.city_id,properties.address, '2hotel' as type,( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$latitude, $longitude, $latitude])
                    ->having("distance", "<", '2')
                    ->orderBy("distance", 'asc')->get();
                $mm = [];

                foreach ($placess as $value) {
                    array_push($mm, $value->hotel_id);
                }

                $places->WhereIn('properties.id', $mm);
            }

            if (isset($filter_hotel)) {
                $places->Where('properties.id', $filter_hotel);
            }

            if (isset($city)) {
                $places->Where('city_id', $city->id);
            }

            if ($request->budget) {
                $price = explode(',', $request->budget);
                $places = $places->whereBetween('onepersonprice', $price);
            }
            $count = $places->count();
            $places = $places->limit($request->limit)->offset($request->offset)->get();
            $view = view('frontend.partials.search_card', ['places' => $places])->render();
            return [
                'view' => $view,
                'count' => $count,
            ];
        }
        return view("frontend.search.search_01", [
            'cityname' => $cityname,
            'keyword' => $keyword,
            'categories' => $categories,
            'place_types' => $place_types,
            'faq' => $faq,
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



    public function ajaxSearch(Request $request)
    {
        $price = explode(',', $request->price_filter);

        $places = "SELECT rating AS avg,properties.city_id,properties.id,properties.status,properties.property_type_id,rooms.onepersonprice FROM properties  LEFT JOIN rooms ON rooms.property_id=properties.id   WHERE properties.status=1  ";


        if (isset($request->price_filter) && $request->price_filter != null) {
            $places .= " AND rooms.onepersonprice BETWEEN $price[0] AND $price[1]  ";
        }

        if (isset($request->star) && $request->star != null) {
            $star = $request->star;
            $places .= "AND   avg IN ($star) ";
        }
        if (isset($request->city_id) && $request->city_id != null) {
            $city_id = $request->city_id;
            $places .= "  AND   properties.city_id = $city_id ";
        }

        if (isset($request->place_type) && $request->place_type != null) {
            $place_type = $request->place_type;
            $places .= "AND   property_type_id LIKE  '%$place_type%'";
        }

        $places .= " limit 60";
        $places = DB::select($places);
        $arr = [];
        foreach ($places as $value) {
            $arr[] = $value->id;
        }

        $placess = Property::with('ratings')->whereIn('id', $arr)->get();

        $count = $placess->count();
        $view = view('frontend.partials.search_card', ['places' => $placess])->render();
        return [
            'view' => $view,
            'count' => $count,
        ];
    }
}
