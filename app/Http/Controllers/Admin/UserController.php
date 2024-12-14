<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users=User::where('is_admin',0)
        ->when($request->is_partner,function($query) use ($request){
          $query->where('is_partner',1);
        })
        ->when($request->is_agent,function($query) use ($request){
            $query->where('is_agent',1)->limit(20);
        })
        ->when($request->is_user,function($query) use ($request){
          $query->where('is_partner',0)->where('is_agent',0)
          ->where('is_admin',0)->where('isSeoExpert',0);
        })
        ->when($request->status,function($query) use ($request){
            $query->where('status',$request->status);
        })
        ->when($request->keyword,function($query) use ($request){
            $query->where('name',$request->keyword)
            ->orwhere('email',$request->keyword)
            ->orwhere('phone_number',$request->keyword);
        })
        ->when($request->from&&$request->to,function($query) use ($request){
            $query->whereDate('created_at','>=',$request->from)->whereDate('created_at','<=',$request->to);
        })->paginate(20);
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone_number'=>'required|unique:users,phone_number',
            'email'=>'required|unique:users,email',
        ]);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone_number=$request->phone_number;
        if ($request->role==2) {
        $user->is_agent=1;
        }
        if ($request->role==3) {
            $user->is_partner=1;
            }

            if ($request->role==4) {
                $user->isSeoExpert=1;
                }

                $user->save();
                $notification=array(
                    'type'=>'success',
                     'message'=>'user profile updated Sucessfully'
                   );
                   return redirect()->route('admin.users.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user=User::with(['booking','property','referMoney'])->where('id',$user->id)->first();
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone_number=$request->phone_number;
        if ($request->role==2) {
        $user->is_agent=1;
        }
        if ($request->role==3) {
            $user->is_partner=1;
            }

            if ($request->role==4) {
                $user->isSeoExpert=1;
                }

                $user->save();
                $notification=array(
                    'type'=>'success',
                     'message'=>'user profile updated Sucessfully'
                   );
                   return redirect()->route('admin.users.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function status(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        $user->status=$request->status;
        $user->save();
        $notification=array(
            'type'=>'success',
             'message'=>'user status updated Sucessfully'
           );
           return redirect()->route('admin.users.index')->with($notification);
    }
}
