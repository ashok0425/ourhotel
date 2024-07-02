<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ReferPrice;
use App\Models\ReferelMoney;
use App\Models\Testimonial;
use App\Models\Visitor;
use App\Notifications\SendReferNotification;
use App\Service\InteraktService;
use App\Service\SmsService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class UserController extends Controller
{


    public function pageProfile()
    {
        return view('frontend.user.user_profile');
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

        }
        $user = User::find(Auth::id());
        $user->profile_photo_path=$file_name;
        $user->name=$request->name;
        $user->save();

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
            return view("frontend.user.user_register");

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
            $InteraktService=new InteraktService();
            $res=$InteraktService->sendOtp($request->phone_code.$request->phone_no,$otp);
            $smsService=new SmsService();
            $smsService->sendOtpMessage($request->phone_code.$request->phone_no,$otp);
          return response()->json($request->all(),200);
        }else{
            return response()->json(0,200);

        }

        // send otp to mobile no using sms api

    }

    public function loginWithOtp(Request $request){
        $user  = User::where([['phone_number','=',request('phone_no')],['otp','=',request('otp')]])->first();

        if( $user){
             $user  = User::where('phone_number',$request->phone_no)->first();
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

    public function wallet(){
        $total = ReferelMoney::where('user_id', Auth::id())->sum('price');
        $used_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 1)->sum('price');
        $referl_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 0)->sum('price');
        return view('frontend.user.user_my_wallet',compact('total','used_money','referl_money'));
    }

    public function referMail(Request $request){
        $request->validate([
            'email' => 'required|email',
            'name'=>'required'
        ]);

        $code = 'NSN'. Auth()->user()->id;
        $email=$request->email;
        $name=$request->name;
        FacadesNotification::route('mail', $email)->notify(new SendReferNotification($name,$code));

        $notification=array(
            'alert-type'=>'success',
            'messege'=>'Refer mail sent Sucessfully',

         );

     return redirect()->back()->with($notification);

    }



}
