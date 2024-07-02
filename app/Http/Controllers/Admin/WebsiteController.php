<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Website;
use Str;
class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

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
    public function edit(Website $website)
    {
        return view('admin.website.edit',compact('website'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        $logo=$this->uploadImage($request->logo);
        $fev=$this->uploadImage($request->fev);
       $website->logo=$logo!=null?$logo:$website->logo;
       $website->fev=$fev!=null?$fev:$website->fev;
       $website->phone1=$request->phone1;
       $website->phone2=$request->phone2;
       $website->address1=$request->address1;
       $website->address2=$request->address2;
       $website->email1=$request->email1;
       $website->email2=$request->email2;
       $website->facebook=$request->facebook;
       $website->linkedin=$request->linkedin;
       $website->instagram=$request->instagram;
       $website->tiktok=$request->tiktok;
       $website->playstore=$request->playstore;
       $website->appstore=$request->appstore;
       $website->meta_keyword=$request->meta_keyword;
       $website->meta_title=$request->meta_title;
       $website->meta_description=$request->meta_description;
       $website->mobile_meta_keyword=$request->mobile_meta_keyword;
       $website->mobile_meta_title=$request->mobile_meta_title;
       $website->mobile_meta_description=$request->mobile_meta_description;
       $website->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Cms Updated Sucessfully'
       );
       return redirect()->route('admin.websites.edit',1)->with($notification);
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
