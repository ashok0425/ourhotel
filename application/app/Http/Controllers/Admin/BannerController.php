<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\State;
use Str;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners=Banner::query()->orderBy('id','desc')->get();
        return view('admin.banner.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:225',
            'thumbnail'=>'required',
        ]);
        $thumbnail=$this->uploadImage($request->thumbnail);
        $mobile_thumbnail=$this->uploadImage($request->mobile_thumbnail);

       $coupon=new Banner();
       $coupon->title=$request->title;
       $coupon->thumbnail=$thumbnail;
       $coupon->mobile_thumbnail=$mobile_thumbnail;
       $coupon->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Banner Create Sucessfully'
       );
       return redirect()->route('admin.banners.index')->with($notification);

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
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit',compact('banner'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title'=>'required|max:225',
            'thumbnail'=>'nullable|max:2048',
        ]);
        $thumbnail=$this->uploadImage($request->thumbnail);
        $mobile_thumbnail=$this->uploadImage($request->mobile_thumbnail);

       $banner->title=$request->title;
       $banner->thumbnail=$thumbnail!=null?$thumbnail:$banner->thumbnail;
       $banner->mobile_thumbnail=$mobile_thumbnail!=null?$mobile_thumbnail:$banner->mobile_thumbnail;
       $banner->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Banner Updated Sucessfully'
       );
       return redirect()->route('admin.banners.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
       $banner->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Banner Deleted Sucessfully'
       );
       return redirect()->route('admin.banners.index')->with($notification);
    }
}
