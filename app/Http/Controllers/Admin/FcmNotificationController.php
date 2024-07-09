<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendFcmNotification;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Faq;
use App\Models\FcmNotification;
use App\Models\User;
use Str;
class FcmNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fcms=FcmNotification::query()->orderBy('id','desc')->paginate(25);
        return view('admin.fcm.index',compact('fcms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fcm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'body'=>'required',
        ]);

       $users=User::whereNotNull('fcm_token')->orwhereNotNull('fcm_token')->pluck('id')->toArray();
       $notification=new FcmNotification();
       $notification->title=$request->title;
       $notification->body=$request->body;
       $notification->user_count=count($users);
       $notification->userIds=$users;
       $notification->save();

       dispatch(new SendFcmNotification($notification->id));

       $notification=array(
        'type'=>'success',
         'message'=>'Notification added to queue'
       );
       return redirect()->route('admin.fcms.index')->with($notification);

    }


}
