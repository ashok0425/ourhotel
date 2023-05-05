<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Str;
class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amenities=Amenity::query()->orderBy('id','desc')->get();
        return view('admin.amenity.index',compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.amenity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
            'thumbnail'=>'required|max:2048',
        ]);
        $path=$this->uploadImage($request->thumbnail);
       $amenity=new Amenity;
       $amenity->name=$request->name;
       $amenity->status=$request->status;
       $amenity->thumbnail=$path;
       $amenity->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Amenity Create Sucessfully'
       );
       return redirect()->route('admin.amenities.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(State $amenity)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amenity $amenity)
    {
        return view('admin.amenity.edit',compact('amenity'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name'=>'required|max:225',
            'thumbnail'=>'nullable|max:2048',
        ]);
        $path=$this->uploadImage($request->thumbnail);
        $amenity->thumbnail=$path?$path:$amenity->thumbnail;
       $amenity->name=$request->name;
       $amenity->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Amenity Updated Sucessfully'
       );
       return redirect()->route('admin.amenities.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity $amenity)
    {
       $amenity->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Amenity Deleted Sucessfully'
       );
       return redirect()->route('admin.amenities.index')->with($notification);
    }
}
