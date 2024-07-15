<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\BookingCancelNotifyViaWP;
use App\Jobs\BookingNotifyViaMsg;
use App\Jobs\BookingNotifyViaWP;
use App\Jobs\CheckinNotifyViaWP;
use App\Models\TourBooking;
use App\Models\User;
use App\Service\InteraktService;
use Barryvdh\DomPDF\Facade\Pdf;

class TourBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page=$request->limit??20;
        $bookings=TourBooking::query()->when($request->keyword,function($query) use ($request){
             $query->where('name','LIKE',"%$request->keyword%")->orwhere('phone_number',"%$request->keyword%")->orwhere('email',"%$request->keyword%");
          })
          ->when(isset($request->status) && ($request->status||$request->status==0),function($query) use ($request){
             $query->where('status',$request->status);
          })
          ->when($request->from&&$request->to,function($query) use ($request){
             $query->whereDate('created_at','>=',$request->from)->whereDate('created_at','<=',$request->to);
         })
          ->latest()->paginate($page);

        return view('admin.tour_booking.index',compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tour_booking.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'tour_name'=>'required',
            'price'=>'required'
        ]);

        $user = User::updateOrCreate(
            ['phone_number' => $request->phone],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('Nsn@' . rand(1, 99999999))
            ]
        );


        $booking = new TourBooking();
        $booking->name = $request->name;
        $booking->tour_name = $request->tour_name;
        $booking->phone_number = $request->phone;
        $booking->user_id = $user->id;
        $booking->start_date = $request['check_in'];
        $booking->booking_id = TourBooking::getBookingId();
        $booking->end_date = $request['check_out'];
        $booking->no_of_adult = $request['adult'];
        $booking->amount = $request['price'];
        $booking->paid_amount = $request['price'];
        $booking->payment_type = $request['payment_type'];
        $booking->remark = $request['remark'];

        $booking->status  = 0;


        $booking->save();
        $data="Tour Name:$request->tour_name, Start Date:$request->check_in, End Date :$booking->check_out, Number of Adult:-$request->adult, Number of Children:$request->children, Booking Amount:$booking->price";

      $wpService=new InteraktService();
      $wpService->sendBookingMsg('91'.$request->phone,$request->name,$booking->booking_id,$data);
      $wpService->sendBookingMsg('919958277997',$request->name,$booking->booking_id,$data);
      $wpService->sendReviewMsg('91'.$request->phone,$request->name,$booking->booking_id,$data);


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
        $booking_id=$booking->booking_id;
        // return view('common.booking.print', ['booking_id'=>$booking_id]);

        $pdf = Pdf::loadView('common.booking.print', ['booking_id'=>$booking_id]);
        // return $pdf;
      return $pdf->download("$booking_id|invoice.pdf");
        // return view('common.booking.print',compact('booking_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $booking= TourBooking::findorFail($request->booking_id);
        $booking->status=$request->status;
        $booking->save();

        // if($request->status==0){
        //     dispatch(new BookingCancelNotifyViaWP($booking->id));
        // }
        // if($request->status==1){
        //     dispatch(new CheckinNotifyViaWP($booking->id));
        // }
        $notification=array(
            'type'=>'success',
             'message'=>'Booking satus updated Sucessfully'
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
}
