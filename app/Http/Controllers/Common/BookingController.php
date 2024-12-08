<?php

namespace App\Http\Controllers\Common;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\BookingCancelNotifyViaWP;
use App\Jobs\BookingNotifyViaMsg;
use App\Jobs\BookingNotifyViaWP;
use App\Jobs\CheckinNotifyViaWP;
use App\Models\Property;
use App\Notifications\SendBookingCancelEmail;
use App\Notifications\SendBookingEmail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page=$request->limit??15;
        $bookings=Booking::query()
           ->when(Auth::user()->is_partner,function($query) {
            $query->whereHas('property', function ($query) {
                $query->where('owner_id',Auth::user()->id );
            });
           })
           ->when($request->keyword,function($query) use ($request){
             $query->where('name','LIKE',"%$request->keyword%")->orwhere('phone_number',"%$request->keyword%")->orwhere('email',"%$request->keyword%");
          })
          ->when(isset($request->status),function($query) use ($request){
             $query->where('status',$request->status);
          })
          ->when($request->from&&$request->to,function($query) use ($request){
             $query->whereDate('created_at','>=',$request->from)->whereDate('created_at','<=',$request->to);
         })
          ->latest()->paginate($page);

        return view('common.booking.index',compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($property_id=null)
    {
        return  view('common.booking.create', compact('property_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'phone' => 'required'
        ]);

        $user = User::updateOrCreate(
            ['phone_number' => $request->phone],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('Nsn@' . rand(1, 99999999))
            ]
        );

        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->property_id = $request->property_id ?? 0;
        $booking->booking_start = $request['check_in'];
        $booking->booking_id = Booking::getBookingId();
        $booking->booking_end = $request['check_out'];
        $booking->no_of_room = $request['rooms'];
        $booking->no_of_adult = $request['adult'];
        $booking->no_of_child = $request['children'];
        $booking->final_amount = $request['price'];
        $booking->total_price = $request['price'];
        $booking->payment_type = $request['payment_type'];
        $booking->room_type = $request['room_type'];
        $booking->booking_type = $request['booking_type'];
        $booking->uuid = Str::uuid();
        $booking->is_paid  = $request->is_paid ? 1 : 0;
        $booking->booked_by  = Auth::user()?->id ?? 1;
        $booking->status  = 2;
        $booking->name = $request->name;
        $booking->phone_number = $request->phone;
        $booking->hotel_data=[
            'name'=>$request->hotel_name,
            'address'=>$request->hotel_address,
            'phone_number'=>$request->hotel_phone
        ];

        $booking->save();

        dispatch(new BookingNotifyViaWP($booking->id));
        dispatch(new BookingNotifyViaMsg($booking->id));
        if($booking->email){
            Notification::route('mail', $booking->email)->notify(new SendBookingEmail($booking->booking_id));
        }
        $notification = array(
            'type' => 'success',
            'message' => 'Booking create successfully'
        );



        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking=Booking::with(['user','room','property'])->where('booking_id',$booking->booking_id)->first();

        return view('common.booking.show',compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
      return view('common.booking.edit',compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Booking $booking)
    {

        $booking = new Booking();
        $booking->booking_start = $request['check_in'];
        $booking->booking_end = $request['check_out'];
        $booking->no_of_room = $request['rooms'];
        $booking->no_of_adult = $request['adult'];
        $booking->no_of_child = $request['children'];
        $booking->final_amount = $request['price'];
        $booking->total_price = $request['price'];
        $booking->payment_type = $request['payment_type'];
        $booking->room_type = $request['room_type'];
        $booking->booking_type = $request['booking_type'];
        $booking->status  = 2;
        $booking->name = $request->name;
        $booking->phone_number = $request->phone;
        $booking->hotel_data=[
            'name'=>$request->hotel_name,
            'address'=>$request->hotel_address,
            'phone_number'=>$request->hotel_phone
        ];

        $booking->save();

        dispatch(new BookingNotifyViaWP($booking->id));
        dispatch(new BookingNotifyViaMsg($booking->id));
        if($booking->email){
            Notification::route('mail', $booking->email)->notify(new SendBookingEmail($booking->booking_id));
        }
        $notification = array(
            'type' => 'success',
            'message' => 'Booking update successfully'
        );

           return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function download($booking_id)
    {

       $pdf = Pdf::loadView('common.booking.print', ['booking_id'=>$booking_id]);
        // return $pdf;
      return $pdf->download("$booking_id|invoice.pdf");
    }

    public function updateStatus(Request $request){

        $booking= Booking::findorFail($request->booking_id);

        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('user_id',Auth::user()->id)->where('id',$booking->id)->firstOrFail();
        }

        $booking->status=$request->status;
        $booking->save();
        if($request->status==0){
            dispatch(new BookingCancelNotifyViaWP($booking->id));
            if ($booking->email) {
                Notification::route('mail', $booking->email)->notify(new SendBookingCancelEmail($booking));
            }
        }
        if($request->status==1){
            dispatch(new CheckinNotifyViaWP($booking->id));
        }
        $notification=array(
            'type'=>'success',
             'message'=>'Booking satus updated Sucessfully'
           );
           return redirect()->back()->with($notification);
    }
}
