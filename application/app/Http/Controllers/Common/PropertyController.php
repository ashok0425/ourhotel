<?php

namespace App\Http\Controllers\Common;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\PropertyType;
use Str;
class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties=Property::query()->orderBy('id','desc')->get();
        return view('common.property.index',compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities=City::where('status',1)->get();
        $propertyTypes=PropertyType::where('status',1)->get();
        $amenities=Amenity::where('status',1)->get();

        return view('common.property.create',compact('cities','propertyTypes','amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'name'=>'required|max:225',
            'thumbnail'=>'required|max:2048',
            'address'=>'required',
            'latitude'=>'required',
            'latitude'=>'required',
            'price_range'=>'required',
            'description'=>'required',
        ]);
        $slug=Str::slug($request->name);
       $property=new Property;
       $property->name=$request->name;
       $property->city_id=$request->city;
       $property->user_id=1;
       $property->property_type_id=$request->propertyType;
       $property->slug=$slug;
       $property->status=$request->status;
       $property->description=$request->description;
       $property->amenity=json_encode($request->amenity);
       $property->longitude=$request->longitude;
       $property->latitude=$request->latitude;
       $property->address=$request->address;
       $property->price_range=$request->price_range;
       $property->rating=rand(1,5);
       $property->pet_friendly=$request->pet_friendly?$request->pet_friendly:0;
       $property->couple_friendly=$request->couple_friendly?$request->couple_friendly:0;
       $property->top_rated=$request->top_rated?$request->top_rated:0;
       $property->meta_keyword=$request->meta_keyword;
       $property->meta_title=$request->meta_title;
       $property->meta_description=$request->meta_description;
       $property->mobile_meta_keyword=$request->mobile_meta_keyword;
       $property->mobile_meta_title=$request->mobile_meta_title;
       $property->mobile_meta_description=$request->mobile_meta_description;
       $path=$this->uploadImage($request->thumbnail);
       $property->thumbnail=$path;
       $property->gallery=json_encode($request->gallery);
       $property->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Property Create Sucessfully'
       );
       return redirect()->route('admin.properties.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $cities=City::where('status',1)->get();
        $propertyTypes=PropertyType::where('status',1)->get();
        $amenities=Amenity::where('status',1)->get();
        return view('common.property.edit',compact('property','cities','propertyTypes','amenities'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name'=>'required|max:225',
            'address'=>'required',
            'latitude'=>'required',
            'latitude'=>'required',
            'price_range'=>'required',
            'description'=>'required',
        ]);
        $slug=Str::slug($request->name);
       $property->name=$request->name;
       $property->city_id=$request->city;
       $property->user_id=1;
       $property->property_type_id=$request->propertyType;
       $property->slug=$slug;
       $property->status=$request->status;
       $property->description=$request->description;
       $property->amenity=json_encode($request->amenity);
       $property->longitude=$request->longitude;
       $property->latitude=$request->latitude;
       $property->address=$request->address;
       $property->price_range=$request->price_range;
       $property->rating=rand(1,5);
       $property->pet_friendly=$request->pet_friendly?$request->pet_friendly:0;
       $property->couple_friendly=$request->couple_friendly?$request->couple_friendly:0;
       $property->top_rated=$request->top_rated?$request->top_rated:0;
       $property->meta_keyword=$request->meta_keyword;
       $property->meta_title=$request->meta_title;
       $property->meta_description=$request->meta_description;
       $property->mobile_meta_keyword=$request->mobile_meta_keyword;
       $property->mobile_meta_title=$request->mobile_meta_title;
       $property->mobile_meta_description=$request->mobile_meta_description;
       $path=$this->uploadImage($request->thumbnail);
       $property->thumbnail=$path?$path:$property->thumbnail;
       if (isset($request->gallery)) {
        $gallery=json_decode($property->gallery);
        $gallery=array_merge($gallery,$request->gallery);
        $property->gallery=json_encode($gallery);
       }
       $property->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Property Updated Sucessfully'
       );
       return redirect()->route('admin.properties.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
       $property->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Property Deleted Sucessfully'
       );
       return redirect()->route('admin.Propertys.index')->with($notification);
    }
}
