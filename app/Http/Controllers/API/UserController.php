<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FcmNotification;
use App\Models\Place;
use App\Models\ReferelMoney;
use App\Models\User;
use App\Models\Wishlist;
use Barryvdh\DomPDF\Facade\Pdf;
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


    public function myBooking(Request $request){
        $user=Auth::user();
        $booking = Booking::join('properties','properties.id','bookings.property_id')->where('bookings.user_id',$user->id)->select('bookings.*','properties.name as hotel_name','properties.thumbnail as thumbnail','properties.address as address')->get();
        return $this->success_response('Booking list fetched successfully',$booking);
    }

    public function cancelBooking(Request $request){

        $user=Auth::user();
        $booking = Booking::where('user_id',$user->id)->where('id',$request->id)->first();

        if(!$booking){
         return $this->error_response('Unauthorized','',400);
        }
        $booking->status=0;
        $booking->cancel_reason=$request->cancel_reason;

        $booking->save();
        // $this->whatsapp_cancel('977'.$booking->phone_number, $booking->name);
        // $this->whatsapp_cancel('91'.$booking->phone_number, $booking->name,$booking->booking_id);
       //  $this->whatsapp_cancel('91'.$mm->phone_number, $mm->name);
        // $this->whatsapp_cancel('919958277997'.$booking->phone_number, $booking->name,$booking->booking_id);
        return $this->success_response('Booking  updated successfully',$booking);
    }

    public function invoice($id){
        $booking_id=Booking::find($id)->booking_id;
        $pdf = Pdf::loadView('common.booking.print', ['booking_id'=>$booking_id]);
        // return $pdf;
      return $pdf->download("$booking_id|invoice.pdf");
    }

    public function notifications(){
       $notifications=FcmNotification::whereJsonContains('userIds',Auth::user()->id)->latest()->select('created_at','body')
          ->limit(60)->get();
        return $this->success_response('Notification fetched',$notifications);

    }

}
