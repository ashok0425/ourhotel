<?php

namespace App\Http\Controllers;

use App\Commons\APICode;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\Booking;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ReferPrice;
use App\Models\ReferelMoney;
use App\Models\Visitor;

class UserController extends Controller
{
    private $wishlist;
    private $response;

    public function __construct(Wishlist $wishlist, Response $response)
    {
        $this->wishlist = $wishlist;
        $this->response = $response;
    }


    public function pageProfile()
    {
        $app_name = setting('app_name', '');
        SEOMeta("User profile - {$app_name}");
        return view('frontend.user.user_profile');
    }

    public function pageMyPlace()
    {
        // Get list places
        $bookings = Booking::query()
            ->with('user')
            ->with('place')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $app_name = setting('app_name', 'NSN');
        SEOMeta("My Booking - {$app_name}");
        return view('frontend.user.user_my_place', [
            'bookings' => $bookings,
        ]);
    }

    public function pageMyWallet()
    {

        $total = ReferelMoney::where('user_id',Auth::id())->sum('price');
        $referl_money = ReferelMoney::where('user_id',Auth::id())->where('is_used',0)->sum('price');
            $used_money = ReferelMoney::where('user_id',Auth::id())->where('is_used',1)->sum('price');

        $app_name = setting('app_name', 'NSN');
        SEOMeta("My Wallet - {$app_name}");
        return view('frontend.user.user_my_wallet', [
            'total' => $total,
            'used_money' => $used_money,
            'referl_money' => $referl_money,

        ]);
    }

    public function thanku(Request $request)
    {

        // Get list places
        $bookings = Booking::query()
            ->with('user')
            ->with('place')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $app_name = setting('app_name', 'NSN');

        if($request->photo_id){
             $data = $this->validate($request, [
            'photo_id' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $img = $request->file('photo_id');


            $icon = $request->file('photo_id');
            $file_name = $this->uploadImage($icon, '');
            $data['photo_id'] = $file_name;



				$user = User::find(Auth::id());

			   $user->fill($data)->save();
            return   back()->with('success', 'Thanku for upload  your E-Check ID');
        }
           SEOMeta("My Booking - {$app_name}");
        return view('frontend.user.thanku', [
            'bookings' => $bookings,
        ]);

    }

    public function updateProfile(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'phone_number' => '',
        ]);
        if ($request->hasFile('avatar')) {
            $icon = $request->file('avatar');
            $file_name = $this->uploadImage($icon, '');
            $data['avatar'] = $file_name;
        }
        $user = User::find(Auth::id());
        $user->fill($data)->save();
        $notification=array(
            'alert-type'=>'success',
            'messege'=>'Profile updated',

         );

     return redirect()->back()->with($notification);
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $data = $this->validate($request, [
            'old_password' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required'],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Wrong old password!');
        }

        if ($request->password !== $request->password_confirmation) {
            return back()->with('error', 'Password confirm do not match!');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('success', 'Change password success!');
    }


    public function loginPage()
    {

       if (Auth::user() == null){
            return view("frontend.user.user_login");
        }else{
             return redirect('/');
        }

    }


    public function registerPage()
    {

       if (Auth::user() == null){
            return view("frontend.user.user_register");
        }else{
             return redirect('/');
        }

    }



    public function registerStore(Request $request)
    {
    $request->validate([
        'email'=>'email|required|unique:users',
        'phone_no'=>'required|unique:users,phone_number',
        'name'=>'required',
    ]);
    try {
        //code...

    $new = new User;
    $new->phone_number = $request->phone_no;
    $new->name = $request->name;
    $new->email = $request->email;
    $new->save();

     if($request->referral_code){
      $refer = str_replace("NSN","",$request->referral_code);
                $referl_price = ReferPrice::first();
                // for share amount
                $referl_money = new ReferelMoney();
                $referl_money->user_id = $refer;
                $referl_money->price =  $referl_price->share_price;
                $referl_money->refewrel_type ='2' ;
                $referl_money->referel_code =$request->referral_code ;
                $referl_money->save();

                // for join amount
                $join_money = new ReferelMoney();
                $join_money->user_id = $new->id;
                $join_money->price =  $referl_price->join_price;
                $join_money->refewrel_type ='1' ;
                $join_money->referel_code =$request->referral_code;
                $join_money->save();

             }

    $notification=array(
        'alert-type'=>'success',
        'messege'=>'Register successful.Now you can proceed to login',

     );

 return redirect()->route('user_login')->with($notification);

} catch (\Throwable $th) {
    $notification=array(
        'alert-type'=>'info',
        'messege'=>'something went wrong please try again later !',

     );

 return redirect()->back()->with($notification);

}
    }


    public function sendOtp(Request $request){
        $otp=str_pad(rand(1,1000000),6,'0');
        $user = User::where('phone_number','=',$request->phone_no)->update(['otp' => $otp]);
        if($user){
          $this->sendMessage($otp, $request->phone_no);
          return $this->whatsapp_verification($request->phone_code.$request->phone_no,$otp);
          return response()->json($request->all(),200);
        }else{
            return response()->json(0,200);

        }

        // send otp to mobile no using sms api

    }

    public function loginWithOtp(Request $request){
        $user  = User::where([['phone_number','=',request('phone_no')],['otp','=',request('otp')]])->first();

        if( $user){
            $ip =  $request->ip();
            //   dd($_SERVER);
               $visitor = Visitor::where('ip_address',$ip)->value('id');
               $user  = User::where('phone_number',$request->phone_no)->first();

                $user->ip_id=$visitor;
                $user->save();
                 Auth::login($user, true);
            User::where('phone_number','=',$request->phone_no)->update(['otp' => null]);



            if($request->referral_code){
                $UserId = substr($request->referral_code, 3);
                $referl_price = ReferPrice::first();
                $referl_money = new ReferelMoney();
                $referl_money->user_id = $UserId;
                $referl_money->price =  $referl_price->share_price;
                $referl_money->refewrel_type ='2' ;
                $referl_money->referel_code =$request->referral_code ;
                $referl_money->save();
                $join_money = new ReferelMoney();
                 $join_money->user_id = $user->id;
                $join_money->price =  $referl_price->join_price;
                $join_money->refewrel_type ='1' ;
                $join_money->referel_code =$request->referral_code;
                $join_money->save();
         }
             return redirect('/');
        }
        else{
            $data['user'] = ! empty ($user) ? $user : 400;
            return response()->json($data);
        }
    }

    public function sendMessage($otp, $number)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"6129d0b64e38b3307e5f35e3\",\n  \n  \"mobiles\": \"91".$number."\",\n  \"otp\": \"".$otp."\"\n}",
          CURLOPT_HTTPHEADER => array(
            "authkey: 365824AD62HRzVQS611a22d5P1",
            "content-type: application/JSON"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    }

}
