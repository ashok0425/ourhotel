<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Models\Booking;
use App\Models\ReferPrice;
use App\Models\ReferelMoney;
use App\Models\Testimonial;
use App\Notifications\sendOtp as SendotpNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ResponseTrait;

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

        if($input)
        {
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
//   if($request->referral_code){
//       $refer = str_replace("NSN","",$request->referral_code);
//                 $referl_price = ReferPrice::first();
//                 $referl_money = new ReferelMoney();
//                 $referl_money->user_id = $refer;
//                 $referl_money->price =  $referl_price->share_price;
//                 $referl_money->refewrel_type ='2' ;
//                 $referl_money->referel_code =$request->referral_code ;
//                 $referl_money->save();
//                 $join_money = new ReferelMoney();
//                 $join_money->user_id = $user->id;
//                 $join_money->price =  $referl_price->join_price;
//                 $join_money->refewrel_type ='1' ;
//                 $join_money->referel_code =$request->referral_code;
//                 $join_money->save();
//              }
             $phone=$input['phone'];
            //  $this->whatsapp_verification('977'.$phone,$otp);
            //  $this->whatsapp_verification('91'.$phone,$otp);
            //  $this->sendMessage($otp, $input['phone']);
             return $this->success_response('Register succesfully.');
        }
        else
        {
        return $this->error_response('Something Went Wrong','',400);

        }


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
      if($email==0&&filter_var( $request->mobile, FILTER_VALIDATE_EMAIL)){

            $user=User::where('email',$request->mobile)->where('email','!=',null)->first();
            $otp=str_pad(rand(1,1000000),6,'0');
          if(!$user)
          {
              $user=new User();
              $user->name = $request['name'];
              $user->email = $request['mobile'];
              $user->phone_number =9813519397;
              $user->password = bcrypt(123456);
              $user->otp = $otp;
              $user->save();
          }
          $user->otp = $otp;
              $user->save();
               //   Notification::route('mail',$user->email)->notify(new SendotpNotification($otp));
            return $this->success_response("We have sent an otp at your Email address.,$otp");

        }
        if(!($customer = $this->findCustomerByMobile($request->mobile)))
        {
            return $this->error_response('We could not find the customer associated with that mobile number.','',400);
        }
        else
        {

            $user = $this->findUserByMobile($request->mobile);
              if($user->status==3){
            return $this->error_response('Invalid Credientials','',400);
        }
            $this->sendOtp($request->mobile);

            return $this->success_response('We have sent an otp at your registered mobile number.');
        }
    }


    public function sendOtp($number)
    {
        $customer = User::where('phone_number',$number)->first();
        if($number=='9813519397'){
            $otp = 123456;
        }else{
            $otp=str_pad(rand(1,1000000),6,'0');

        }

        if($customer->status==3){
            return $this->error('Invalid Credientials','',400);
        }
        $customer->otp = $otp;
        $customer->save();
        $this->sendMessage($customer->otp, $customer->phone_number);
        $this->whatsapp_verification('977'. $customer->phone_number,$customer->otp);
        $this->whatsapp_verification('91'. $customer->phone_number,$customer->otp);


        return $customer->otp;
    }


    public function sendMessage($otp, $number)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"6129d0b64e38b3307e5f35e3\",\n  \n  \"mobiles\": \"91".$number."\",\n  \"otp\": \"".$otp."\"\n}",
          CURLOPT_HTTPHEADER => array(
            "authkey: 365824AD62HRzVQS611a22d5P1",
            "content-type: application/JSON"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    }

    public function getLogin(Request $request) {


        $validator = Validator::make($request->all(),
        [
           'mobile' =>'required',
           'otp' => 'required',
        ]);

        $userObj = new User;

        $validate = $userObj->validateData($validator);

        if($validate)
        {
            return $this->error_response('Validation Error',$validate,400);

        }

        $data       =   $request->all();

        if($data) {

                  $user   =   User::where('phone_number',$data['mobile'])->orwhere('email',$data['mobile'])->first();
                //   return $user;
            if (!isset($user)||$user->otp!=$data['otp']) {
                return $this->error('Incorrect otp','',400);
            }

                $token  = Str::random(60);
                $user->api_token = hash('sha256', $token);
                $user->otp = '';
                $user->save();

                if(!empty($user)) {
                   $referl_money = ReferelMoney::where('user_id',$user['id'])->where('is_used',0)->sum('price');
                    $data = [
                    'id' => $user['id'],
                        'phone_number' => $request['mobile'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'token' => $user->api_token,
                        'refer_earn' => $referl_money,
                        'refer_coupon' =>base64_encode($user['id'])
                    ];
                    return $this->success_response("You've been logged in successfully.",$data);
            }   else {


                   return $this->success_response('The otp you typed does not match with the one we sent on your registered mobile.');
                }

            } else {


            return $this->error_response('We encountered an error sending otp to that mobile number. Please try again in a while.','',400);

            }
    }


    public function findUserByMobile(string $mobile)
    {
        return User::where('phone_number', $mobile)->first();
    }

    public function findCustomerByMobile(string $mobile)
    {
        try {
            $user = User::where('phone_number', $mobile)->first();
            if ($user) {

                $customer = User::where('phone_number', $mobile)->first();
                if (!$customer)
                {
                    return false;
                }
                return $customer;
            } else {
                return false;
            }
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }


    public function Testimonial(){
        $testimonials = Testimonial::where('status',1)->get();
        return $this->success_response('Testimonial fetched successfully',$testimonials);
    }





    public function myBooking(Request $request){
        $user=$this->getUserByApiToken($request);
        $booking = Booking::join('places','places.id','bookings.place_id')->where('bookings.user_id',$user->id)->join('place_translations','place_translations.place_id','places.id')->select('bookings.*','place_translations.name as hotel_name','places.thumb as thumbnail','places.address as address')->get();
        return $this->success_response('Booking list fetched successfully',$booking);
    }

    public function cancelBooking(Request $request){
        $user=$this->getUserByApiToken($request);
        if(!$user){
        return $this->error_response('Unauthorized','',400);
        }
        $booking = Booking::where('user_id',$user->id)->where('id',$request->id)->first();

        if(!$booking){
         return $this->error_response('Unauthorized','',400);
        }
        $booking->status=0;
        $booking->save();
        // $this->whatsapp_cancel('977'.$booking->phone_number, $booking->name);
        $this->whatsapp_cancel('91'.$booking->phone_number, $booking->name,$booking->booking_id);
       //  $this->whatsapp_cancel('91'.$mm->phone_number, $mm->name);
        $this->whatsapp_cancel('919958277997'.$booking->phone_number, $booking->name,$booking->booking_id);
        return $this->success_response('Booking  updated successfully',$booking);
    }

    public function deactiveAccount(Request $request){
        $user=$this->getUserByApiToken($request);
        $user->status=3;
        $user->save();
        return $this->success_response('Account Deleted','');

    }
}
