<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Reception;
use App\Models\Booking;
use App\Models\BookedRoom;
use App\Models\Room;
use App\Models\Customer;
use Validator;
use Auth;

class ReceptionController extends ApiController
{
    public function addReception(Request $request)
	{
		$validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'phone' => 'required|unique:users', 
            'email' => 'required|unique:users',
            'password' => 'required',
            'hotel_id' => 'required',
        ]);
		$reception = new Reception;
        $validate = $reception->verifyReception($validator);
        if($validate) 
        {
            return $this->responseOkay($validate); 
        }
		$data = $request->all();
		$response = array();
		if($data)
		{
			$user = new User;
			$user->name = $data['name'];
			$user->email = $data['email'];
			$user->password =  bcrypt($data['password']);
			$user->phone = $data['phone'];
			if($data['type'] == 'manager')
            {
			    $user->type = 7;
            }
            if($data['type'] == 'reception')
            {
                $user->type = 5;
            }
			$user->save();

			$reception = new Reception;
			$reception->name = $data['name'];
			$reception->partner_id = Auth::user()->id;
			$reception->user_id = $user['id'];
			$reception->phone = $data['phone'];
            $reception->hotel_id = $data['hotel_id'];
			if(isset($data['latitude']))
			{
				$reception->latitude = $data['latitude'];
			}
			if(isset($data['longitude']))
			{
				$reception->longitude = $data['longitude'];
			}
			if(isset($data['location']))
			{
				$reception->location = $data['location'];
			}
			$reception->save();

			$response = [
                        'error' => false,
                        'message' => 'Reception Added',
                        'data' => $reception,
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

    public function viewCheckin(Request $request)
	{
		$response = array();    
		$dataArr = array();
		$curbkngArr = array();
		$bookdArr = array();
		$bookArr = array();
		
		$validator = Validator::make($request->all(), [ 
            'reception_id' => 'required', 
            'hotel_id' => 'required',
        ]);
		$booking = new Booking;
        $validate = $booking->verifyBooking($validator);
        if($validate) 
        {
            return $this->responseOkay($validate); 
        }
        $data = $request->all();
        if($data)
        {
        	$bookings = Booking::where('reception_id',$data['reception_id'])->where('hotel_id',$data['hotel_id'])->where('check_in',1)->where('check_out',null)->where('current_status','booked')->where('updated_status',null)->get();
        	
        	if(count($bookings) > 0)
            {
                foreach ($bookings as $curBooking) 
            {
                $curbkngArr['id'] = $curBooking['id'];
                $curbkngArr['booking_id'] = $curBooking['booking_id'];
                $curbkngArr['customer_id'] = $curBooking['customer_id'];
                $curbkngArr['booking_start_date'] = $curBooking['booking_start_date'];
                $curbkngArr['booking_end_date'] = $curBooking['booking_end_date'];
                $curbkngArr['check_in_date'] = $curBooking['check_in_date'];
                $curbkngArr['check_out_date'] = $curBooking['check_out_date'];
                $curbkngArr['check_in'] = $curBooking['check_in'];
                $curbkngArr['check_out'] = $curBooking['check_out'];
                
                $booked = BookedRoom::where('booking_id',$curBooking['booking_id'])->get();
                      
                foreach($booked as $k => $bookingroom)
                {
                    $room = Room::where('room_number',$bookingroom['room_number'])->where('hotel_id',$curBooking['hotel_id'])->first();
                    $bookdArr['room_number'] = $bookingroom['room_number'];
                    $bookdArr['guest_type'] = $bookingroom['guest_type'];
                    $bookdArr['no_of_days'] = $bookingroom['no_of_days'];
                    $bookdArr['room_type'] = $room['room_type'];
                    $curbkngArr['booked'][$k] = $bookdArr;
                }
                $hotel = Hotel::find($curBooking['hotel_id']);
                $user = User::find($hotel['user_id']);
                $curbkngArr['hotel_name'] = $hotel['name'];
                $curbkngArr['hotel_phone'] = $user['phone'];
                $curbkngArr['hotel_location'] = $hotel['location'];
                $curbkngArr['hotel_lat'] = $hotel['latitude'];
                $curbkngArr['hotel_long'] = $hotel['longitude'];

                $curbkngArr['hotel_id'] = $curBooking['hotel_id'];
                $curbkngArr['reception_id'] = $curBooking['reception_id'];
                $curbkngArr['room_number'] = $curBooking['room_number'];
                $curbkngArr['amount'] = $curBooking['amount'];
                $curbkngArr['discount'] = $curBooking['discount'];
                $curbkngArr['tax'] = $curBooking['tax'];
                $curbkngArr['final_amount'] = $curBooking['final_amount'];
                $curbkngArr['payment_mode'] = $curBooking['payment_mode'];
                $curbkngArr['is_paid'] = $curBooking['is_paid'];
                $curbkngArr['current_status'] = $curBooking['current_status'];
                $curbkngArr['updated_status'] = $curBooking['updated_status'];
                $curbkngArr['id_proof_name'] = $curBooking['id_proof_name'];
                $curbkngArr['id_proof_image'] = $curBooking['id_proof_image'];
                $curbkngArr['feedback'] = $curBooking['feedback'];
                $curbkngArr['rating'] = $curBooking['rating'];
                $curbkngArr['cancel_reason'] = $curBooking['cancel_reason'];
                if($curBooking['custname2'] != null)
                {
                    $curbkngArr['custname2'] = $curBooking['custname2'];
                    $curbkngArr['phone'] = $curBooking['phone'];    
                }
                else
                {
                    $customer  = Customer::find($curBooking['customer_id']);
                    $curbkngArr['custname2'] = $customer['name'];
                    $curbkngArr['phone'] = $customer['phone']; 
                }
                
                $bookArr['data'][] = $curbkngArr;
            }
                $response = [
                        'error' => false,
                        'message' => 'suceess',
                        'data' => $bookArr,
                ];
            }
            else
            {
                $response = [
                        'error' => true,
                        'message' => 'Check in not found',
                        'data' => null,
                    ];   
            }
        }
        else
        {
        	$response = [
                        'error' => true,
                        'message' =>'Data not found',
                        'data' => null,
                    ];
        }	
        return $this->responseOkay($response);
	}   



	public function viewCheckOut(Request $request)
	{
		$response = array();
		$dataArr = array();
		$curbkngArr = array();
		$bookArr = array();
		$bookdArr = array();
		
		$validator = Validator::make($request->all(), [ 
            'reception_id' => 'required', 
            'hotel_id' => 'required',
        ]);
		$booking = new Booking;
        $validate = $booking->verifyBooking($validator);
        if($validate) 
        {
            return $this->responseOkay($validate); 
        }
        $data = $request->all();
        if($data)
        {
        	$bookings = Booking::where('reception_id',$data['reception_id'])->where('hotel_id',$data['hotel_id'])->where('check_out',1)->where('updated_status','checkout')->get();
            if(count($bookings)>0)
            {
        	   // foreach ($bookings as $booking) {
        		  // $dataArr['checkout'][] = $booking;
        	   // }

            foreach ($bookings as $curBooking) 
            {
                $curbkngArr['id'] = $curBooking['id'];
                $curbkngArr['booking_id'] = $curBooking['booking_id'];
                $curbkngArr['customer_id'] = $curBooking['customer_id'];
                $curbkngArr['booking_start_date'] = $curBooking['booking_start_date'];
                $curbkngArr['booking_end_date'] = $curBooking['booking_end_date'];
                $curbkngArr['check_in_date'] = $curBooking['check_in_date'];
                $curbkngArr['check_out_date'] = $curBooking['check_out_date'];
                $curbkngArr['check_in'] = $curBooking['check_in'];
                $curbkngArr['check_out'] = $curBooking['check_out'];
                
                $booked = BookedRoom::where('booking_id',$curBooking['booking_id'])->get();
                      
                foreach($booked as $k => $bookingroom)
                {
                    $room = Room::where('room_number',$bookingroom['room_number'])->where('hotel_id',$curBooking['hotel_id'])->first();
                    $bookdArr['room_number'] = $bookingroom['room_number'];
                    $bookdArr['guest_type'] = $bookingroom['guest_type'];
                    $bookdArr['no_of_days'] = $bookingroom['no_of_days'];
                    $bookdArr['room_type'] = $room['room_type'];
                    $curbkngArr['booked'][$k] = $bookdArr;
                }
                $hotel = Hotel::find($curBooking['hotel_id']);
                $user = User::find($hotel['user_id']);
                $curbkngArr['hotel_name'] = $hotel['name'];
                $curbkngArr['hotel_phone'] = $user['phone'];
                $curbkngArr['hotel_location'] = $hotel['location'];
                $curbkngArr['hotel_lat'] = $hotel['latitude'];
                $curbkngArr['hotel_long'] = $hotel['longitude'];

                $curbkngArr['hotel_id'] = $curBooking['hotel_id'];
                $curbkngArr['reception_id'] = $curBooking['reception_id'];
                $curbkngArr['room_number'] = $curBooking['room_number'];
                $curbkngArr['amount'] = $curBooking['amount'];
                $curbkngArr['discount'] = $curBooking['discount'];
                $curbkngArr['tax'] = $curBooking['tax'];
                $curbkngArr['final_amount'] = $curBooking['final_amount'];
                $curbkngArr['payment_mode'] = $curBooking['payment_mode'];
                $curbkngArr['is_paid'] = $curBooking['is_paid'];
                $curbkngArr['current_status'] = $curBooking['current_status'];
                $curbkngArr['updated_status'] = $curBooking['updated_status'];
                $curbkngArr['id_proof_name'] = $curBooking['id_proof_name'];
                $curbkngArr['id_proof_image'] = $curBooking['id_proof_image'];
                $curbkngArr['feedback'] = $curBooking['feedback'];
                $curbkngArr['rating'] = $curBooking['rating'];
                $curbkngArr['cancel_reason'] = $curBooking['cancel_reason'];
                if($curBooking['custname2'] != null)
                {
                    $curbkngArr['custname2'] = $curBooking['custname2'];
                    $curbkngArr['phone'] = $curBooking['phone'];    
                }
                else
                {
                    $customer  = Customer::find($curBooking['customer_id']);
                    $curbkngArr['custname2'] = $customer['name'];
                    $curbkngArr['phone'] = $customer['phone']; 
                }
                
                $bookArr['data'][] = $curbkngArr;
            }

        	    $response = [
                        'error' => false,
                        'message' => 'success',
                        'data' => $bookArr,
                ];
            }
            else
            {
                $response = [
                        'error' => true,
                        'message' => 'Checkout not found',
                        'data' => null,
                ];
            }
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

    public function bookingListByReception(Request $request)
    {
        $response = array();
        $curbkngArr = array();
        $bookdArr = array();
        $bookArr = array();
        
        $validator = Validator::make($request->all(), [ 
            'hotel_id' => 'required',
        ]); 
        $booking = new Booking;
        $validate = $booking->verifyBooking($validator);
        if($validate) 
        {
            return $this->responseOkay($validate); 
        }
        $data = $request->all();
        if($data)
        {
            $listByReception = Booking::where('hotel_id',$data['hotel_id'])
                    ->where('current_status','booked')
                    ->where('check_out',null)
                    ->where('check_in',null)
                    ->where('updated_status',null)
                    ->orderBy('created_at','DESC')->get();
            if(count($listByReception) > 0)
            {
                foreach ($listByReception as $curBooking) 
                {
                    $curbkngArr['id'] = $curBooking['id'];
                    $curbkngArr['booking_id'] = $curBooking['booking_id'];
                    $curbkngArr['customer_id'] = $curBooking['customer_id'];
                    $curbkngArr['booking_start_date'] = $curBooking['booking_start_date'];
                    $curbkngArr['booking_end_date'] = $curBooking['booking_end_date'];
                    $curbkngArr['check_in_date'] = $curBooking['check_in_date'];
                    $curbkngArr['check_out_date'] = $curBooking['check_out_date'];
                    $curbkngArr['check_in'] = $curBooking['check_in'];
                    $curbkngArr['check_out'] = $curBooking['check_out'];
                    
                    $booked = BookedRoom::where('booking_id',$curBooking['booking_id'])->get();
                          
                    foreach($booked as $k => $bookingroom)
                    {
                        $room = Room::where('room_number',$bookingroom['room_number'])->where('hotel_id',$curBooking['hotel_id'])->first();
                        $bookdArr['room_number'] = $bookingroom['room_number'];
                        $bookdArr['guest_type'] = $bookingroom['guest_type'];
                        $bookdArr['no_of_days'] = $bookingroom['no_of_days'];
                        $bookdArr['room_type'] = $room['room_type'];
                        $curbkngArr['booked'][$k] = $bookdArr;
                    }
                    $hotel = Hotel::find($curBooking['hotel_id']);
                    $user = User::find($hotel['user_id']);
                    $curbkngArr['hotel_name'] = $hotel['name'];
                    $curbkngArr['hotel_phone'] = $user['phone'];
                    $curbkngArr['hotel_location'] = $hotel['location'];
                    $curbkngArr['hotel_lat'] = $hotel['latitude'];
                    $curbkngArr['hotel_long'] = $hotel['longitude'];
    
                    $curbkngArr['hotel_id'] = $curBooking['hotel_id'];
                    $curbkngArr['reception_id'] = $curBooking['reception_id'];
                    $curbkngArr['room_number'] = $curBooking['room_number'];
                    $curbkngArr['amount'] = $curBooking['amount'];
                    $curbkngArr['discount'] = $curBooking['discount'];
                    $curbkngArr['tax'] = $curBooking['tax'];
                    $curbkngArr['final_amount'] = $curBooking['final_amount'];
                    $curbkngArr['payment_mode'] = $curBooking['payment_mode'];
                    $curbkngArr['is_paid'] = $curBooking['is_paid'];
                    $curbkngArr['current_status'] = $curBooking['current_status'];
                    $curbkngArr['updated_status'] = $curBooking['updated_status'];
                    $curbkngArr['id_proof_name'] = $curBooking['id_proof_name'];
                    $curbkngArr['id_proof_image'] = $curBooking['id_proof_image'];
                    $curbkngArr['feedback'] = $curBooking['feedback'];
                    $curbkngArr['rating'] = $curBooking['rating'];
                    $curbkngArr['cancel_reason'] = $curBooking['cancel_reason'];
                    if($curBooking['custname2'] != null)
                    {
                        $curbkngArr['custname2'] = $curBooking['custname2'];
                        $curbkngArr['phone'] = $curBooking['phone'];    
                    }
                    else
                    {
                        $customer  = Customer::find($curBooking['customer_id']);
                        $curbkngArr['custname2'] = $customer['name'];
                        $curbkngArr['phone'] = $customer['phone']; 
                    }
                    
                    $bookArr['data'][] = $curbkngArr;
                }
            
                $response = [
                    'error' => false,
                    'message' => 'success',
                    'data' => $bookArr,
                ];
            }
            else
            {
                $response = [
                    'error' => true,
                    'message' => 'Booking not found',
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

    public function cancleListByReception(Request $request)
    {
        $response = array();
        $bookArr = array();
        $curbkngArr = array();
        $bookdArr = array();
        
        $validator = Validator::make($request->all(), [ 
            'hotel_id' => 'required',
        ]); 
        $data = $request->all();
        if($data)
        {
            $cancelBooking = Booking::where('hotel_id',$data['hotel_id'])
                    ->where('updated_status','cancel')
                    ->get();
            if(count($cancelBooking)>0)
            {
                
                foreach ($cancelBooking as $curBooking) 
                {
                    $curbkngArr['id'] = $curBooking['id'];
                    $curbkngArr['booking_id'] = $curBooking['booking_id'];
                    $curbkngArr['customer_id'] = $curBooking['customer_id'];
                    $curbkngArr['booking_start_date'] = $curBooking['booking_start_date'];
                    $curbkngArr['booking_end_date'] = $curBooking['booking_end_date'];
                    $curbkngArr['check_in_date'] = $curBooking['check_in_date'];
                    $curbkngArr['check_out_date'] = $curBooking['check_out_date'];
                    $curbkngArr['check_in'] = $curBooking['check_in'];
                    $curbkngArr['check_out'] = $curBooking['check_out'];
                    
                    $booked = BookedRoom::where('booking_id',$curBooking['booking_id'])->get();
                          
                    foreach($booked as $k => $bookingroom)
                    {
                        $room = Room::where('room_number',$bookingroom['room_number'])->where('hotel_id',$curBooking['hotel_id'])->first();
                        $bookdArr['room_number'] = $bookingroom['room_number'];
                        $bookdArr['guest_type'] = $bookingroom['guest_type'];
                        $bookdArr['no_of_days'] = $bookingroom['no_of_days'];
                        $bookdArr['room_type'] = $room['room_type'];
                        $curbkngArr['booked'][$k] = $bookdArr;
                    }
                    $hotel = Hotel::find($curBooking['hotel_id']);
                    $user = User::find($hotel['user_id']);
                    $curbkngArr['hotel_name'] = $hotel['name'];
                    $curbkngArr['hotel_phone'] = $user['phone'];
                    $curbkngArr['hotel_location'] = $hotel['location'];
                    $curbkngArr['hotel_lat'] = $hotel['latitude'];
                    $curbkngArr['hotel_long'] = $hotel['longitude'];
    
                    $curbkngArr['hotel_id'] = $curBooking['hotel_id'];
                    $curbkngArr['reception_id'] = $curBooking['reception_id'];
                    $curbkngArr['room_number'] = $curBooking['room_number'];
                    $curbkngArr['amount'] = $curBooking['amount'];
                    $curbkngArr['discount'] = $curBooking['discount'];
                    $curbkngArr['tax'] = $curBooking['tax'];
                    $curbkngArr['final_amount'] = $curBooking['final_amount'];
                    $curbkngArr['payment_mode'] = $curBooking['payment_mode'];
                    $curbkngArr['is_paid'] = $curBooking['is_paid'];
                    $curbkngArr['current_status'] = $curBooking['current_status'];
                    $curbkngArr['updated_status'] = $curBooking['updated_status'];
                    $curbkngArr['id_proof_name'] = $curBooking['id_proof_name'];
                    $curbkngArr['id_proof_image'] = $curBooking['id_proof_image'];
                    $curbkngArr['feedback'] = $curBooking['feedback'];
                    $curbkngArr['rating'] = $curBooking['rating'];
                    $curbkngArr['cancel_reason'] = $curBooking['cancel_reason'];
                    if($curBooking['custname2'] != null)
                    {
                        $curbkngArr['custname2'] = $curBooking['custname2'];
                        $curbkngArr['phone'] = $curBooking['phone'];    
                    }
                    else
                    {
                        $customer  = Customer::find($curBooking['customer_id']);
                        $curbkngArr['custname2'] = $customer['name'];
                        $curbkngArr['phone'] = $customer['phone']; 
                    }
                    
                    $bookArr['data'][] = $curbkngArr;
                }
                
                
                $response = [
                    'error' => false,
                    'messsage' => 'Success',
                    'data' => $bookArr,
                ];
            }
            else
            {
                $response = [
                    'error' => true,
                    'messsage' => 'Booking not found',
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
    public function completedBooking(Request $request)
    {
        $response = array();
        $bookArr = array();
        $curbkngArr = array();
        $bookdArr = array();
        
        $validator = Validator::make($request->all(), [ 
            'hotel_id' => 'required', 
            'reception_id' => 'required',
        ]);  
        $data = $request->all();
        if($data)
        {
            $booking = Booking::where('hotel_id',$data['hotel_id'])
                        ->where('reception_id',$data['reception_id'])
                        ->where('check_in',1)
                        ->where('check_out',1)
                        ->where('updated_status','check_out')
                        ->get();
            if(count($booking)>0)
            {
                
                foreach ($booking as $curBooking) 
                {
                    $curbkngArr['id'] = $curBooking['id'];
                    $curbkngArr['booking_id'] = $curBooking['booking_id'];
                    $curbkngArr['customer_id'] = $curBooking['customer_id'];
                    $curbkngArr['booking_start_date'] = $curBooking['booking_start_date'];
                    $curbkngArr['booking_end_date'] = $curBooking['booking_end_date'];
                    $curbkngArr['check_in_date'] = $curBooking['check_in_date'];
                    $curbkngArr['check_out_date'] = $curBooking['check_out_date'];
                    $curbkngArr['check_in'] = $curBooking['check_in'];
                    $curbkngArr['check_out'] = $curBooking['check_out'];
                    
                    $booked = BookedRoom::where('booking_id',$curBooking['booking_id'])->get();
                          
                    foreach($booked as $k => $bookingroom)
                    {
                        $room = Room::where('room_number',$bookingroom['room_number'])->where('hotel_id',$curBooking['hotel_id'])->first();
                        $bookdArr['room_number'] = $bookingroom['room_number'];
                        $bookdArr['guest_type'] = $bookingroom['guest_type'];
                        $bookdArr['no_of_days'] = $bookingroom['no_of_days'];
                        $bookdArr['room_type'] = $room['room_type'];
                        $curbkngArr['booked'][$k] = $bookdArr;
                    }
                    $hotel = Hotel::find($curBooking['hotel_id']);
                    $user = User::find($hotel['user_id']);
                    $curbkngArr['hotel_name'] = $hotel['name'];
                    $curbkngArr['hotel_phone'] = $user['phone'];
                    $curbkngArr['hotel_location'] = $hotel['location'];
                    $curbkngArr['hotel_lat'] = $hotel['latitude'];
                    $curbkngArr['hotel_long'] = $hotel['longitude'];
    
                    $curbkngArr['hotel_id'] = $curBooking['hotel_id'];
                    $curbkngArr['reception_id'] = $curBooking['reception_id'];
                    $curbkngArr['room_number'] = $curBooking['room_number'];
                    $curbkngArr['amount'] = $curBooking['amount'];
                    $curbkngArr['discount'] = $curBooking['discount'];
                    $curbkngArr['tax'] = $curBooking['tax'];
                    $curbkngArr['final_amount'] = $curBooking['final_amount'];
                    $curbkngArr['payment_mode'] = $curBooking['payment_mode'];
                    $curbkngArr['is_paid'] = $curBooking['is_paid'];
                    $curbkngArr['current_status'] = $curBooking['current_status'];
                    $curbkngArr['updated_status'] = $curBooking['updated_status'];
                    $curbkngArr['id_proof_name'] = $curBooking['id_proof_name'];
                    $curbkngArr['id_proof_image'] = $curBooking['id_proof_image'];
                    $curbkngArr['feedback'] = $curBooking['feedback'];
                    $curbkngArr['rating'] = $curBooking['rating'];
                    $curbkngArr['cancel_reason'] = $curBooking['cancel_reason'];
                    if($curBooking['custname2'] != null)
                    {
                        $curbkngArr['custname2'] = $curBooking['custname2'];
                        $curbkngArr['phone'] = $curBooking['phone'];    
                    }
                    else
                    {
                        $customer  = Customer::find($curBooking['customer_id']);
                        $curbkngArr['custname2'] = $customer['name'];
                        $curbkngArr['phone'] = $customer['phone']; 
                    }
                    
                    $bookArr['data'][] = $curbkngArr;
                }
                $response = [
                    'error' => false,
                    'message' => 'Success',
                    'data' => $bookArr,
                ];
            }
            else
            {
                $response = [
                    'error' => true,
                    'message' => 'Booking not found',
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
}
