<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Astrotomic\Translatable\Validation\RuleFactory;
use App\Models\ReferPrice;
use App\Models\ReferelMoney;

class ReferPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refers = ReferPrice::get();
        return view('admin.referel.index',compact('refers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $refer=ReferPrice::where('id',$id)->first();
        return view('admin.referel.edit',compact('refer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$referprice)
    {
        $data = $this->validate($request, [
            'share_price' => 'required',
            'join_price' => 'required',
            'refer_content' => 'nullable',
        ]);

        $referprice = ReferPrice::find($referprice);
        $referprice->join_price=$request->join_price;
        $referprice->share_price=$request->share_price;
        $referprice->refer_content=$request->refer_content;
        $referprice->save();
        $notification=array(
            'type'=>'success',
             'message'=>'Refer price updated Sucessfully'
           );
           return redirect()->route('admin.refer_prices.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function referMoney()
    {
        $referels = ReferelMoney::latest()->get();
        return view('admin.referel.refer_money',compact('referels'));
    }
}
