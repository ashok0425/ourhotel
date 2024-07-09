<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Corporate;
use App\Models\Enquiries;
use App\Models\Enquiry;
use App\Models\PropertyType;
use App\Models\ReferelMoney;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{


    public function becomePartner()
    {


        $countries  = State::all();
        $cities     = City::all();

        $place_types = PropertyType::query()
            ->get();

        $categories = Category::query()
            ->get();

        return view('frontend.place.become_partner', [
            'countries'   => $countries,
            'cities'      => $cities,
            'place_types' => $place_types,
            'categories'=>$categories
        ]);
    }


    public function becomePartnerStore(Request $request)
    {
        $request->validate(
            ['partner_name'=>'required',
            'partner_name'=>'required',
            'address'=>'required',
            'email'=>'required|unique:users,email',
            'phone_number'=>'required|unique:users,phone_number'
            ]
        );

      $enquiry=new Enquiry();
      $enquiry->type=2;
      $enquiry->data=$request->all();
      $enquiry->save();

    }



    public function refer()
    {
        $total = ReferelMoney::where('user_id', Auth::id())->sum('price');
        $referl_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 0)->sum('price');
        $used_money = ReferelMoney::where('user_id', Auth::id())->where('is_used', 1)->sum('price');

        return view('frontend.page.refer', [
            'referl_money' => $referl_money, 'used_money' => $used_money, 'total' => $total
        ]);
    }

    public function pageContact()
    {

        return view('frontend.page.contact');
    }

    public function corporate(Request $request)
    {

        return view('frontend.page.corporate');
    }


    public function corporateStore(Request $request)
    {
        $request->validate([
            'mobile'=>'required|unique:users,phone_number',
            'company'=>'required',
            'email'=>'required|unique:users,email'
        ]);
            $user = new User();
            $user->phone_number = $request->mobile;
            $user->name = $request->company;
            $user->email = $request->email;
            $user->save();

            $add = new Corporate();
            $add->name = $request->name;
            $add->user_id = $user->id;
            $add->address     = $request->address;
            $add->company_name     = $request->city;
            $add->save();


        $notification= array(
            'message'=>'Your query has been placed successfully. We will contact you soon!',
            'type'=>'success');
       return redirect()->route('corporate')->with($notification);
    }


    public function sendContact(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'phone'=>'required'
        ]);
        $enquiry = new Enquiry();
        $enquiry->type = 1;
        $enquiry->data = $request->all();
        $enquiry->save();
        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Thanks for contacting us.We will get back to you as soon as possible.',

        );
        session()->put('messege', 'dddd');
        return back()->with($notification);
    }


    public function subscribe(Request $request)
    {
$request->validate([
    'email'=>'required|email'
]);
        $enquiry = new Enquiry();
        $enquiry->data = ['email'=>$request->email];
        $enquiry->type = 3;
        $enquiry->save();
        if ($request->type == 0) {
            $notification = array(
                'alert-type' => 'success',
                'messege' => 'Thanks for for your query. we will get back to you as sson as possible',

            );

            return redirect()->back()->with($notification);
        }
        Mail::send('frontend.mail.sub', [
            'email' =>  $request->email,
        ], function ($message) use ($request) {
            $email = $request->email;
            $message->to($email, "{$email}")->from('noreply@nsnhotels.com')->subject('Thanks for subscribing ' . 'Nsn Hotels ');
        });

        $notification = array(
            'alert-type' => 'success',
            'messege' => 'Thanks for subscribing!',

        );

        return redirect()->back()->with($notification);
    }



}
