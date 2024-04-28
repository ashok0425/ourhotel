<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\BookingNotifyViaMsg;
use App\Jobs\BookingNotifyViaWP;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Property;
use App\Models\ReferelMoney;
use App\Models\Room;
use App\Models\Tax;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{

    public function index(Request $request){

        $hotel=Property::find($request->place_id);
        return view('frontend.booking_page',compact("request",'hotel'));
    }


    //check the selected payment gateway and redirect to that controller accordingly
    public function store(Request $request) {

        $request->validate([
            'first_name'=>['required','string'],
            "email"=>['required','email'],
             'phone_number'=>['required'],
             'place_id'=>['required','exists:properties,id'],
             'room_id'=>['required','exists:rooms,id'],
             'number_of_room'=>'required',
             'numbber_of_children'=>'required',
             'numbber_of_adult'=>'required',
             'payment_type'=>'required|in:online,offline'
        ]);

            if($request->booking_type=='hourlyprice'){
            $request['booking_start']=today();
            $request['booking_end']=today();
            }


$price=Property::getPrice($request->numbber_of_adult,$request->number_of_room,$request->room_id);
     $taxes=Tax::where('price_min','<=',$price)->where('price_max','>=',$price)->value('percentage');
     $tax=($taxes*$price)/100;
     $discount=session()->get('discount')?session()->get('discount.percent'):0||0;
     $discount_amount=number_format((int)$discount*(int)$price/100,0);
     $price_after_discount=(int)$price-(int)$discount_amount;
     $final_price=(int)$price_after_discount+(int)$tax;

        $user = User::updateOrCreate(
            ['phone_number' => $request->phone_code.$request->phone_number],
            [
                'name' => $request->first_name. ' '. $request->last_name,
                'email' => $request->email,
                'password' => bcrypt('Nsn@' . rand(1, 99999999))
            ]
        );


    $booking = new Booking();
    $booking->user_id = $user->id;
    $booking->property_id = $request->place_id;
    $booking->uuid = Str::uuid();
    $booking->booking_id = Booking::getBookingId();
    $booking->booking_start = $request['booking_start'];
    $booking->booking_end = $request['booking_end'];
    $booking->no_of_room = $request['number_of_room'];
    $booking->no_of_adult = $request['numbber_of_adult'];
    $booking->final_amount = $final_price;
    $booking->total_price = $price;
    $booking->discount = $discount_amount;
    $booking->tax = $tax;
    $booking->payment_type = $request['payment_type'];
    $booking->room_type = $request['room_type'];
    $booking->booking_type = $request['booking_type'];
    $booking->is_paid  = $request->is_paid ? 1 : 0;
    $booking->booked_by  = $user->id;
    $booking->status  = 2;
    $booking->channel = 'Web';
    $booking->early_reason	 = $request->message;
    $booking->name = $request->name;
    $booking->email = $request->email;
    $booking->phone_number = $request->phone_code. '-'. $request->phone_number;
    $booking->save();

    dispatch(new BookingNotifyViaWP($booking->id));
    dispatch(new BookingNotifyViaMsg($booking->id));

                if ($request->payment_type == 'online'){
                    $razorpay = new RazorpayController;
                    return $razorpay->payWithRazorpay($booking);
                }
                $uuid=$booking->uuid;
                return redirect()->route('thanku',compact('uuid'));
    }



    public function applyCoupon (Request $request){
        // $response = array();
        $request->validate([
           'coupon' => 'required|exists:coupons,coupon_name',
       ]);

       $cp=Coupon::where('coupon_name',$request->coupon)->where('status',1)->first();

       if(Carbon::parse($request->expired_at)<today()){
        $notification=array(
         'type'=>'error',
         'message'=>"Coupon Expired" );
    return redirect()->back()->with($notification);
    }

       if($request->price<$cp->coupon_min){
           $notification=array(
            'type'=>'error',
            'message'=>"Total amount must be greater or equal to $cp->coupon_min in order to apply coupon" );

       return redirect()->back()->with($notification);
       }

       $notification=array(
        'type'=>'success',
        'message'=>"Coupon applied successfully.",
     );
     session()->put('discount',[
        'name'=>$cp->coupon_name,
        'percent'=>$cp->coupon_percent,

     ]);

   return redirect()->back()->with($notification);
   }

   public function removeCoupon (Request $request){

    session()->forget('discount');
    $notification=array(
        'type'=>'success',
        'message'=>"Cpupon Removed" );

   return redirect()->back()->with($notification);
   }


   public function applyoffer (Request $request){
   $cp=DB::table('coupon')->where('link',$request->url)->first();
 session()->put('discount',[
    'name'=>$cp->coupon_name,
    'percent'=>$cp->coupon_percent,

 ]);

}


public function thanku($uuid){
    return view('frontend.user.thanku',compact('uuid'));
}



}
