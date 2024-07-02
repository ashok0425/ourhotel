<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Hotel;
use App\Models\User;
use App\Models\RoomFood;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomFacility;
use App\Models\HotelImage;
use App\Models\RoomImage;
use App\Models\Reception;
use App\Models\BookedRoom;
use Validator;
use App\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class HotelController extends ApiController
{
    private $request;

	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    public function addHotel(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            // 'password' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            // 'images' => 'array',
            // 'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        $hotel = new Hotel;
        $validate = $hotel->verifyData($validator);
        if($validate)
        {
            return $this->responseOkay($validate);
        }
        $input = $request->all();
        // dd($input);
        if($input)
        {
            $user = new User;
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->password =  bcrypt(123456);
            $user->type = 4;
            $user->is_verifyed = 0;
            $user->save();

            $hotelKey = Hotel::orderBy('id','DESC')->first();
            if(!$hotelKey)
            {
                $hotelKey['id'] = "0";
            }
            $hotel = new Hotel;
            $hotel->hotel_id = "NSN00".$hotelKey['id'];
            $hotel->name = $input['name'];
            $hotel->user_id = $user['id'];
            $hotel->state = $input['state_id'];
            $hotel->city = $input['city_id'];
            $hotel->partner_id = Auth::user()->id;
            $hotel['location'] = $input['address'];
            if(isset($input['is_online']))
            {
                $hotel['is_online']= $input['is_online'];
            }

            if(isset($input['early_check_in']))
            {
                $hotel->early_check_in = $input['early_check_in'];
            }

            if(isset($input['late_check_out']))
            {
                $hotel->late_check_out = $input['late_check_out'];
            }

            if(isset($input['latitude']))
            {
                $hotel->latitude = $input['latitude'];
            }
            if(isset($input['longitude']))
            {
                $hotel->longitude = $input['longitude'];
            }
            if(isset($input['location']))
            {
                $hotel->location = $input['location'];
            }
            if(isset($input['description']))
            {
                $hotel->description = $input['description'];
            }
            if(isset($input['image']))
            {
                $file = $data['image'];
                $path = public_path('/uploads');
                $fnn = "CI-".rand().'.'.$file->getClientOriginalExtension();
                $file->move($path, $fnn);
                $hotel->image = $fnn;
            }
            $hotel->save();

            $hotelArr = array();
            $hotelArr['hotel'][] = array();
            $hotelArr['hotel'] = $hotel;
            $response = [
                        'error' => false,
                        'message' => 'Hotel Added',
                        'data' => $hotelArr,
                    ];
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

	public function addRoom(Request $request)
	{
		$response = array();
		$i=1;
        $validator = Validator::make($request->all(), [
            'room_type' => 'required',
            'single_price' => 'required',
            'hotel_id' => 'required',
            // 'reception_id' => 'required',
            // 'double_price' => 'required',
            // 'three_price' => 'required',
            // 'four_price' => 'required',
        ]);
		$room = new Room;
        $validate = $room->verifyRoom($validator);
        if($validate)
        {
            return $this->responseOkay($validate);
        }
        $input = $request->all();
        if($input)
        {
            $roomArr = array();
            // if($input['number'] <= 20)
            // {
            	for($i=1; $i<=$input['number']; $i++)
                {
                    $findRoom = Room::where('hotel_id',$input['hotel_id'])->orderBy('id','DESC')->select('room_number')->first();
                    // dd($findRoom->toArray());
                     if(!$findRoom){
                         $findRoom['room_number'] = 0;
                     }

                    $newRoom = new Room;
                    $newRoom->room_number = $findRoom['room_number']+1;
                	$newRoom->room_type = $input['room_type'];
                	$newRoom->single_price = $input['single_price'];
                    if(isset($input['double_price']))
                    {
                        $newRoom->double_price = $input['double_price'];
                    }
                    if(isset($input['three_price']))
                    {
                        $newRoom->three_price = $input['three_price'];
                    }
                    if(isset($input['four_price']))
                    {
                        $newRoom->four_price = $input['four_price'];
                    }
                	$newRoom->partner_id = Auth::user()->id;
                    $newRoom->hotel_id = $input['hotel_id'];
                    $newRoom->is_active = 1;
                    $newRoom->reception_id = 0;
                    $newRoom->is_pet = $input['is_pet'];
                    if(isset($input['single_discount']))
                    {
                        $newRoom->single_discount = $input['single_discount'];
                    }
                    if(isset($input['double_discount']))
                    {
                        $newRoom->double_discount = $input['double_discount'];
                    }
                    if(isset($input['three_discount']))
                    {
                        $newRoom->three_discount = $input['three_discount'];
                    }
                    if(isset($input['four_discount']))
                    {
                        $newRoom->four_discount = $input['four_discount'];
                    }
                    $newRoom->save();
                	if($input['room_facility'])
                	{
                		$facilities = array();
                		$facilities['faclity'] = explode(',',$input['room_facility']);
                		foreach ($facilities['faclity'] as $facility)
                		{
                			$roomfacility = new RoomFacility;
                			$roomfacility->room_id = $newRoom->id;
                			$roomfacility->name = $facility;
                			$roomfacility->save();
                		}
                	}
                	if($input['room_food'])
                	{
                		$roomFoods = array();
                		$roomFoods['food'] = explode(',',$input['room_food']);
                		foreach ($roomFoods['food'] as $roomFood)
                		{
                			$roomfood = new RoomFood;
                			$roomfood->room_id = $newRoom->id;
                			$roomfood->name = $roomFood;
                			$roomfood->save();
                		}
                	}

                    $roomArr[] = $newRoom;
                    $response = [
                                'error' => false,
                                'message' => 'Room Added',
                                'data' => $roomArr,
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


    public function guestListByHotel(Request $request)
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
            $guestlistData = Booking::where('hotel_id',$data['hotel_id'])->where('check_in',1)->where('check_out',null)->get();
            foreach ($guestlistData as $curBooking)
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
                // $curbkngArr['is_online']= $hotel['is_online'];
                // $curbkngArr['early_check_in'] = $hotel['early_check_in'];
                // $curbkngArr['late_check_out'] = $hotel['late_check_out'];


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
                        'message' => 'Something went wrong',
                    ];
        }
        return $this->responseOkay($response);
    }


    // public function checkoutGuest(Request $request)
    // {
    //     $response = array();
    //     $validator = Validator::make($request->all(), [
    //         'hotel_id' => 'required',
    //     ]);
    //     $booking = new Booking;
    //     $validate = $booking->verifyBooking($validator);
    //     if($validate)
    //     {
    //         return $this->responseOkay($validate);
    //     }
    //     $data = $request->all();
    //     if($data)
    //     {
    //         $checkoutData = Booking::where('hotel_id',$data['hotel_id'])->where('updated_status','checked_out')->get();
    //         $response = [
    //                     'error' => false,
    //                     'message' => 'Success',
    //                     'data' => $checkoutData,
    //                 ];
    //     }

    //     else
    //     {
    //          $response = [
    //                     'error' => true,
    //                     'message' => 'Something went wrong',
    //                     'data' => null
    //                 ];
    //     }
    //     return $this->responseOkay($response);
    // }

    public function bookedunbookedList(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'date' => 'required',
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
            $bookedRoom = Booking::where('hotel_id',$data['hotel_id'])->where('booking_start_date','checked_out')->get();
            $response = [
                        'error' => false,
                        'message' => 'Success',
                        'data' => $bookedRoom,
                    ];
        }
        else
        {
            $response = [
                        'error' => true,
                        'message' => 'Something went wrong',
                    ];

        }
    }

    public function bookingListByHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
        ]);

        $bookArr =  array();
        //$bookdArr = array();
        $curbkngArr = array();

        $booking = new Booking;
        $validate = $booking->verifyBooking($validator);
        if($validate)
        {
            return $this->responseOkay($validate);
        }
        $data = $request->all();
        if($data)
        {
            // $listBookings = Booking::where('hotel_id',$data['hotel_id'])->where('current_status','booked')->where('updated_status','!=','cancel')->orWhere('updated_status',null)->orderBy('created_at','DESC')->get();
            $listBookings = Booking::where('hotel_id',$data['hotel_id'])->where('current_status','booked')->where('updated_status',null)->where('check_in',null)->where('check_out',null)->orderBy('created_at','DESC')->get();
            foreach ($listBookings as $curBooking)
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
                // $curbkngArr['is_online']= $hotel['is_online'];
                // $curbkngArr['early_check_in'] = $hotel['early_check_in'];
                // $curbkngArr['late_check_out'] = $hotel['late_check_out'];


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
                $curbkngArr['is_online']= $curBooking['is_online'];
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
                        'message' => 'Something went wrong',
                        'data' => null,
                    ];
        }
        return $this->responseOkay($response);
    }



    public function uploadImage(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'room_id' => 'required',
            // 'images' => 'array',
            // 'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        $data = $request->all();
        if($data)
        {
            // dd($data);
            $roomId = array();
            $roomId['id'] = explode(',',$data['room_id']);
            $file = $data['image'];
            $path = public_path('/uploads');
            $fnn = "RM-".rand().'.'.$file->getClientOriginalExtension();
            $file->move($path, $fnn);
            foreach ($roomId['id'] as $room_id)
            {
                $roomimage = new RoomImage;
                $roomimage->image_name = $data['name'];
                $roomimage->images = $fnn;
                $roomimage->hotel_id = $data['hotel_id'];
                $roomimage->room_id = $room_id;
                $roomimage->save();
            }
            $response = [
                        'error' => false,
                        'message' => 'Image Added',
                    ];
        }
        else
        {
             $response = [
                        'error' => true,
                        'message' => 'Something went wrong',
                    ];
        }
        return $this->responseOkay($response);
    }


    // By Hotel/Partner


    // public function viewCheckinByHotel(Request $request)
    // {
    //     $response = array();
    //     $user = Auth::user();
    //     $guestlistData = array();
    //     $hotels = Hotel::where('partner_id',$user['id'])->get();
    //     foreach ($hotels as $hotel)
    //     {
    //         $guestlistDat = Booking::where('hotel_id',$hotel['id'])
    //                     ->where('current_status','check_in')
    //                     ->where('updated_status',null)
    //                     ->get();
    //     }
    //     $response = [
    //                     'error' => false,
    //                     'message' => 'Success',
    //                     'data' => $guestlistData,
    //                 ];
    //     else
    //     {
    //         $response = [
    //             'error' => true,
    //             'message' => 'Something went wrong',
    //             'data' => null,
    //         ];
    //     }
    //     return $this->responseOkay($response);
    // }

    public function viewCancleByHotel(Request $request)
    {
        $response = array();
        $curbkngArr = array();
        $bookdArr = array();
        $bookArr = array();
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
        ]);
        $data = $request->all();
        if($data)
        {
            $bookings = Booking::where('hotel_id',$data['hotel_id'])->where('updated_status','cancel')->get();
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
                // $curbkngArr['is_online']= $hotel['is_online'];
                // $curbkngArr['early_check_in'] = $hotel['early_check_in'];
                // $curbkngArr['late_check_out'] = $hotel['late_check_out'];

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
                $curbkngArr['is_online']= $curBooking['is_online'];
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
                'message' => 'Something went wrong',
                'data' => null
            ];
        }
        return $this->responseOkay($response);
    }

    public function checkoutListByHotel(Request $request)
    {
        $response = array();
        $curbkngArr = array();
        $bookdArr = array();
        $bookArr = array();

        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
        ]);
        $data = $request->all();
        if($data)
        {
            $checkout = Booking::where('hotel_id',$data['hotel_id'])->where('updated_status','checkout')->where('check_out',1)->get();
            foreach ($checkout as $curBooking)
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
                $curbkngArr['is_online']= $curBooking['is_online'];
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
                    'message' => 'Something went wrong',
                    'data' => null,
                ];
        }
        return $this->responseOkay($response);
    }

    public function completedBookingByHotel(Request $request)
    {
        $response = array();
        $curbkngArr = array();
        $bookdArr = array();
        $bookArr = array();

        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
        ]);
        $data = $request->all();
        if($data)
        {
            $booking = Booking::where('hotel_id',$data['hotel_id'])
                        ->where('check_in',1)
                        ->where('check_out',1)
                        ->where('updated_status','checkout')
                        ->get();

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
                $curbkngArr['is_online']= $curBooking['is_online'];
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
                'message' => 'Something went wrong',
                'data' => null
                ];
        }
        return $this->responseOkay($response);
    }

    public function getRoomList(Request $request)
    {
        $response = array();
        $roomArr = array();
        $finalArr = array();
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'partner_id' => 'required',
        ]);

        $data = $request->all();
        if($data)
        {
            $rooms = Room::where('hotel_id',$data['hotel_id'])->where('partner_id',$data['partner_id'])->get();
            if(count($rooms) > 0 )
            {
                foreach ($rooms as $room)
                {
                    $roomArr['id'] = $room['id'];
                    $roomArr['room_number'] = $room['room_number'];
                    $roomArr['room_type'] = $room['room_type'];
                    $roomArr['single_price'] = $room['single_price'];
                    $roomArr['double_price'] = $room['double_price'];
                    $roomArr['three_price'] = $room['three_price'];
                    $roomArr['four_price'] = $room['four_price'];
                    $roomArr['hotel_id'] = $room['hotel_id'];
                    $roomArr['partner_id'] = $room['partner_id'];
                    // $roomArr['reception_id'] = $room['reception_id'];
                    $roomArr['is_active'] = $room['is_active'];
                    $roomArr['is_booked'] = $room['is_booked'];
                    $roomArr['is_pet'] = $room['is_pet'];
                    $roomArr['single_discount'] = $room['single_discount'];
                    $roomArr['double_discount'] = $room['double_discount'];
                    $roomArr['three_discount'] = $room['three_discount'];
                    $roomArr['four_discount'] = $room['four_discount'];
                    $faclity = RoomFacility::where('room_id',$room['id'])->select('name')->get();
                    $roomArr['faclity'] = $faclity;
                    $food = RoomFood::where('room_id',$room['id'])->select('name')->get();
                    $roomArr['food'] = $food;
                    $finalArr[] = $roomArr;
                }
                $response = [
                    'error' => false,
                    'message' => 'success',
                    'data' => $finalArr,
                ];
            }
            else
            {
                $response = [
                    'error' => true,
                    'message' => 'Rooms not found',
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

    public function getReceptionList(Request $request)
    {
        $response = array();
        $recArr = array();
        $finalArr = array();
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'partner_id' => 'required',
        ]);

        $data = $request->all();
        if($data)
        {
            $receptions = Reception::where('hotel_id',$data['hotel_id'])->where('partner_id',$data['partner_id'])->get();

            if(count($receptions)>0)
            {
                foreach ($receptions as $reception)
                {
                    $hotel = Hotel::find($reception['hotel_id']);
                    $user = USer::find($reception['partner_id']);
                    $recArr['id'] = $reception['id'];
                    $recArr['name'] = $reception['name'];
                    $recArr['phone'] = $reception['phone'];
                    $recArr['latitude'] = $reception['latitude'];
                    $recArr['longitude'] = $reception['longitude'];
                    $recArr['location'] = $reception['location'];
                    $recArr['hotel_name'] = $hotel['name'];
                    $recArr['partner_name'] = $user['name'];
                    $recArr['email'] = $user['email'];
                    $recArr['is_online']= $hotel['is_online'];
                    $finalArr[] = $recArr;
                }

                $response = [
                    'error' => false,
                    'message' => 'success',
                    'data' => $finalArr
                ];
            }
            else
            {
                $response = [
                    'error' => true,
                    'message' => 'Unable to find Reception(s)',
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
}
