<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Faq;
use App\Models\Seo;
use Illuminate\Support\Facades\Auth;
use Str;
class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        if(!Auth::user()->isSeoExpert){
            abort(403);
        }
        $seos=Seo::query()->orderBy('id','desc')->get();
        return view('admin.seo.index',compact('seos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->isSeoExpert){
            abort(403);
        }
        return view('admin.seo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->isSeoExpert){
            abort(403);
        }
       $seo=new Seo;
       $seo->title=$request->title;
       $seo->description=$request->description;
       $seo->keyword=$request->keyword;
       $seo->footer_content=$request->footer_content;
       $seo->page=$request->page;
       $seo->path=$request->path;
       $seo->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Seo Create Sucessfully'
       );
       return redirect()->route('seos.index')->with($notification);

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
    public function edit(Seo $seo)
    {
        if(!Auth::user()->isSeoExpert){
            abort(403);
        }

        return view('admin.seo.edit',compact('seo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seo $seo)
    {
        if(!Auth::user()->isSeoExpert){
            abort(403);
        }
        $seo->title=$request->title;
        $seo->description=$request->description;
        $seo->keyword=$request->keyword;
        $seo->footer_content=$request->footer_content;
        $seo->page=$request->page;
        $seo->path=$request->path;
        $seo->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Seo Updated Sucessfully'
       );
       return redirect()->route('seos.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seo $seo)
    {
        if(!Auth::user()->isSeoExpert){
            abort(403);
        }
       $seo->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Seo Deleted Sucessfully'
       );
       return redirect()->route('seos.index')->with($notification);
    }
}
