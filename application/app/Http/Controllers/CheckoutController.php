<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Place;
use App\Models\ReferelMoney;
use App\Models\Room;
use App\Models\Tax;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CheckoutController extends Controller
{



    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request) {
            //  dd($request->all());
if($request->booking_type=='hourlyprice'){
$request['booking_start']=today();
$request['booking_end']=today();

}
        if ($request->payment_type != null) {
            $room=Room::find($request->room_id);
            if(!$room){
            return back();

            }
           $number_of_room = $request->number_of_room;
           $number_of_adult = $request->numbber_of_adult;
           $oneprice = $room->onepersonprice;
           $twoprice = $room->twopersonprice?$room->twopersonprice:$oneprice;
           $diffinprice = $room->threepersonprice?$room->threepersonprice-$twoprice:$twoprice-$oneprice;
$threeprice=$room->threepersonprice?$room->threepersonprice:$twoprice+$diffinprice;


           $final_adult_price=0;
            switch ($number_of_adult) {
                case 1:
                    $final_adult_price = $number_of_room * $oneprice;
                    break;
                case 2:

                    if ($number_of_room == 1) {
                        $final_adult_price = $twoprice;
                    } else {
                        $final_adult_price = 2 * $oneprice;
                    }

                    break;
                case 3:

                    if ($number_of_room == 1) {
                        $final_adult_price = $threeprice;
                    }
                    if ($number_of_room == 2) {
                        $final_adult_price = 2 * $twoprice;
                    } else {
                        $final_adult_price = $number_of_room * $oneprice;
                    }
                    break;

                case 4:
                    $final_adult_price = $number_of_room * $twoprice;
                    break;

                case 5:
                    if ($number_of_room == 2) {
                        $final_adult_price = (2 * $twoprice) + $diffinprice;
                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }
                    break;

                case 6:
                    $final_adult_price = $number_of_room * $threeprice;
                    break;
                case 7:

                    if ($number_of_room == 3) {
                        $final_adult_price = (3 * $twoprice) + $diffinprice;

                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }

                    break;
                case 8:

                    if ($number_of_room == 3) {
                        $final_adult_price = (3 * $twoprice) + $twoprice;
                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }
                    break;
                case 9:

                    if ($number_of_room == 3) {
                        $final_adult_price = 3 * $threeprice;

                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }
                    break;
                case 10:

                    if ($number_of_room == 4) {
                        $final_adult_price = (2 * $threeprice)+ (2 * $twoprice);

                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }

                    break;
                case 11:
                    $final_adult_price = (2 * $threeprice) + $twoprice;

                    if ($number_of_room == 4) {
                        $final_adult_price = (2 * $threeprice)+ (2 * $twoprice)+$diffinprice;

                    } else {
                        $final_adult_price = $number_of_room * $twoprice;
                    }

                    break;
                case 12:
                    if ($number_of_room == 4) {
                        $final_adult_price = 4 * $threeprice;

                    } else {
                        $final_adult_price = (3 * $threeprice)+  $twoprice+$diffinprice;
                    }
                    break;
                case 13:
                if ($number_of_room == 4) {
                        $final_adult_price =( 4 * $threeprice)+$diffinprice;

                    } else {
                        $final_adult_price = (3 * $threeprice)+ (2 * $twoprice);
                    }
                    break;
                case 14:
                if ($number_of_room == 4) {
                        $final_adult_price =( 3* $threeprice)+(2*$twoprice)+$diffinprice;

                    } else {
                        $final_adult_price = (3 * $threeprice)+ (3 * $twoprice);
                    }
                    break;
                case 15:
                    $final_adult_price = 5 * $threeprice;
                    break;

                default:
                    $final_adult_price =$number_of_room * $oneprice;

                    break;
            }


$price=$final_adult_price;
     $taxes=Tax::where('price_min','<=',$price)->where('price_max','>=',$price)->value('percentage');
     $tax=($taxes*$price)/100;
     $discount=session()->get('discount')?session()->get('discount.percent'):0||0;
     $discount_amount=number_format((int)$discount*(int)$price/100,0);
     $price_after_discount=(int)$price-(int)$discount_amount;
     $total_price=(int)$price_after_discount+(int)$tax;
     $request['amount']=$total_price;
     $request['discountPrice']=$total_price;
     $request['tax']=$tax;

                if ($request->payment_type == 'online') {
                    return $this->payNow($request);
                } elseif ($request->payment_type == 'offline') {
                    return $this->pay_at_hotel($request);
                }
        } else {
            return back();
        }
    }

    public function payNow(Request $request) {
        $request['user_id'] = Auth::id();
        $request['name'] = $request->first_name.' '.$request->last_name;
        $request['booking_id'] = 'NSN'.str_pad(rand(1,1000000),6,0);
        $request['booking_from'] = 'web';

        if($request->is_check == 1){
          $referal=  ReferelMoney::where('user_id',Auth::id())->orderBy('id','asc')->where('is_used',0)->first();
          $referal->status=1;
          $referal->save();
          if ($referal) {
            $request['refer_amount_spent'];
            $request['refer_id'];
          }

            }

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',
            'room_type' => '',
            "booking_id"=>'',
            'numbber_of_adult' => '',
            'numbber_of_children' => '',
            'booking_start' => '',
            'booking_end' => '',
            'time' => '',
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'message' => '',
            'type' => '',
            'number_of_room' => '',
            'payment_type' => '',
            'amount'    =>  '',
            'discountPrice' => '',
            'TotalPrice' => '',
            'refer_id' => '',
            'refer_amount_spent' => '',
            'booking_from'=>'',
            'booking_type'=>''

        ]);
        $booking = new Booking();
        $booking->fill($data);
        if ($booking->save()) {



              $place = Place::find($request['place_id']);
   $place_email =  User::where('id',$place->user_id)->first();
           $request['booking_id'] = $booking->id;
           $name = $request->first_name.' '.$request->last_name;

                if ($booking->save()) {
            $email = $request->email;
            $phone = $request->phone_number;
            $start_date = $booking->booking_start;
            $end_date = $booking->booking_end;
            $numberofadult = $booking->numbber_of_adult;
            $numberofchildren = $booking->numbber_of_children;
            $book_id = $booking->id;
            $text_message = $request->message;
            if($request->email){
          Mail::send('frontend.mail.new_booking', [
                'name' => $name,
                'email' => $email,
                'phone' => $request->phone_number,
                'place' => $place->PlaceTrans->name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'book_id' => $book_id,
                'numberofadult' => $numberofadult,
                'numberofchildren' => $numberofchildren,
                'text_message' => $text_message,
                'booking_at' => $booking->created_at
            ], function ($message) use ($request,$place_email) {
                   $email = [$request->email,$place_email->email,'nsnhotels@gmail.com'];
                $message->to($email, "{user()->name}")->subject('Booking from ' . user()->name);
            });
            }
        }
        $diff=Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
        // $ph=substr($phone,1);
        $data="Hotel Name:".$place->name.", Check-in Date:$start_date 12pm onwards, Check-out Date:$end_date 11 am, Number of Rooms:$request->number_of_room, Number of Nights:1, Number of Adult:-$request->numbber_of_adult, Number of Childres:-$request->numbber_of_children, Booking Amount:$booking->amount, Hotel Address:$place->address";
        $map='map';
        $this->whatsapp_review($request->phone_code.$phone, $name);
               $res= $this->whatsapp_booking($request->phone_code.$phone,$name,$booking->booking_id,$data,$map);
                $this->whatsapp_booking('91'.$place_email->phone_number,$name,$booking->id,$data,$map);
                $this->whatsapp_booking('919958277997',$request->name,$booking->id,$data,$map);
          $razorpay = new RazorpayController;
          return $razorpay->payWithRazorpay($request);
        }

        return redirect()->route('user_my_place')->with('success', 'Thanks for your hotel booking with NSN Hotels!');
    }

    public function pay_at_hotel(Request $request) {
        $request['user_id'] = Auth::id();
        $place = Place::find($request['place_id']);

   $place_email =  User::where('id',$place->user_id)->first();
   // $request['place_id']=Room::where('id',room )->value('hotel_id');
   $request['booking_id'] = 'NSN'.str_pad(rand(1,1000000),6,0);
   $request['booking_from'] = 'web';
   $request['name'] = $request->first_name.' '.$request->last_name;

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',
            'room_type' => '',
            'booking_id' => '',
            'numbber_of_adult' => '',
            'numbber_of_children' => '',
            'booking_start' => '',
            'booking_end' => '',
            'time' => '',
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'message' => '',
            'type' => '',
            'payment_type' => '',
            'amount'    =>  '',
            'discountPrice' => '',
            'TotalPrice' => '',
            'number_of_room' => '',
            'booking_type'=>'',
            'booking_from'=>''
        ]);
        $booking = new Booking();
        $booking->fill($data);

        if ($booking->save()) {
            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone_number;
            $start_date = $booking->booking_start;
            $end_date = $booking->booking_end;
            $numberofadult = $booking->numbber_of_adult;
            $number_of_room = $booking->number_of_room;
            $numberofchildren = $booking->numbber_of_children;
            $book_id = $booking->booking_id;
            $text_message = "";
            if($request->email){
        Mail::send('frontend.mail.new_booking', [
                'name' => user()->name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'place' => $place->PlaceTrans->name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'book_id' => $book_id,
                'numberofadult' => $numberofadult,
                'numberofchildren' => $numberofchildren,
                'text_message' => $text_message,
                'booking_at' => $booking->created_at
            ], function ($message) use ($request,$place_email) {
                   $email = [$request->email,$place_email->email,'nsnhotels@gmail.com'];
                $message->to($email, "{user()->name}")->subject('Booking from ' . user()->name);
            });
            }
        }
        $res=$this->sendBookingMsg($phone,$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type,$request->$number_of_room,$book_id);

        $this->sendBookingMsg($place_email->phone_number,$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type,$request->$number_of_room,$book_id,$book_id);
        $this->sendBookingMsg('9958277997',$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type,$request->$number_of_room,$book_id);

        $diff=Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
// $ph=substr($phone,1);
$data="Hotel Name:$place->name, Check-in Date:$start_date 12pm onwards, Check-out Date:$end_date 11 am, Number of Rooms:$request->number_of_room, Number of Nights:1, Number of Adult:-$request->numbber_of_adult, Number of Childres:-$request->numbber_of_children, Booking Amount:$booking->amount, Hotel Address:$place->address";
$map='map';
 $this->whatsapp_review($request->phone_code.$phone, $request->name);
       $res= $this->whatsapp_booking($request->phone_code.$phone,$request->name,$booking->booking_id,$data,$map);
        $this->whatsapp_booking('91'.$place_email->phone_number,$place->name,$booking->id,$data,$map);
        $this->whatsapp_booking('919958277997',$request->name,$booking->id,$data,$map);
        return redirect()->route('user_my_place')->with('success', 'Thanks for your hotel booking with NSN Hotels!');

    }



    public function checkCoupon (Request $request){
        // $response = array();
        $validator = FacadesValidator::make($request->all(), [
           'coupon' => 'required',
       ]);

       if ($validator->fails()) {
           $errors=$validator->errors()->messages();
           $datas=[];
           foreach ($errors as $key => $value) {
               $datas[]=$value[0];
           }

           $notification=array(
            'alert-type'=>'error',
            'messege'=>"Coupon is required field",

         );

     return redirect()->back()->with($notification);
       }
       $cp=DB::table('coupon')->where('coupon_name',$request->coupon)->where('status',1)->first();
       if (!$cp) {
           $notification=array(
            'alert-type'=>'error',
            'messege'=>"Invalid coupon",

         );

     return redirect()->back()->with($notification);
       }
       if($request->price<$cp->coupon_min){

           $notification=array(
            'alert-type'=>'error',
            'messege'=>"Total amount must be greater or equal to $cp->coupon_min inorder to apply coupon",

         );

     return redirect()->back()->with($notification);
       }
       $notification=array(
        'alert-type'=>'success',
        'messege'=>"Coupon applied successfully.",
     );
     session()->put('discount',[
        'name'=>$cp->coupon_name,
        'percent'=>$cp->coupon_percent,

     ]);

 return redirect()->back()->with($notification);
   }



   public function applyoffer (Request $request){
   $cp=DB::table('coupon')->where('link',$request->url)->first();
 session()->put('discount',[
    'name'=>$cp->coupon_name,
    'percent'=>$cp->coupon_percent,

 ]);

}




}
