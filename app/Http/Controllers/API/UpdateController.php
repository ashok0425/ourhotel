<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Place;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidatorTrait;


class UpdateController extends Controller
{
    use ResponseTrait;
    
	private $request;
	
	public function __construct(Request $request)
   {
     //$this->middleware('auth');
     $this->request = $request;
   }


	public function updateCustomerProfile(Request $request)
	{
      $user = $this->getUserByApiToken($request);
		$response = array();
      $data = $request->all();
      

        	$user->name = $request->name;
        	$user->email = $request->email;
         $file=$request->file('thumbnail');
         if($file){
            $file_name = $this->uploadImage($file, '');
            $user->avatar = $file_name;
         }
            $user->save();

    

      return $this->success_response('user information updated',$user);

      
	}

	public function partnerProfileUpdate(Request $request)
   {
    	$response = array();
		$validator = Validator::make($request->all(), [ 
         'id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
        	$user = User::find($data['id']);
        	$user->name = $data['name'];
        	$user->save();
        	$response = [
        		'error' => false,
        		'message' => 'Profile updated',
        		'data' => $user,
        	];
      }
      else
      {
        	$response = [
        		'error' => true,
        		'message' => 'Something went wrong',
        		'data' => null,
        	];
      }
      return $this->responseOkay($response);
   }

   public function updateHotelProfile(Request $request)
   {
   	    $response = array();
		
		$validator = Validator::make($request->all(), [ 
         'id' => 'required', 
        ]);
        
        $data = $request->all();
		if($data)
		{
			$hotel = Hotel::find($data['id']);
         if($hotel)
         {
   			$hotel->name = $data['name'];
   			$hotel->latitude = $data['latitude'];
   			$hotel->longitude = $data['longitude'];
   			$hotel->state = $data['state'];
   			$hotel->city = $data['city'];
   			$hotel->location = $data['location'];
            $hotel->description = $data['description'];
            if(isset($data['is_online']))
            {
                $hotel->is_online = $data['is_online'];
            }
            if(isset($data['early_check_in']))
            {
                $hotel->early_check_in = $data['early_check_in'];
            }
            if(isset($data['late_check_out']))
            {
                $hotel->late_check_out = $data['late_check_out'];
            }
            
   			$user = User::find($hotel['user_id']);
   			$user->name = $data['name'];
   			$user->phone = $data['phone'];
   			$user->save();
   			$hotel->save();

   			$response = [
   				'error' => false,
   				'message' => 'Updated successfully',
   				'data' => $hotel,
   			];
         }
         else
         {
            $response = [
               'error' => false,
               'message' => 'Hotel not found',
               'data' => null,
            ];
         }
   	}
   	else
   	{
   		$response = [
				'error' => true,
				'message' => 'Something went wrong',
				'data' => null
   		];
   	}
   	return $this->responseOkay($response);
   }


   public function updateReceptionProfile(Request $request)
   {
   	$response = array();
		$validator = Validator::make($request->all(), [ 
            'id' => 'required',
            'hotel_id' => 'required',
            'partner_id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
        	$reception = Reception::where('id',$data['id'])->where('hotel_id',$data['hotel_id'])->where('partner_id',$data['partner_id'])->first();
        	if(isset($reception))
        	{
        		$reception['name'] = $data['name'];
        		$reception['latitude'] = $data['latitude'];
        		$reception['longitude'] = $data['longitude'];
        		$reception['location'] = $data['location'];
        		$reception['phone'] = $data['phone'];
        		$user = User::find($reception['user_id']);
        		// $user['email'] = $data['email'];
        		if(isset($data['password']))
        		{
        		    $user['password'] = bcrypt($data['password']);
        		}
        		$user['phone'] = $data['phone'];
        		$user->save();
        		$reception->save();
        		$response = [
        			'error' => false,
        			'message' => 'Success',
        			'data' => $reception
        		];
        	}
        	else
        	{
        		$response = [
        			'error' => true,
        			'message' => 'Reception not found',
        			'data' => null
        		];
        	}
      }
      else
      {
        	$response = [
        			'error' => true,
        			'message' => 'Something went wrong',
        			'data' => null
        		];
      }
   	return $this->responseOkay($response);
   }

	public function updateRoom(Request $request)
	{
		  $response = array();
	    $validator = Validator::make($request->all(), [ 
         'id' => 'required',
         'hotel_id' => 'required',
         'partner_id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
     	  $room = Room::where('id',$data['id'])->where('hotel_id',$data['hotel_id'])->where('partner_id',$data['partner_id'])->first();
        if(isset($room))
        {
        	$room['room_type'] = $data['room_type'];
            $room['single_price'] = $data['single_price'];
            $room['double_price'] = $data['double_price'];
            $room['three_price'] = $data['three_price'];
            $room['four_price'] = $data['four_price'];
        		$room['is_pet'] = $data['is_pet'];
            $room['single_discount'] = $data['single_discount'];
            $room['double_discount'] = $data['double_discount'];
            $room['three_discount'] = $data['three_discount'];
            $room['four_discount'] = $data['four_discount'];
            $room->save();
            
            $response = [
              'error' => false,
              'message' => 'Room updated',
              'data' => null
            ];

        }
        else
        {
   			  $response = [
        			'error' => true,
        			'message' => 'Room not found',
        			'data' => null
        		];        		
        }
      }
      else
      {
     	   $response = [
     		  'error' => true,
     		  'message' => 'Something went wrong',
     		  'data' => null
     	   ];
      }
      return $this->responseOkay($response);
	}

   public function hotelDelete(Request $request)
   {
      $response = array();
      $validator = Validator::make($request->all(), [ 
         'id' => 'required',
         'partner_id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
         $hotel = Hotel::where('id',$data['id'])->where('partner_id',$data['partner_id'])->first();
         if($hotel)
         {
            $booking = Booking::where('hotel_id',$hotel['id'])->where('check_in',null)->where('check_out',null);
            $booking->where(function($q){$q
                        ->where('updated_status','!=','cancel')
                        ->orWhere('updated_status',null);
            });
            $total = $booking->count();
            if($total > 0)
            {
               $response = [
                  'error' => true,
                  'message' => 'Hotel has booking(s), can not delete',
               ];
            }
            else
            {
               $rooms = Room::where('hotel_id',$data['id'])->get();
               if(isset($rooms))
               {
                  foreach ($rooms as $room) 
                  {
                     $room->delete();
                  }
               }
               $receptions = Reception::where('hotel_id',$data['id'])->get();
               if(isset($receptions))
               {
                  foreach ($receptions as $reception) 
                  {
                     $reception->delete();
                  }
               }   
               $hotel->delete();
               $response = [
                  'error' => false,
                  'message' => 'Hotel Deleted',
               ];
            }
         }
         else
         {
            $response = [
               'error' => true,
               'message' => 'Hotel not found',
            ];
         }
      }
      else
      {
         $response = [
            'error' => true,
            'message' => 'something went wrong',
            'data' => null
         ];
      }
      return $this->responseOkay($response);
   }
   public function RoomDelete(Request $request)
   {
      $response = array();
      $validator = Validator::make($request->all(), [ 
         'id' => 'required',
         'partner_id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
        $room = Room::where('id',$data['id'])->where('partner_id',$data['partner_id'])->first();
        if($room)
        {

          if($room['is_booked'] == null)
          {
            $room->delete();
            $response = [
              'error' => false,
              'message' => 'Room Deleted'
            ];
          }
          else
          {
            $response = [
              'error' => true,
              'message' => 'Room Booked can not delete'
            ];
          }
        }
        else
        {
          $response = [
              'error' => true,
              'message' => 'Room not found',
          ];
        }
      }
      else
      {
        $response = [
          'error' => true,
          'message' => 'Something went wrong'
        ];
      }
      return $this->responseOkay($response);
   }

   public function ReceptionDelete(Request $request)
   {
      $response = array();
      $validator = Validator::make($request->all(), [ 
         'id' => 'required',
         'partner_id' => 'required', 
      ]);
      $data = $request->all();
      if($data)
      {
          $reception = Reception::find($data['id']);
          if(isset($reception))
          {
            $booking = Booking::where('reception_id',$reception['id'])->where('check_in',null)->where('check_out',null);
              $booking->where(function($q){$q
                          ->where('updated_status','!=','cancel')
                          ->orWhere('updated_status',null);
              });
              $total = $booking->count();
            if($total > 0)
            {
               $response = [
                  'error' => true,
                  'message' => 'Reception has booking(s), can not delete',
               ];
            }
            else
            {
              $reception->delete();
              $response = [
                  'error' => false,
                  'message' => 'Reception Deleted',
               ];
            }
        }
        else
        {
          $response = [
                  'error' => true,
                  'message' => 'Reception not found',
               ];
        }
      }
      else
      {
        $response = [
            'error' => true,
            'message' => 'Something went wrong'
        ];
      }
      return $this->responseOkay($response);
   }
}
