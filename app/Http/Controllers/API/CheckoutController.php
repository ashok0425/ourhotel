<?php

namespace App\Http\Controllers\Api;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Place;
use App\Models\ReferelMoney;
use App\Models\Room;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Redirect;

class CheckoutController extends Controller
{


    public function store(Request $request) {
$user= $this->getUserByApiToken($request);

        $request['user_id'] =$user->id;
        $request['booking_id'] = 'NSN'.str_pad(rand(1,1000000),6,0);
        $request['place_id']=Room::where('id',$request['place_id'])->value('hotel_id');
        $request['booking_id'] = 'NSN'.str_pad(rand(1,1000000),6,0);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'place_id' => 'required',
            'numbber_of_adult' => 'required',
            'numbber_of_children' => 'required',
            'booking_start' => 'required',
            'booking_end' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'message' => '',
            'type' => '',
            'payment_type' => 'required',
            'amount'    =>  'required',
            'discountPrice' => '',
            'TotalPrice' => 'required',
            'tax' => 'required',
            'number_of_room' => 'required'
        ]);

        if ($validator->fails()) {
            $errors=$validator->errors()->messages();
            $datas=[];
            foreach ($errors as $key => $value) {
                $datas[]=$value[0];
            }

            return $this->error_response($datas,'',400);
        }


        $request['amount'] = $request->amount;
        $place = Place::find($request['place_id']);
   $place_email =  User::where('id',$place->user_id)->first();
   $data=$request->all();
        $booking = new Booking();
        $booking->fill($data);

        if ($booking->save()) {
            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone_number;
            $start_date = $booking->booking_start;
            $end_date = $booking->booking_end;
            $numberofadult = $booking->numbber_of_adult;
            $numberofchildren = $booking->numbber_of_children;
            $book_id = $booking->id;
            $text_message = "";
            if($request->email){
          Mail::send('frontend.mail.new_booking', [
                'name' => $user->name,
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
            ], function ($message) use ($request,$place_email,$user) {
                   $email = [$request->email,$place_email->email,'nsnhotels@gmail.com'];
                $message->to($email, "{$user->name}")->subject('Booking from ' . $user->name);
            });
            }
        }
            # code...
        $this->sendBookingMsg($phone,$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type);
        $this->sendBookingMsg($place_email->phone_number,$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type);
        $this->sendBookingMsg('9958277997',$place->PlaceTrans->name,$start_date,$end_date,$numberofadult,$booking->amount,$place->address,$booking->payment_type);

// $ph=substr($phone,1);
$data="Hotel Name:$place->name, Check-in Date:$start_date 12pm onwards, Check-out Date:$end_date 11 am, Number of Rooms:$booking->number_of_room, Number of Adult:-$numberofadult, Number of Children:-$numberofchildren, Booking Amount:$booking->amount, Hotel Address:$place->address";
$map='map';
        $this->whatsapp_review('977'.$phone, $user->name);
       $res= $this->whatsapp_booking('977'.$phone,$request->name,$booking->booking_id,$data,$map);
        $this->whatsapp_booking('91'.$phone,$request->name,$booking->booking_id,$data,$map);
        $this->whatsapp_booking('91'.$place_email->phone_number,$request->name,$booking->booking_id,$data,$map);
        $this->whatsapp_booking('919958277997',$request->name,$booking->booking_id,$data,$map);

        return $this->success_response('Thanks for your hotel booking with NSN Hotels!',$booking);

    }


    public function Coupon(Request $request){
         // $response = array();
         $validator = Validator::make($request->all(), [
            'coupon' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            $errors=$validator->errors()->messages();
            $datas=[];
            foreach ($errors as $key => $value) {
                $datas[]=$value[0];
            }

            return $this->error_response($datas,'',400);
        }
        $cp=DB::table('coupon')->where('coupon_name',$request->coupon)->where('status',1)->first();
        if (!$cp) {
            return $this->error_response('Invalid coupon','',400);

        }
        if($request->price<$cp->coupon_min){
            return $this->error_response("Total amount must be greater or equal to $cp->coupon_min inorder to apply coupon",'',400);
        }
        return $this->success_response('Coupon applied successfully.',$cp);

    }



    public function updateAfterPayment(Request $request){

        $payment_id=$request->payment_id;
        $payment_mode='online';
        $is_paid='paid';
        $booking_id=$request->booking_id;
        $order_id=$request->razorpay_order_id;
     $booking=Booking::find($booking_id);
     $booking->payment_id=$payment_id;
     $booking->payment_type=$payment_mode;
     $booking->is_paid=$is_paid;
     $booking->payment_status=1;
     $booking->razorpay_order_id=$order_id;

$booking->save();
        return $this->success_response('Booking Updated',$booking);


    }




}

