<?php

namespace App\Http\Controllers\Common;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\PropertyType;
use App\Models\Room;
use Str;
class RoomController extends Controller
{


    public function index(Request $request)
    {
        $property_id=$request->property_id;
        if(isset($property_id)){
            $rooms=Room::query()->where('property_id',$property_id)->orderBy('id','desc')->paginate(15);
        }else{
            $rooms=Room::query()->orderBy('id','desc')->paginate(15);
        }

        return view('admin.room.index',compact('rooms','property_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $property_id=$request->property_id;
        $amenities=Amenity::where('status',1)->get();
        $properties=Property::all();
        return view('admin.room.create',compact('property_id','amenities','properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
            'thumbnail'=>'required|mimes:png,jpeg,jp,webp,gif|max:2048',
            'onepersonprice'=>'required|integer',
            'hourlyprice'=>'nullable|integer',
            'discount_percent'=>'nullable|integer',
            'no_of_room'=>'required',
            'property_id'=>'required'
        ]);
       $room=new Room;
       $room->name=$request->name;
       $room->property_id=$request->property_id;
       $room->status=$request->status;
       $room->amenity=$request->amenity;
       $room->onepersonprice=$request->onepersonprice;
       $room->twopersonprice=$request->twopersonprice;
       $room->threepersonprice=$request->threepersonprice;
       $room->discount_percent=$request->discount_percent;
       $room->no_of_room=$request->no_of_room;
       $room->hourlyprice=$request->hourlyprice;
       $path=$this->uploadImage($request->thumbnail);
       $room->thumbnail=$path;
       $room->gallery=$request->gallery;
       $room->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Room Create Sucessfully'
       );
       return redirect()->route('admin.rooms.index',['property_id'=>$request->property_id])->with($notification);

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
    public function edit(Request $request,Room $room)
    {
        $amenities=Amenity::where('status',1)->get();
        return view('admin.room.edit',compact('room','amenities'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Room $room)
    {
        $request->validate([
            'name'=>'required|max:225',
            'onepersonprice'=>'required',
            'no_of_room'=>'required',
        ]);
       $room->name=$request->name;
       $room->status=$request->status;
       $room->amenity=$request->amenity;
       $room->onepersonprice=$request->onepersonprice;
       $room->twopersonprice=$request->twopersonprice;
       $room->threepersonprice=$request->threepersonprice;
       $room->discount_percent=$request->discount_percent;
       $room->no_of_room=$request->no_of_room;
       $room->hourlyprice=$request->hourlyprice;
       $path=$this->uploadImage($request->thumbnail);
       $room->thumbnail=$path?$path:$room->thumbnail;
       if (isset($request->gallery)) {
        $gallery=$room->gallery;
        $gallery=array_merge($gallery,$request->gallery);
        $room->gallery=$gallery;
       }

       $room->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Room updated Sucessfully'
       );

       return redirect()->route('admin.rooms.index',['property_id'=>$request->property_id])->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        Property::where(['user_id'=>1,'id'=>$room->property_id])->firstOrFail();
       $room->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Room Deleted Sucessfully'
       );
       return redirect()->route('admin.rooms.index')->with($notification);
    }
}
