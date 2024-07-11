<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {

        $googleuser = Socialite::driver($social)->stateless()->user();
        $user=User::where('email',$googleuser->email)->first();
        auth()->login($user);

        return redirect()->to(session()->get('pre_url'));
    }
}
