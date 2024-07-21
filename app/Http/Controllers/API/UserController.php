<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\BookingCancelNotifyViaWP;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\FcmNotification;
use App\Models\Place;
use App\Models\ReferelMoney;
use App\Models\ReferPrice;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Wishlist;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $booking = Booking::join('properties','properties.id','bookings.property_id')->where('bookings.user_id',$user->id)->select('bookings.*','properties.name as hotel_name','properties.thumbnail as thumbnail','properties.address as address','final_amount as TotalPrice','discount as discountPrice', DB::raw('CAST(total_price AS CHAR) as amount'))->get();
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
        dispatch(new BookingCancelNotifyViaWP($booking->id));
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


    public function help(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone'=>'required',
            'message'=>'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);

        }

        $enquiry = new Enquiry();
        $enquiry->type = 1;
        $enquiry->data = $request->all();
        $enquiry->save();

        return $this->success_response('Your query has been placed successfully.We will get back to you soon.','');
     }

     public function getRefer(){
        $refers = ReferelMoney::where('user_id',Auth::user()->id)->latest()->get();
        $refers->map(function($refer){
            return [
                'id' => $refer->id,
                'price' => $refer->price,
                'user_id' => $refer->user_id,
                'referel_type' => $refer->referel_type,
                'is_used' => $refer->is_used,
                'created_at' => $refer->created_at,
                'coupon_code' => 'REFER'.$refer->price.$refer->id.str_pad(rand(1,9),2,0),
            ];
        });
        return $this->success_response('refer money fetched',$refers);
     }

     public function getTestimonial(){
        $feedbacks = Testimonial::with('property')->where('user_id',Auth::user()->id)->latest()->get();
        $feedbacks->map(function($feedback){
          return  [
            'id'=>$feedback->id,
            'name'=>$feedback->name??$feedback->user->name??'Guest',
            'thumbnail'=>$feedback->thumbnail??$feedback->user->profile_photo_path??null,
            'feedback'=>$feedback->feedback,
            'rating'=>$feedback->rating,
            'hotel_name'=>$feedback->property->name??'',
            'hotel_id'=>$feedback->property_id??'',

           ];
        });
        return $this->success_response('Feedback fetched',$feedbacks);
     }

     public function storeTestimonial(Request $request){
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'feedback' => 'nullable',
            'property_id'=>'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);

        }
       $feedback=new Testimonial();
       $feedback->user_id=Auth::user()->id;
       $feedback->property_id=$request->property_id;
       $feedback->name=Auth::user()->name;
       $feedback->feedback=$request->comment;
       $feedback->rating=$request->star;
       $feedback->save();

        return $this->success_response('Thank you for your feedback',$feedback);
     }

}
