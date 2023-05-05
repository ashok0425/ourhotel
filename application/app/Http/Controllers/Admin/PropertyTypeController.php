<?php

namespace App\Http\Controllers\Admin;

use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;
class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyTypes=PropertyType::query()->orderBy('id','desc')->get();
        return view('admin.property_type.index',compact('propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.property_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);
        
       $propertyType=new PropertyType;
       $propertyType->name=$request->name;
       $propertyType->slug=$slug;
       $propertyType->status=$request->status;
       $propertyType->meta_keyword=$request->meta_keyword;
       $propertyType->meta_title=$request->meta_title;
       $propertyType->meta_description=$request->meta_description;
       $propertyType->mobile_meta_keyword=$request->mobile_meta_keyword;
       $propertyType->mobile_meta_title=$request->mobile_meta_title;
       $propertyType->mobile_meta_description=$request->mobile_meta_description;
       $propertyType->save();
       $notification=array(
        'type'=>'success',
         'message'=>'PropertyType Create Sucessfully'
       );
       return redirect()->route('admin.propertyTypes.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyType $propertyType)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyType $propertyType)
    {
        return view('admin.property_type.edit',compact('propertyType'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyType $propertyType)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);
        
       $propertyType->name=$request->name;
       $propertyType->slug=$slug;
       $propertyType->status=$request->status;
       $propertyType->meta_keyword=$request->meta_keyword;
       $propertyType->meta_title=$request->meta_title;
       $propertyType->meta_description=$request->meta_description;
       $propertyType->mobile_meta_keyword=$request->mobile_meta_keyword;
       $propertyType->mobile_meta_title=$request->mobile_meta_title;
       $propertyType->mobile_meta_description=$request->mobile_meta_description;

       $propertyType->save();

       $notification=array(
        'type'=>'success',
         'message'=>'PropertyType Updated Sucessfully'
       );
       return redirect()->route('admin.propertyTypes.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $propertyType)
    {
       $propertyType->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'PropertyType Deleted Sucessfully'
       );
       return redirect()->route('admin.propertyTypes.index')->with($notification);
    }
}
