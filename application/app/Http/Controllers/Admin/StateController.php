<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states=State::query()->orderBy('id','desc')->get();
        return view('admin.state.index',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.state.create');
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
        
       $state=new State;
       $state->name=$request->name;
       $state->slug=$slug;
       $state->status=$request->status;
       $state->meta_keyword=$request->meta_keyword;
       $state->meta_title=$request->meta_title;
       $state->meta_description=$request->meta_description;
       $state->mobile_meta_keyword=$request->mobile_meta_keyword;
       $state->mobile_meta_title=$request->mobile_meta_title;
       $state->mobile_meta_description=$request->mobile_meta_description;

       $state->save();

       $notification=array(
        'type'=>'success',
         'message'=>'State Create Sucessfully'
       );
       return redirect()->route('admin.states.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        return view('admin.state.edit',compact('state'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);
        
       $state->name=$request->name;
       $state->slug=$slug;
       $state->status=$request->status;
       $state->meta_keyword=$request->meta_keyword;
       $state->meta_title=$request->meta_title;
       $state->meta_description=$request->meta_description;
       $state->mobile_meta_keyword=$request->mobile_meta_keyword;
       $state->mobile_meta_title=$request->mobile_meta_title;
       $state->mobile_meta_description=$request->mobile_meta_description;

       $state->save();

       $notification=array(
        'type'=>'success',
         'message'=>'State Updated Sucessfully'
       );
       return redirect()->route('admin.states.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
       $state->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'State Deleted Sucessfully'
       );
       return redirect()->route('admin.states.index')->with($notification);
    }
}
