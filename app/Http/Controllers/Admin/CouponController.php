<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\State;
use Str;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons=Coupon::query()->orderBy('id','desc')->get();
        return view('admin.coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
            'coupon_value'=>'required',
        ]);
        $thumbnail=$this->uploadImage($request->thumbnail);
        $mobile_thumbnail=$this->uploadImage($request->mobile_thumbnail);

       $coupon=new Coupon;
       $coupon->coupon_name=$request->name;
       $coupon->coupon_percent=$request->coupon_value;
       $coupon->coupon_min=$request->coupon_min;
       $coupon->status=$request->status;
       $coupon->thumbnail=$thumbnail;
       $coupon->expired_at=$request->expired_at;
       $coupon->mobile_thumbnail=$mobile_thumbnail;
       $coupon->save();

       $notification=array(
        'type'=>'success',
         'message'=>'City Create Sucessfully'
       );
       return redirect()->route('admin.coupons.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(City $City)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit',compact('coupon'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'title'=>'required|max:225',
            'coupon_value'=>'required',
            'description'=>'required|max:2048',
        ]);
        $thumbnail=$this->uploadImage($request->thumbnail);
        $mobile_thumbnail=$this->uploadImage($request->mobile_thumbnail);
        $coupon->coupon_name=$request->name;
        $coupon->coupon_percent=$request->coupon_value;
        $coupon->coupon_min=$request->coupon_min;
        $coupon->status=$request->status;
        $coupon->expired_at=$request->expired_at;
       $coupon->thumbnail=$thumbnail!=null?$thumbnail:$coupon->thumbnail;
       $coupon->mobile_thumbnail=$mobile_thumbnail!=null?$mobile_thumbnail:$coupon->mobile_thumbnail;
       $coupon->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Coupon Updated Sucessfully'
       );
       return redirect()->route('admin.coupons.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
       $coupon->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Coupon Deleted Sucessfully'
       );
       return redirect()->route('admin.coupons.index')->with($notification);
    }
}
