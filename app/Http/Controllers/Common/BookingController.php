<?php

namespace App\Http\Controllers\Common;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
          ->when(isset($request->status) && ($request->status||$request->status==0),function($query) use ($request){
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $pdf = Pdf::loadView('common.booking.print', ['booking_id'=>$booking_id]);
        // return $pdf;
      return $pdf->download("$booking_id|invoice.pdf");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $booking= Booking::findorFail($request->booking_id);

        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('user_id',Auth::user()->id)->where('id',$booking->id)->firstOrFail();
        }

        $booking->status=$request->status;
        $booking->save();
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
