<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ReferelMoney;
use App\Notifications\SendReferNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class AuthController extends Controller
{

    public function loginPage()
    {
     return view("frontend.user.user_login");
    }


    public function registerPage()
    {
        return view("frontend.user.user_register");
    }



    public function registerStore(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|unique:users,phone_number',
            'name' => 'required',
        ]);
        try {

            $new = new User;
            $new->phone_number = $request->phone_no;
            $new->name = $request->name;
            $new->status = 1;
            // $new->email = $request->email;
            $new->save();

            if ($request->referral_code) {
                $refer = str_replace("NSN", "", $request->referral_code);
                if(!User::where('id',$refer)->first()){
                    return back()->withErrors(['refer'=>'Invalid referral code']);
                }
                $res=$new::HandleRefer($request->referral_code,$new->id);
            }

            $notification = array(
                'alert-type' => 'success',
                'messege' => 'Register successful.Now you can proceed to login',

            );

            return redirect()->route('user_login')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'alert-type' => 'info',
                'messege' => 'something went wrong please try again later !',

            );

            return redirect()->back()->with($notification);
        }
    }


    public function loginWithOtp(Request $request)
    {
        $user  = User::where([['phone_number', '=', request('phone_no')], ['otp', '=', request('otp')]])->first();

        if ($user) {
            $user  = User::where('phone_number', $request->phone_no)->first();
            Auth::login($user, true);
            User::where('phone_number', '=', $request->phone_no)->update(['otp' => null]);

                if ($request->referral_code) {
                    $user::HandleRefer($request->referral_code,$user->id);
                }
            return redirect('/');
        } else {
            $data['user'] = !empty($user) ? $user : 400;
            return response()->json($data);
        }
    }

    public function sendOtp(Request $request){
        dispatch(new SendOtp($request->phone_code,$request->phone_no));
        return response()->json(['otp sent'],200);
   }
}
