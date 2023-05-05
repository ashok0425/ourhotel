<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use Str;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities=Location::query()->orderBy('id','desc')->get();
        return view('admin.location.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities=City::orderBy('id','desc')->get();
        return view('admin.location.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
            'city'=>'required',
        ]);
        $slug=Str::slug($request->name);
        
       $location=new Location;
       $location->city_id=$request->city;
       $location->latitude=$request->latitude;
       $location->longitude=$request->longitude;
       $location->name=$request->name;
       $location->slug=$slug;
       $location->status=$request->status;
       $location->meta_keyword=$request->meta_keyword;
       $location->meta_title=$request->meta_title;
       $location->meta_description=$request->meta_description;
       $location->mobile_meta_keyword=$request->mobile_meta_keyword;
       $location->mobile_meta_title=$request->mobile_meta_title;
       $location->mobile_meta_description=$request->mobile_meta_description;
       $location->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Location Create Sucessfully'
       );
       return redirect()->route('admin.locations.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(City $location)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $cities=City::orderBy('id','desc')->get();
        return view('admin.location.edit',compact('location','cities'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);
        
       $location->name=$request->name;
       $location->city_id=$request->city;
       $location->latitude=$request->latitude;
       $location->longitude=$request->longitude;
       $location->slug=$slug;
       $location->status=$request->status;
       $location->meta_keyword=$request->meta_keyword;
       $location->meta_title=$request->meta_title;
       $location->meta_description=$request->meta_description;
       $location->mobile_meta_keyword=$request->mobile_meta_keyword;
       $location->mobile_meta_title=$request->mobile_meta_title;
       $location->mobile_meta_description=$request->mobile_meta_description;
       $location->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Location Updated Sucessfully'
       );
       return redirect()->route('admin.locations.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
       $location->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Location Deleted Sucessfully'
       );
       return redirect()->route('admin.locations.index')->with($notification);
    }
}
