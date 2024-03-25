<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\City;
use App\Models\city_location;
use App\Models\Corporate;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Room;
use App\Models\Post;
use App\Models\Property;
use App\Models\User;
use App\Models\Subscribe;
use App\Models\Visitor;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\ReferelMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request){

       // SEO Meta

        $popular_cities =  Cache::remember('cities',604800, function () {
            return City::query()
            ->whereIn('id', [57,151,154,125,39,95,124,123,139,144,104])
            ->orderBy('slug','asc')
            ->limit(10)
            ->select('name','id','slug','thumbnail as thumb')
            ->get();
        });
        return view("frontend.home.index", [
             "popular_cities"=>$popular_cities
        ]);
    }

    public function refer(){
          $total = ReferelMoney::where('user_id',Auth::id())->sum('price');
          $referl_money = ReferelMoney::where('user_id',Auth::id())->where('is_used',0)->sum('price');
              $used_money = ReferelMoney::where('user_id',Auth::id())->where('is_used',1)->sum('price');

        return view('frontend.page.refer', [
            'referl_money' => $referl_money,'used_money' => $used_money,'total' => $total
        ]);
    }

    public function pageContact(){

        return view('frontend.page.contact');
    }

    public function corporate(Request $request){
         $new = 'old';
      if($request->mobile){
           $new = new User;
          $new->phone_number = $request->mobile;
          $new->name = $request->company;
          $new->email = $request->email;
          $new->save();
          $user  = User::where('phone_number',$request->mobile)->orderBy('id','desc')->first();
          $add = new Corporate;
          $add->name = $request->name;
          $add->user_id = $user->id;
          $add->address     = $request->address;
          $add->company_name     = $request->city;
          $add->save();
          $new = 'new';

       $this->sendBookingMsge($request->mobile,$request->name, $request->address,$request->city);
      }
        return view('frontend.page.corporate',[
            'new'=>$new,
        ]);
    }


    public function sendContact(Request $request){
        $model = new Subscribe();
        $model->email=$request->email;
        $model->phone=$request->phone;
        $model->type=2;
        $model->name=$request->name;
        $model->message=$request->message;

        $model->save();
        $notification=array(
            'alert-type'=>'success',
            'messege'=>'Thanks for contacting us.We will get back to you as soon as possible.',

         );
         session()->put('messege','dddd');
        return back()->with($notification);
    }






    public function subscribe(Request $request){

            $model = new Subscribe();
            $model->email=$request->email;
            $model->phone=$request->phone;
            $model->event=$request->event;
            $model->type=$request->type?$request->type:1;
            $model->name=$request->name;
            $model->message=$request->message;

            $model->save();
            if($request->type==0){
                $notification=array(
                    'alert-type'=>'success',
                    'messege'=>'Thanks for for your query. we will get back to you as sson as possible',

                 );

             return redirect()->back()->with($notification);
            }
                $message =  "Thanks for subscribing!  NSN hotels";
                     Mail::send('frontend.mail.sub',[

                'email' =>  $request->email,


            ], function ($message) use ($request) {
                  $email = $request->email;
                $message->to($email, "{$email}")->from('noreply@nsnhotels.com')->subject('Thanks for subscribing ' . 'Nsn Hotels ');
            });
                $notification=array(
                    'alert-type'=>'success',
                    'messege'=>'Thanks for subscribing!',

                 );

             return redirect()->back()->with($notification);

        }




    public function copyImage($start,$end){
        if(Auth::check()&&Auth::user()->is_admin==1){
         $place=Post::where('id','>=',$start)->where('id','<=',$end)->get();
         foreach ($place as $key => $value) {
          $path= $this->uploadImage(getImageUrl($value->thumb),'',true);
          if($path!=null){
            $upPlace=Post::find($value->id);
            $upPlace->thumb=$path;
            $upPlace->save();
          }
        }
                 }else{
                    abort(404);
                 }
    }





    public function addLangLat($start,$end){
        // if(Auth::check()&&Auth::user()->is_admin=='1'){
        $place=DB::table('city_location')->whereBetween('id',[$start,$end])->get();
        foreach ($place as $key => $value) {
         $path= $value->url;
         if($path){
            $ex=explode('&',$path);
            $lat=explode('=',$ex[1])[1];

            if (count(explode(',',$lat[1]))>1) {
            $lat=substr(explode('=',$ex[1])[1],0,-1);
            }
            $lng=explode('=',$ex[2])[1];
            $t=DB::table('city_location')->where('id',$value->id)->first();
            DB::table('city_location')->where('id',$value->id)->update([
               'lat_n'=>$lat,
               'long_e'=>$lng
              ]);
         }

        }
        return 'success';

        //    }else{
        //     abort(404);
        //    }
   }


// ajax search

public function locationSearch(Request $request) {
    $keyword =   $request->get('keyword');

    $places = DB::table('places')->selectRaw('places.id as hotel_id, place_translations.name , places.slug, places.name, places.address,places.city_id,places.country_id, "2hotel" as type')->leftJoin('place_translations' , 'place_translations.place_id', 'places.id')->where('place_translations.name', 'like', '%' . $keyword . '%');

    $citiess = DB::table('cities')->selectRaw('"" as hotel_id, cities.name , cities.slug, cities.id as city_id, "" as address, "1city" as type')
             ->where('cities.name', 'like', '%' . $keyword . '%')
             ->orderBy('type', 'asc')
             ->limit(7)
             ->limit(7)
             ->pluck('city_id')->toArray();
              $citiesssss = DB::table('cities')->selectRaw('"" as hotel_id, cities.name , cities.slug,cities.location,cities.country_id, cities.id as city_id, "" as address, "1city" as type')
             ->where('cities.name', 'like', '%' . $keyword . '%')
             ->union($places)
             // ->union($location)
             ->orderBy('type', 'asc')
             ->get();

$cities = DB::table('cities')->selectRaw('"" as hotel_id, cities.name, city_location.location_name,city_location.url , cities.slug, cities.id as city_id, "" as address, "1city" as type')
             ->leftJoin('city_location' , 'city_location.city_id', 'cities.id')
             ->where('cities.name', 'like', '%' . $keyword . '%')
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
                return  $c;
             }


             if(count($citiess)>0){
             $count=Property::where('city_id',$citiess[0])->get()->count();
             $city=City::find($citiess[0]);


                  $name = $city->name;
                  $names =$city->name.' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     '. $count."  Properties";
              $cities[0] = array("hotel_id" => "","name" =>$names,"slug" => "" ,"city_id" => $city->id ,"address" => "$names" ,"type" => "1city");

              if(isset($citiess[1])){
                 $count1=Property::where('city_id',$citiess[1])->get()->count();
                 $city1=City::find($citiess[1]);
                  $names1 =$city1->name.' &nbsp;   &nbsp;   &nbsp; &nbsp;   <br>     '. $count1."  Properties";
                 $cities[1] = array("hotel_id" => "","name" =>$names1,"slug" => "" ,"city_id" => $city1->id ,"address" => "$names1" ,"type" => "1city");

              }


              }
if(isset($placess)  && !$citiess){
return $cities;
//    $name = $add;
$names = count($placess)."  Properties";
             $cities[0] = array("hotel_id" => "","name" =>$name,"slug" => "" ,"city_id" => "0" ,"address" => "$names" ,"type" => "3location");
}

return $cities;

}



public function pageSearchListing(Request $request,$c=null,$l=null) {

    if(isset($request->lat) && isset($request->lng) ){
        if(isset($request->search_filter)){
            $latitude=$request->lat;
            $longitude=$request->lng;
        }else{
            abort(404);
        }
 }
 if(isset($l)){
    $c_location=city_location::where('location_name',str_replace('_',' ',$l))->first();
$latitude=$c_location->lat_n;
$longitude=$c_location->long_e;
 }
    if((isset($latitude) && isset($longitude)) && !$request->has('hotel')){
        $city_locations = city_location::where('lat_n',$latitude)->where('long_e',$longitude)->first();
        $title       = $city_locations->title ? $city_locations->title : $city_locations->name;
        $description = $city_locations->description ? $city_locations->description :"";
        $keywords    = $city_locations->keyword;
        SEOMeta($title, $description, $keywords);
   $city_name=$city_locations->location_name;
    }elseif($request->get('hotel')!=null){
   $city_name=Place::find($request->hotel)->value('slug');
    }else{
        $city_names=City::find($request->city);
       $city_name= $city_names?$city_names->name:$request->search;
    }

  // storing data session for recent search section
  if(isset($request->search_filter)){
  $data[]=[
    'url'=>Request()->fullUrl(),
    'start_date'=>$request->check_in_field,
    'end_date'=>$request->check_out_field,
    'total_guest'=>$request->total_guest,
    'total_room'=>$request->total_room,
    'city_id'=>null,
    'city_name'=>$city_name?$city_name:$request->search,
];

 $sessiondata=session()->get('search_history');
    if(isset($sessiondata)&&count($sessiondata)>0){
       $sessiondata[]=[
        'url'=>Request()->fullUrl(),
        'start_date'=>$request->check_in_field,
        'end_date'=>$request->check_out_field,
        'total_guest'=>$request->total_guest,
        'total_room'=>$request->total_room,
        'city_id'=>null,
        'city_name'=>$city_name?$city_name:$request->search,

    ];
    session()->put('search_history',$sessiondata);
    }else{
        session()->put('search_history',$data);
    }

  }
    $cityname = "";
    $keyword = $request->keyword;
if($request->get('hotel')){
     $filter_hotel = $request->get('hotel') ;
}
    $categories = Category::where('type', Category::TYPE_PLACE)->get();
    $place_types = PlaceType::query()
        ->get();
$faq=[];
        if(isset($request->slug) || isset($request->city)){
            $city = City::query()
                            ->where('slug',$request->slug)
                            ->orwhere('id',$request->city)
                            ->first();
                              // SEO Meta
                    $title       = $city->seo_title ? $city->seo_title : $city->name;
                    $description = $city->seo_description ? $city->seo_description : Str::limit($city->description, 165);
                    $keywords    = $city->seo_keywords;
                    SEOMeta($title, $description, $keywords, getImageUrl($city->thumb));
                    $cityname = $city->name;
                $faq = Faq::where('city_id',$city->id)->get();
            }

if($request->ajax()){
$places = Place::select('places.*','places.id as place_id')->leftjoin('rooms as po', 'po.hotel_id', '=', 'places.id')->where('places.status', 1)->where('po.onepersonprice', '>', 0);

if((isset($latitude) && isset($longitude)) && !$request->has('hotel')){
$placess = Place::selectRaw("places.id as hotel_id, place_translations.name , places.slug, places.city_id,places.address, '2hotel' as type,( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$latitude, $longitude, $latitude])->leftJoin('place_translations' , 'place_translations.place_id', 'places.id')
        ->having("distance", "<", '2')
        ->orderBy("distance",'asc')->get();
  $mm =[];

  foreach ($placess as $value){
 array_push($mm,$value->hotel_id);
}

$places->WhereIn('places.id',$mm);
}

if(isset($filter_hotel)){
    $places->Where('places.id',$filter_hotel);
    }

    if(isset($city)){
        $places->Where('city_id',$city->id);
        }

    if($request->budget){
        $price=explode(',',$request->budget);
$places=$places->whereBetween('onepersonprice',$price);
    }
   $count= $places->count();
   $places=$places->limit($request->limit)->offset($request->offset)->get();
    $view=view('frontend.partials.search_card',['places'=>$places])->render();
    return [
        'view'=>$view,
        'count'=>$count,
    ];
}
    $template = setting('template', '01');
    return view("frontend.search.search_{$template}", [
        'cityname' => $cityname,
        'keyword' => $keyword,
        'categories' => $categories,
        'place_types' => $place_types,
        'faq' =>$faq,
    ]);
}



public function banquote(){
    return view('frontend.banquote');
}

public function subCity(Request $request){
    $keyword = $request->search;

    $cities = city_location::with('getCity')->where('city_id',$request->id);

    if (isset($keyword)) {
        $cities->where('location_name', 'LIKE',"%{$keyword}%");
    }

    $cities = $cities->get();
    $data='';
foreach ($cities as $key => $value) {
$data.='<a class="cla" href="'.route("location.search",["city"=>$value->getCity->name,"location"=>str_replace(" ","_",$value->location_name)]).'">'.$value->location_name.'</a><br>';
}
    return $data;
}





public function mobileLocation(){
        $cities=Cache::get('cities');
        return $cities;
}

public function loadContent($contentId){

    if($contentId==1){
    $data= view('frontend.partials.offer1')->render();
    $section=2;
    }

    if($contentId==2){
    //     $banquet_places =
    //     Cache::remember('banquet_places',604800,function(){
    //       return  Place::with('avgReview')
    //     ->where('status', Place::STATUS_ACTIVE)
    //     ->where('place_type',json_encode(['42']))
    //     ->orderBy('id', 'desc')
    //     ->limit(4)
    //     ->get();
    // });
        $data= view('frontend.home.partials.nsn_bontique');
        $section=3;
        }

    if($contentId==3){
        $data= view('frontend.partials.offer2')->render();
        $section=4;
    }


    if($contentId==4){
        $data= view('frontend.home.partials.downloadapp')->render();
        $section=5;
    }
    if($contentId==5){
        $nsn_resort = Cache::remember('nsn_resort',604800,function(){
           return Place::with('avgReview')
        ->where('status', Place::STATUS_ACTIVE)
        ->where('place_type',json_encode(['41']))
        ->orderBy('id', 'desc')
        ->limit(4)
        ->get();
        });
        $data= view('frontend.home.partials.nsn_resort',['nsn_resort'=>$nsn_resort])->render();
        $section=6;
    }
    if($contentId==6){
        $data= view('frontend.partials.offer3')->render();
        $section=7;
    }
    if($contentId==7){
        $data= view('frontend.home.partials.popular_location')->render();
        $section=8;
    }
    if($contentId==8){
        $data= view('frontend.home.partials.blog')->render();
        $section=9;
    }

    if($contentId==9){
        $data= view('frontend.partials.offer4')->render();
        $section=10;
    }

    if($contentId==10){
        $data='';
        $section=11;
    }

    if($contentId==-1){
        $coupons_offer = Cache::remember('coupons_offer',604800, function () {
            return Coupon::orderBy('id','desc')->get();
         });

     $testimonials =Cache::remember('testimonials',604800,function(){
        return Testimonial::query()
        ->where('status', Testimonial::STATUS_ACTIVE)
        ->limit(4)
        ->get();
    });
     $offers=$coupons_offer;
        $section=0;

        return [
            'data'=>'',
            'section'=>$section,
            'offers'=>$offers,
            'testimonials'=>$testimonials
        ];
    }


    if($contentId==0){
        $trending_places =
        Cache::remember('trending_places',604800,function(){
          return  Place::where('status', Place::STATUS_ACTIVE)
        ->where('top_rated',1)
        ->orderBy('id', 'desc')
        ->groupBy('places.id')
        ->limit(4)
        ->get();
        });
        $data= view('frontend.home.partials.top_rated',['trending_places'=>$trending_places])->render();
        $section=1;
    }

    return [
        'data'=>$data,
        'section'=>$section,
    ];
}


public function sendBookingMsge($phone,$name,$add,$city) {
    //Multiple mobiles numbers separated by comma
    $mobileNumber = '91'.$phone;




    $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"6251822cfd28550635051635\",\n \"mobiles\": \"".$mobileNumber."\",\n \"Name\": \"".$name."\",\n  \"State\": \"".$city."\",\n \"City\": \"".$city."\",\n \"SPOC Name\": \"".$add."\",\n  \"Office Address\": \"".$add."\",\n \"dlt_template_id\": \"1207164544419203857\" \n}",
      CURLOPT_HTTPHEADER => array(
        "authkey: 365824AD62HRzVQS611a22d5P1",
        "content-type: application/JSON"
      ),
    ));

    $response = curl_exec($curl);

    $err = curl_error($curl);

    curl_close($curl);
// dd($response);
    if ($err) {

        "cURL Error #:" . $err;
        exit;
    } else {

      $response;

    }
    //  dd($response);
}


public function ajaxSearch(Request $request){
    $price=explode(',',$request->price_filter);

    $places="SELECT FORMAT(AVG(hotel_reviews.rating),0) AS avg,places.city_id,places.id,places.status,places.place_type,rooms.onepersonprice FROM places LEFT JOIN hotel_reviews ON hotel_reviews.product_id=places.id  LEFT JOIN rooms ON rooms.hotel_id=places.id GROUP BY places.id  HAVING places.status=1  ";


    if(isset($request->price_filter) && $request->price_filter!=null){
        $places .= " AND rooms.onepersonprice BETWEEN $price[0] AND $price[1]  ";
            }

            if(isset($request->star)&&$request->star!=null){
                $star=$request->star;
                $places .= "AND   avg IN ($star) ";
            }
            if(isset($request->city_id)&&$request->city_id!=null){
                $city_id=$request->city_id;
                $places .= "  AND   places.city_id = $city_id ";


            }

            if(isset($request->place_type) && $request->place_type!=null){
                $place_type=$request->place_type;
                $places .= "AND   place_type LIKE  '%$place_type%'";
            }

$places.=" limit 60";
        $places=DB::select($places);
        $arr=[];
        foreach($places as $value){
            $arr[]=$value->id;
        }

        $placess=Place::whereIn('id',$arr)->get();

        $count= $placess->count();
         $view=view('frontend.partials.search_card',['places'=>$placess])->render();
         return [
             'view'=>$view,
             'count'=>$count,
         ];
    }
// }


// "913de855-bdff-4ad8-bf7d-c3f00f4e68e1"
}
