<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{



    public function index(){
        $reviews=Testimonial::where('user_id',Auth::user()->id)->latest()->paginate(10);
        return view('frontend.user.user_my_review',compact('reviews'));
    }


    public function store(Request $request){

        $request->validate([
            'star'=>'required|integer',
            'comment'=>'required',
            'property_id'=>'required',
        ]);
        $booking=Booking::where('property_id',$request->property_id)->where('user_id',Auth::user()->id)->first();
        if(!$booking){
            abort(403);
        }
       $review=new Testimonial();
       $review->user_id=Auth::user()->id;
       $review->property_id=$request->property_id;
       $review->name=Auth::user()->name;
       $review->feedback=$request->comment;
       $review->rating=$request->star;
       $review->save();

       $notification=array(
        'alert-type'=>'success',
        'messege'=>'Thank you for your feedback.',

     );
    return redirect()->back()->with($notification);
        }




    // public function store(Request $request){
    //     $request->validate([
    //         'star'=>'required|integer',
    //         'comment'=>'required',
    //         'property_id'=>'required',
    //     ]);
    //    $review=new Testimonial();
    //    $review->user_id=Auth::user()->id;
    //    $review->property_id=$request->property_id;
    //    $review->name=Auth::user()->name;
    //    $review->feedback=$request->comment;
    //    $review->rating=$request->star;
    //    $review->save();

    //    $notification=array(
    //     'alert-type'=>'success',
    //     'messege'=>'Thank you for your feedback.',

    //  );
    // return redirect()->back()->with($notification);
    //     }

}
