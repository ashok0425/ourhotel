<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\ReferelMoney;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getUserInfo(Request $request)
    {
        $user = Auth::user();

        $total = ReferelMoney::where('user_id',$user->id)->sum('price');
          $referl_money = ReferelMoney::where('user_id',$user->id)->where('is_used',0)->sum('price');
              $used_money = ReferelMoney::where('user_id',$user->id)->where('is_used',1)->sum('price');
              $all_share = ReferelMoney::join('users','users.id',
              'referel_money.user_id')->where('user_id',$user->id)->where('referel_type',2)->select('users.phone_number','referel_money.price')->get();
              $data=[
                'user'=>$user,
                'total_amount'=>$total,
                'unused_money'=>$referl_money,
                'used_money'=>$used_money,
                'all_share'=>$all_share,


              ];
       return $this->success_response('Fetched successfully',$data);
    }

    public function getPlaceByUser($user_id)
    {
        $places = Place::query()
            ->where('user_id', $user_id)
            ->paginate();

        return $places;
    }

    public function getPlaceWishlistByUser($user_id)
    {
        $wishlists = Wishlist::query()
            ->where('user_id', $user_id)
            ->get('place_id')->toArray();

        $wishlists = array_column($wishlists, 'place_id');

        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->whereIn('id', $wishlists)
            ->paginate();

        return $places;
    }

}
