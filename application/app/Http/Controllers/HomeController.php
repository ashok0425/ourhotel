<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\PropertyResourceCollection;
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

}
