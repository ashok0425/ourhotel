<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ReferelMoney;
use App\Notifications\sendOtp as SendotpNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

	public function register(Request $request)
	{

        // $response = array();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|unique:users,phone_number'
        ]);

        if ($validator->fails()) {
            $errors=$validator->errors()->messages();
            $datas=[];
            foreach ($errors as $key => $value) {
                $datas[]=$value[0];
            }

            return $this->error_response($datas,'',400);
        }

        $input = $request->all();

            $user=User::where('phone_number', $input['phone'])->first();
            if ($user) {
           return $this->error_response('User already register form this number.Procced to login','',400);
            }

            $otp=str_pad(rand(1,1000000),6,'0');
            $user = new User;
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->phone_number = $input['phone'];
            $user->password = bcrypt(123456);
            $user->otp = $otp;
            $user->save();

          if($request->referral_code){
            $user::HandleRefer($request->referral_code,$user->id);
             }

             return $this->success_response('Register succesfully.');

	}



    public function loginCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required'
        ]);

        if ($validator->fails()) {
            $errors=$validator->errors()->messages();
            $datas=[];
            foreach ($errors as $key => $value) {
                $datas[]=$value[0];
            }
            return $this->error_response($datas,'',400);

        }

        $email= (int) $request->mobile;
      if($email==0&&filter_var( $email, FILTER_VALIDATE_EMAIL)){

            $user=User::where('email',$email)->where('email','!=',null)->first();
            $otp=str_pad(rand(1,1000000),6,'0');
          if(!$user)
          {
              $user=new User();
              $user->name = $request['name'];
              $user->email = $request['mobile'];
              $user->phone_number ="9813".rand(1,80000000);
              $user->password = bcrypt(123456);
              $user->otp = $otp;
              $user->save();
          }
             $user->otp = $otp;
              $user->save();
              Notification::route('mail',$user->email)->notify(new SendotpNotification($otp));
            return $this->success_response("We have sent an otp at your Email address.,$otp");
        }
        $customer=User::where('phone_number', $request->mobile)->first();
        if(!$customer)
        {
            return $this->error_response('We could not find the customer associated with that mobile number.','',400);
        }
        else
        {
              if($customer->status){
              dispatch(new SendOtp('91',$request->mobile));
                return $this->success_response('We have sent an otp at your registered mobile number.');
            }
            return $this->error_response('Invalid Credientials','',400);

        }
    }



    public function getLogin(Request $request) {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'otp' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->error_response('Validation failed.', $validator->errors(), 400);
        }

        // Retrieve user by mobile number or email
        $user = User::where('phone_number', $request->input('mobile'))
                    ->orWhere('email', $request->input('mobile'))
                    ->first();

        // Check if user exists and OTP matches
        if (!$user || $user->otp !== $request->input('otp')) {
            return $this->error_response('Incorrect OTP.', '', 400);
        }

        // Generate token for user
        $token = $user->createToken('login_token')->plainTextToken;

        // Calculate referral earnings
        $referral_money = ReferelMoney::where('user_id', $user->id)
                                      ->where('is_used', 0)
                                      ->sum('price');

        // Prepare response data
        $data = [
            'id' => $user->id,
            'phone_number' => $request->input('mobile'),
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'refer_earn' => $referral_money,
            'refer_coupon' => base64_encode($user->id)
        ];

        // making token nullable
        $user->otp = null;
        $user->save();

        // Return success response
        return $this->success_response("You've been logged in successfully.", $data);
    }


    public function deactiveAccount(Request $request){
        $user=$this->getUserByApiToken($request);
        $user->status=3;
        $user->save();
        return $this->success_response('Account Deleted','');

    }
}
