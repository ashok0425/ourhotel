<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendFcmNotification;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\FcmNotification;
use App\Models\User;
use Str;
class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
             $type=$request->type;
            $enquries=Enquiry::query()->orderBy('id','desc')->where('type',$type)->paginate(25);
            return view('admin.enquiry.index',compact('enquries','type'));

    }



}
