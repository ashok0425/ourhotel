<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\BookingCancelNotifyViaWP;
use App\Jobs\BookingNotifyViaWP;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index()
    {
        // Get list places
        $bookings = Booking::query()
            ->with('user')
            ->with('property')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.user.user_my_place', [
            'bookings' => $bookings,
        ]);
    }

     public function cancelBooking(Request $request) {

        $request->validate([
            'id'=>'required',
            'reason'=>'required',
        ]);
         $booking = Booking::where('id',$request->id)->where('user_id',Auth::user()->id)->firstorFail();

        $email = $booking->email;
        $name = $booking->name;
        // $message =  "Your hotel booking  Cancel successfully";
        //              Mail::send('frontend.mail.cancal_booking', [
        //         'name' => $booking->name,
        //         'email' =>  $booking->email,
        //         'booking_id' =>  $booking->booking_id,
        //         'phone' => $booking->phone_number,
        //         'booking_at' => $booking->created_at
        //     ], function ($message) use ($booking) {
        //           $email = $booking->email;
        // $name = $booking->name;
        //         $message->to($email, "{$name}")->subject('Booking from ' . $name);
        //     });
         $booking->status = 0;
         $booking->cancel_reason = $request->reason;

         $booking->save();

         dispatch(new BookingCancelNotifyViaWP($booking->id));

         return back()->with('success', 'Hotel Cancel successfully!');
     }


    public function loadDetail($id){
        $booking = Booking::query()
        ->with('user')
        ->with('place')
        ->where('user_id', Auth::id())
        ->where('id',$id)
        ->orderBy('created_at', 'desc')
        ->first();

        return view('frontend.user.bookingdetail',compact('booking'));
    }




    public function recipt(Request $request)
    {
            $booking = Booking::with('user','property')->where('uuid',$request->uuid)->firstOrFail();
        return view('frontend.place.modal_booking_detail', compact('booking'));
    }
}
