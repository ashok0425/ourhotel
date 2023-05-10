<?php

namespace App\Http\Controllers\Admin;

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
    /**
     * Display a listing of the resource.
     */
public function __construct(Request $request)
{
    if($request->property_id){
        return Property::where(['user_id'=>1,'id'=>$request->property_id])->firstOrFail();
    }
}

    public function index(Request $request)
    { 
        $property_id=$request->property_id;
        if(isset($property_id)){
            $rooms=Room::query()->where('property_id',$property_id)->orderBy('id','desc')->get();
        }else{
            $property=Property::where('user_id',1)->pluck('id')->toArray();
            $rooms=Room::query()->whereIn('property_id',$property)->orderBy('id','desc')->get();
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
        $properties=Property::where('user_id',1)->get();
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
       $room->amenity=json_encode($request->amenity);
       $room->onepersonprice=$request->onepersonprice;
       $room->twopersonprice=$request->twopersonprice;
       $room->threepersonprice=$request->threepersonprice;
       $room->discount_percent=$request->discount_percent;
       $room->no_of_room=$request->no_of_room;
       $room->hourly_price=$request->hourlyprice;
       $path=$this->uploadImage($request->thumbnail);
       $room->thumbnail=$path;
       $room->gallery=json_encode($request->gallery);
       $room->jan=$request->jan;
       $room->feb=$request->feb;
       $room->march=$request->march;
       $room->april=$request->april;
       $room->may=$request->may;
       $room->jun=$request->jun;
       $room->july=$request->july;
       $room->aug=$request->aug;
       $room->sep=$request->sep;
       $room->oct=$request->oct;
       $room->nov=$request->nov;
       $room->dec=$request->dec;
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
       $room->amenity=json_encode($request->amenity);
       $room->onepersonprice=$request->onepersonprice;
       $room->twopersonprice=$request->twopersonprice;
       $room->threepersonprice=$request->threepersonprice;
       $room->discount_percent=$request->discount_percent;
       $room->no_of_room=$request->no_of_room;
       $room->hourly_price=$request->hourlyprice;
       $path=$this->uploadImage($request->thumbnail);
       $room->thumbnail=$path?$path:$room->thumbnail;
       if (isset($request->gallery)) {
        $gallery=json_decode($room->gallery);
        $gallery=array_merge($gallery,$request->gallery);
        $room->gallery=json_encode($gallery);
       }
       $room->jan=$request->jan;
       $room->feb=$request->feb;
       $room->march=$request->march;
       $room->april=$request->april;
       $room->may=$request->may;
       $room->jun=$request->jun;
       $room->july=$request->july;
       $room->aug=$request->aug;
       $room->sep=$request->sep;
       $room->oct=$request->oct;
       $room->nov=$request->nov;
       $room->dec=$request->dec;
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
