<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);


        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $user=Auth::user();
            if ((!$user->is_admin||!$user->is_agent)&&!$user->status) {
                Auth::logout();
                return redirect()->back()->withErrors(['email'=>'You are not authorized to access this page']);
            }
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withErrors(['email'=>'Invalid email or password']);
    }



    public function dashboard(){
        if (Auth::user()->is_partner) {
            $pendingBooking=Booking::whereDate('booking_start',today())->where('status',2)->whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->count();
            $todayBooking=Booking::whereDate('created_at',today())->where('status',2)->whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->count();
            $allBooking=Booking::whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->count();
            $todayBookingAmount=Booking::whereDate('created_at',today())->whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->sum('final_amount');
            $allBookingAmount=Booking::whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->sum('final_amount');
            $bookings=Booking::whereDate('booking_start',today())->where('status',2)->whereHas('property',function($query){
                $query->where('owner_id',Auth::user()->id);
            })->limit(10)->get();

        }else{
            $pendingBooking=Booking::whereDate('booking_start',today())->where('status',2)->count();
            $todayBooking=Booking::whereDate('created_at',today())->where('status',2)->count();
            $allBooking=Booking::count();
            $todayBookingAmount=Booking::whereDate('created_at',today())->sum('final_amount');
            $allBookingAmount=Booking::sum('final_amount');
            $bookings=Booking::whereDate('booking_start',today())->where('status',2)->limit(10)->get();


        }

        return view('admin.dashboard',compact('pendingBooking','allBooking','todayBookingAmount','allBookingAmount','todayBooking','bookings'));
    }

    function logout(){
        Auth::logout();
        return redirect('/');
    }
}
