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
        $user->profile_photo_path = $file_name;
        $user->name = $request->name;
        $user->save();

        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Profile updated',

        );

        return redirect()->back()->with($notification);
    }

    public function sendOtp(Request $request){
         dispatch(new SendOtp($request->phone_code,$request->phone_no));
         return response()->json(0,200);
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

        if (Auth::user() == null) {
            return view("frontend.user.user_login");
        } else {
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
            'email' => 'email|required|unique:users',
            'phone_no' => 'required|unique:users,phone_number',
            'name' => 'required',
        ]);
        try {
            //code...

            $new = new User;
            $new->phone_number = $request->phone_no;
            $new->name = $request->name;
            $new->email = $request->email;
            $new->save();

            if ($request->referral_code) {
                $new::HandleRefer($request->referral_code,$new->id);
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
                    $user::HandleRefer($request->referral_code,$new->id);
                }
            return redirect('/');
        } else {
            $data['user'] = !empty($user) ? $user : 400;
            return response()->json($data);
        }
    }

}
