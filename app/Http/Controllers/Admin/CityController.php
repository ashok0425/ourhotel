<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Str;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities=City::query()->orderBy('id','desc')->when($request->keyword,function($query) use ($request){
            $query->where('name','LIKE',"%$request->keyword%");
          })
          ->paginate(10);;
        return view('admin.city.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states=State::orderBy('id','desc')->get();
        return view('admin.city.create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
            'state'=>'required',
            'thumbnail'=>'required|max:2048',
        ]);
        $slug=Str::slug($request->name);
        $path=$this->uploadImage($request->thumbnail);
       $City=new City;
       $City->state_id=$request->state;
       $City->name=$request->name;
       $City->thumbnail=$path;
       $City->slug=$slug;
       $City->status=$request->status;
       $City->meta_keyword=$request->meta_keyword;
       $City->meta_title=$request->meta_title;
       $City->meta_description=$request->meta_description;
       $City->mobile_meta_keyword=$request->mobile_meta_keyword;
       $City->mobile_meta_title=$request->mobile_meta_title;
       $City->mobile_meta_description=$request->mobile_meta_description;
       $City->save();
       Cache::forget('popular_cities');
       $notification=array(
        'type'=>'success',
         'message'=>'City Create Sucessfully'
       );
       return redirect()->route('admin.cities.index')->with($notification);

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
    public function edit(City $city)
    {
        $states=State::orderBy('id','desc')->get();
        return view('admin.city.edit',compact('city','states'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name'=>'required|max:225',
            'thumbnail'=>'nullable|max:2048',
        ]);
        $slug=Str::slug($request->name);
        $path=$this->uploadImage($request->thumbnail);
       $city->name=$request->name;
       $city->slug=$slug;
       $city->thumbnail=$path?$path:$city->thumbnail;
       $city->state_id=$request->state;
       $city->status=$request->status;
       $city->meta_keyword=$request->meta_keyword;
       $city->meta_title=$request->meta_title;
       $city->meta_description=$request->meta_description;
       $city->mobile_meta_keyword=$request->mobile_meta_keyword;
       $city->mobile_meta_title=$request->mobile_meta_title;
       $city->mobile_meta_description=$request->mobile_meta_description;
       $city->save();
       Cache::forget('popular_cities');

       $notification=array(
        'type'=>'success',
         'message'=>'City Updated Sucessfully'
       );
       return redirect()->route('admin.cities.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
       $city->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'City Deleted Sucessfully'
       );
       return redirect()->route('admin.cities.index')->with($notification);
    }
}
