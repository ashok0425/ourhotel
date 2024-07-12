<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\BookingNotifyViaMsg;
use App\Jobs\BookingNotifyViaWP;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Property;
use App\Models\Room;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'place_id' => 'required',
            'numbber_of_adult' => 'required',
            'numbber_of_children' => 'required',
            'booking_start' => 'required',
            'booking_end' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'message' => 'nullable',
            'payment_type' => 'required',
            'amount'    =>  'required',
            'discountPrice' => 'nullable',
            'is_hourly' => 'nullable',
            'TotalPrice' => 'required',
            'tax' => 'required',
            'number_of_room' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);
        }

        $room = Room::find($request['place_id']);
        $date1 = Carbon::parse($request->booking_start);
        $date2 = Carbon::parse($request->booking_end);

        $differenceInDays = $date1->diffInDays($date2);
        $params = [
            'room_id' => $room->id,
            'no_of_room' => $request->number_of_room,
            'no_of_adult' => $request->numbber_of_adult,
            'days' => $differenceInDays,
            'hourly' => $request->is_hourly,
            'coupon' => $request->coupon,
        ];

        $prices = getFinalPrice(new Request($params));
        $price=$prices['subtotal'];
        $final_price=$prices['total'];
        $discount=$prices['discount'];
        $tax=$prices['tax'];


        $property = $room->property;

        $booking = new Booking();
        $booking->user_id = Auth::user()->id;
        $booking->property_id = $property->id;
        $booking->uuid = Str::uuid();
        $booking->booking_id = Booking::getBookingId();
        $booking->booking_start = $request['booking_start'];
        $booking->booking_end = $request['booking_end'];
        $booking->no_of_room = $request['number_of_room'];
        $booking->no_of_adult = $request['numbber_of_adult'];
        $booking->final_amount = $final_price;
        $booking->total_price = $price;
        $booking->discount = $discount;
        $booking->coupon_code = $request->coupon;
        $booking->tax = $tax;
        $booking->payment_type = $request['payment_type'];
        $booking->room_type = $room->name;
        $booking->booking_type = $request->is_hourly == true ? 'Hourly' : 'Day';
        $booking->is_paid  = $request->is_paid ? 1 : 0;
        $booking->booked_by  = Auth::user()->id;
        $booking->status  = 2;
        $booking->channel = 'App';
        $booking->early_reason     = $request->message;
        $booking->no_of_night     = $differenceInDays;
        $booking->name = $request->name ?? Auth::user()->name;
        $booking->email = $request->email;
        $booking->phone_number = $request->phone_number;
        $booking->save();
        dispatch(new BookingNotifyViaWP($booking->id));
        dispatch(new BookingNotifyViaMsg($booking->id));
        return $this->success_response('Thanks for your hotel booking with NSN Hotels!', $booking);
    }


    public function Coupon(Request $request)
    {
        // $response = array();
        $validator = Validator::make($request->all(), [
            'coupon' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }

            return $this->error_response($datas, '', 400);
        }
        $cp = DB::table('coupons')->where('coupon_name', $request->coupon)->where('status', 1)->first();

        if (!$cp) {
            return $this->error_response('Invalid coupon', '', 400);
        }

        if ($request->price < $cp->coupon_min) {
            return $this->error_response("Total amount must be greater or equal to $cp->coupon_min inorder to apply coupon", '', 400);
        }
        return $this->success_response('Coupon applied successfully.', $cp);
    }



    public function updateAfterPayment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'payment_id' => 'required',
            'order_id'=>'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }

            return $this->error_response($datas, '', 400);
        }

        $payment_id = $request->payment_id;
        $payment_mode = 'online';
        $booking_id = $request->booking_id;
        $order_id = $request->razorpay_order_id;
        $booking = Booking::find($booking_id);
        $booking->payment_id = $payment_id;
        $booking->payment_type = $payment_mode;
        $booking->is_paid = 1;
        $booking->razorpay_order_id = $order_id;
        $booking->save();
        return $this->success_response('Booking Updated', $booking);
    }



    function getRoomPrice(Request $request)
    {
        $data=getFinalPrice($request);
        return $this->success_response('Booking Updated', $data);
    }
}
