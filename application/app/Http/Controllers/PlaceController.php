<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Review;
use App\Models\MealHotel;
use App\Models\Meal;
use App\Models\Booking;
use App\Models\Room;
use Astrotomic\Translatable\Validation\RuleFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\ReferPrice;
use App\Models\ReferelMoney;
use App\Models\Tax;
class PlaceController extends Controller
{
    private $place;
    private $country;
    private $city;
    private $category;
    private $amenities;
    private $response;

    public function __construct(Place $place, Country $country, City $city, Category $category, Amenities $amenities, Response $response)
    {
        $this->place     = $place;
        $this->country   = $country;
        $this->city      = $city;
        $this->category  = $category;
        $this->amenities = $amenities;
        $this->response  = $response;
    }

    public function detail(Request $request,$slug)
    {
       if(isset($request->start_date)){
        $start_date  = $request->start_date;
        $end_date  = $request->end_date;
       }
       else{
         $start_date  = '';
        $end_date  = '';
       }
        $places = $this->place->getBySlug($slug, ['city', 'city.country', 'roomsData']);
        if (!$places) {
            abort(404);
        }
         if(isset($request->start_date)){
          $date      = date('Y-m-d', strtotime($request->start_date));
          $result = getCalendes($date,$places->id);
       }
        $place = $this->place->getBySlug($slug, ['city', 'city.country', 'roomsData']);
          $city = $place->city;
        $amenities = Amenities::whereIn('id', $place->amenities ? $place->amenities : [])
            ->get(['id', 'name', 'icon']);
        $categories = Category::query()
            ->whereIn('id', $place->category ? $place->category : [])
            ->get(['id', 'name', 'slug', 'icon_map_marker']);

        $place_types = PlaceType::query()
            ->whereIn('id', $place->place_type ? $place->place_type : [])
            ->get(['id', 'name']);


        $similar_places = Place::query()
            ->with('place_types')
            ->with('avgReview')
            ->withCount('reviews')
            ->withCount('wishList')
            ->where('city_id', $city->id)
            ->where('id', '<>', $place->id)->limit(4)->get();
            // dd($similar_places);
         $referl_money = ReferelMoney::where('user_id',Auth::id())->where('is_used',0)->sum('price');

        //  Coupon
        $coupon= Coupon::get();
        // echo $coupon; die;

        // SEO Meta
        $title       = $place->seo_title ? $place->seo_title : $place->PlaceTrans->name;
        $description = $place->seo_description ? $place->seo_description : Str::limit($place->description, 165);
        $keywords    = $place->seo_keywords;
        SEOMeta($title, $description, $keywords, getImageUrl($place->thumb));
        $template = setting('template', '01');
        $date = date('Y-m-d');
         $booking_total =  Booking::where('booking_start',$date)->where('place_id',$place->id)->count();
         $inventory_room =10;
         if(isset($booking_total)  && isset($place->roomsData->first()->number)){
           $inventory_room = $place->roomsData->first()->number - $booking_total;
         }

        return view("frontend.place.place_detail_{$template}", [
            'place'            => $place,
            'places'            => $place,
            'city'             => $city,
            'amenities'        => $amenities,
            'categories'       => $categories,
            'place_types'      => $place_types,
            'similar_places'   => $similar_places,
            'referl_money'     => $referl_money,
            'end_date'         => $end_date,
            'start_date'       => $start_date,
            'inventory_room'       => $inventory_room,

        ]);

    }





    public function pageAddNew(Request $request, $id = null)
    {
        $place = Place::find($id);

        if ($place) {
            abort_if($place->user_id !== Auth::id(), 401);
        }

        $country_id = $place ? $place->country_id : false;
        // $message = "nsn  test";
        //     Mail::send('frontend.mail.new_place', [
        //         'email'   => '1ashishji1@gmail.com',
        //         'place'   => 'aaa',
        //         'address' => 'teste',
        //     ], function ($message) use ($request) {
        //         $message->to('1ashishji1@gmail.com', "nsnhotels")->subject('Add New Hotel' . 'nsn');
        //     });
        $countries  = $this->country->getFullList();
        $cities     = $this->city->getListByCountry($country_id);
        $categories = $this->category->getListAll(Category::TYPE_PLACE);

        $place_types = Category::query()
            ->with('place_type')
            ->get();

        $amenities = $this->amenities->getListAll();

        $app_name = setting('app_name', 'NSN Hotels.');
        SEOMeta("Add new place - {$app_name}");
        return view('frontend.place.place_addnew', [
            'place'       => $place,
            'countries'   => $countries,
            'cities'      => $cities,
            'categories'  => $categories,
            'place_types' => $place_types,
            'amenities'   => $amenities,
        ]);
    }


    public function create(Request $request)
    {
        $request['user_id'] = Auth::id();
        $request['slug']    =getSlug($request,'name');
        $request['status']  = Place::STATUS_PENDING;

        $partner_name = $request->partner_name;

        $city      = City::find($request->city_id);
        $city_name = $city ? $city->name : '';

        $country      = Country::find($request->country_id);
        $country_name = $country ? $country->name : '';

        $hotel_name = $request['slug'];

        $rule_factory = RuleFactory::make([
            'user_id'         => '',
            'country_id'      => '',
            'partner_name'   => '',
            'city_id'         => '',
            'category'        => '',
            'place_type'      => '',
            '%name%'          => '',
            'slug'            => '',
            '%description%'   => '',
            'price_range'     => '',
            'amenities'       => '',
            'address'         => '',
            'lat'             => '',
            'lng'             => '',
            'email'           => '',
            'phone_number'    => '',
            'website'         => '',
            'social'          => '',
            'opening_hour'    => '',
            'gallery'         => '',
            'video'           => '',
            'link_bookingcom' => '',
            'status'          => '',
            'thumb'           => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        $data = $this->validate($request, $rule_factory);

        if ($request->hasFile('thumb')) {
            $thumb         = $request->file('thumb');
            $thumb_file    = $this->uploadImage($thumb, '');
            $data['thumb'] = $thumb_file;
        }

        $model = new Place();
        $model->fill($data);

        if ($model->save()) {

            Mail::send('frontend.mail.new_place', [
                'email'   => request()->email,
                'place'   => request()->name,
                'address' => request()->address,
            ], function ($message) use ($request) {
                $message->to($request->email, "{$request->name}")->subject('Add New Hotel' . $request->name);
            });

            if (!empty(request()->phone_number)) {
                $this->sendAddhotelMsg($request->phone_number, $hotel_name, $request->email, $request->address, $city_name, $country_name, $partner_name);
            }
            return back()->with('success', 'Hotel Added successfully. Waiting admin review and approval!');
        }
    }

    public function sendAddhotelMsg($contact, $hotel_name, $email, $hoteladdress, $city_name, $country_name, $partner_name)
    {

        //Your authentication key
        $authKey = "365824AD62HRzVQS611a22d5P1";

        //Multiple mobiles numbers separated by comma
        $mobileNumber = "";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "{\n  \"flow_id\": \"611fe7d63df21761d2584c45\",\n \n  \"mobiles\": \"91" . $contact . "\",\n  \"HotelName\": \"" . $hotel_name . "\",\n  \"State\": \"" . $country_name . "\",\n  \"City\": \"" . $city_name . "\",\n  \"OwnerName\": \"" . $partner_name . "\",\n  \"OwnerContact\": \"" . $contact . "\",\n  \"HotelAddress\": \"" . $hoteladdress . "\"\n}",
            CURLOPT_HTTPHEADER     => array(
                "authkey: " . $authKey . "",
                "content-type: application/JSON",
            ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            "cURL Error #:" . $err;
        } else {

            $response;

        }
    }

}
