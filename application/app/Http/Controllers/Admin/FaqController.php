<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Faq;
use Str;
class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs=Faq::query()->orderBy('id','desc')->get();
        return view('admin.faq.index',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);
       $faq=new Faq;
       $faq->question=$request->question;
       $faq->status=$request->status;
       $faq->answer=$request->answer;
       $faq->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Faq Create Sucessfully'
       );
       return redirect()->route('admin.faqs.index')->with($notification);

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
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit',compact('faq'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);
       $faq->question=$request->question;
       $faq->status=$request->status;
       $faq->answer=$request->answer;
       $faq->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Faq Updated Sucessfully'
       );
       return redirect()->route('admin.faqs.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
       $faq->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Faq Deleted Sucessfully'
       );
       return redirect()->route('admin.faqs.index')->with($notification);
    }
}
