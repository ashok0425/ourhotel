<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

     public function cancelBooking($id) {
         $model = Booking::findOrfail($id);
         $mm = Booking::where('id',$id)->first();
        //  dd($mm);
        $email = $mm->email;
        $name = $mm->name;
        // $message =  "Your hotel booking  Cancel successfully";
        //              Mail::send('frontend.mail.cancal_booking', [
        //         'name' => $mm->name,
        //         'email' =>  $mm->email,
        //         'booking_id' =>  $mm->booking_id,
        //         'phone' => $mm->phone_number,
        //         'booking_at' => $mm->created_at
        //     ], function ($message) use ($mm) {
        //           $email = $mm->email;
        // $name = $mm->name;
        //         $message->to($email, "{$name}")->subject('Booking from ' . $name);
        //     });
         $model->status = 0;
         $model->save();

        $res=$this->whatsapp_cancel('91'.$mm->phone_number, $mm->name?$mm->name:"Customer",$mm->booking_id);
         $this->whatsapp_cancel('919958277997', $mm->name,$mm->booking_id);
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
