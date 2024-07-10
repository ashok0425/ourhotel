<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtp;
use App\Models\FcmNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ReferelMoney;
use App\Notifications\SendReferNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class UserController extends Controller
{


    public function pageProfile()
    {
        return view('frontend.user.user_profile');
    }


    public function wallet()
    {
        $total = ReferelMoney::where('user_id', Auth::id())->sum('price');
        $used_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 1)->sum('price');
        $referl_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 0)->sum('price');
        return view('frontend.user.user_my_wallet', compact('total', 'used_money', 'referl_money'));
    }

    public function referMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required'
        ]);

        $code = 'NSN' . Auth()->user()->id;
        $email = $request->email;
        $name = $request->name;
        FacadesNotification::route('mail', $email)->notify(new SendReferNotification($name, $code));

        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Refer mail sent Sucessfully',

        );

        return redirect()->back()->with($notification);
    }

    public function notification(){
        $notifications=FcmNotification::whereJsonContains('userIds',Auth::user()->id)->latest()->select('created_at','body')
           ->paginate(30);
           return view('frontend.user.user_my_notification', compact('notifications'));
     }
}
