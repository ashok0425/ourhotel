<?php

namespace App\Http\Controllers\Common;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\BookingNotifyViaMsg;
use App\Jobs\BookingNotifyViaWP;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Category;
use App\Models\City;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $properties = Property::query()->orderBy('id', 'desc')
        ->when(Auth::user()->is_partner,function($query) {
                $query->where('owner_id',Auth::user()->id );
           })
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->keyword%");
            })->when($request->city, function ($query) use ($request) {
                $query->where('city_id', $request->city);
            })->paginate(15);
        $cities = City::query()->pluck('name', 'id');
        return view('common.property.index', compact('properties', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where('status', 1)->get();
        $propertyTypes = PropertyType::where('status', 1)->get();
        $amenities = Amenity::where('status', 1)->get();
        $partners = User::where('is_partner', 1)->get();
        $states = State::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();

        return view('common.property.create', compact('cities', 'states', 'propertyTypes', 'amenities', 'partners', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:225',
            'thumbnail' => 'required|max:2048',
            'address' => 'required',
            'latitude' => 'required',
            'latitude' => 'required',
            'price_range' => 'required',
            'description' => 'required',
        ]);

        $path = $this->uploadImage($request->thumbnail);
        $hotelId = Property::latest()->first()->id;
        $slug = Str::slug($request->name);
        $property = new Property;
        $property->name = $request->name;
        $property->hotel_id = 'NSN' . rand(1, 1000000000) . $hotelId;
        $property->city_id = $request->city;
        $property->owner_id = $request->partner;
        $property->property_type_id = $request->propertyType;
        $property->category_id = $request->category;
        $property->slug = $slug;
        $property->status = $request->status;
        $property->state_id = $request->state;
        $property->description = $request->description;
        $property->amenities = $request->amenity??[];
        $property->longitude = $request->longitude;
        $property->latitude = $request->latitude;
        $property->address = $request->address;
        $property->price_range = $request->price_range;
        $property->rating = rand(4, 5);
        $property->pet_friendly = $request->pet_friendly ? $request->pet_friendly : 0;
        $property->couple_friendly = $request->couple_friendly ? $request->couple_friendly : 0;
        $property->top_rated = $request->top_rated ? $request->top_rated : 0;
        $property->meta_keyword = $request->meta_keyword;
        $property->meta_title = $request->meta_title;
        $property->meta_description = $request->meta_description;
        $property->mobile_meta_keyword = $request->mobile_meta_keyword;
        $property->mobile_meta_title = $request->mobile_meta_title;
        $property->mobile_meta_description = $request->mobile_meta_description;
        $property->thumbnail = $path;
        //    $property->gallery=$request->gallery;
        $property->save();
        $notification = array(
            'type' => 'success',
            'message' => 'Property Create Sucessfully'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('user_id',Auth::user()->id)->where('id',$property->id)->firstOrFail();
        }
        $partners = User::where('is_partner', 1)->get();
        $cities = City::where('status', 1)->get();
        $propertyTypes = PropertyType::where('status', 1)->get();
        $amenities = Amenity::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $states = State::where('status', 1)->get();

        return view('common.property.edit', compact('property', 'partners', 'cities', 'propertyTypes', 'amenities', 'categories', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('user_id',Auth::user()->id)->where('id',$property->id)->firstOrFail();
        }
        $request->validate([
            'name' => 'required|max:225',
            'address' => 'required',
            'latitude' => 'required',
            'latitude' => 'required',
            'price_range' => 'required',
            'description' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $path = $this->uploadImage($request->thumbnail);
        $property->name = $request->name;
        $property->city_id = $request->city;
        $property->owner_id = $request->partner;
        $property->property_type_id = $request->propertyType;
        $property->slug = $slug;
        $property->status = $request->status;
        $property->description = $request->description;
        $property->amenities = $request->amenity;
        $property->longitude = $request->longitude;
        $property->latitude = $request->latitude;
        $property->address = $request->address;
        $property->category_id = $request->category;
        $property->price_range = $request->price_range;
        $property->pet_friendly = $request->pet_friendly ? $request->pet_friendly : 0;
        $property->couple_friendly = $request->couple_friendly ? $request->couple_friendly : 0;
        $property->top_rated = $request->top_rated ? $request->top_rated : 0;
        $property->meta_keyword = $request->meta_keyword;
        $property->meta_title = $request->meta_title;
        $property->meta_description = $request->meta_description;
        $property->mobile_meta_keyword = $request->mobile_meta_keyword;
        $property->mobile_meta_title = $request->mobile_meta_title;
        $property->mobile_meta_description = $request->mobile_meta_description;
        $property->state_id = $request->state;

        $property->full_booked_from = $request->booked_from;

        $property->full_booked_to = $request->booked_to;

        $property->is_full_booked = $request->booked_to && $request->booked_from ? 1 : 0;


        $property->thumbnail = $path ? $path : $property->thumbnail;

        if (isset($request->gallery)) {
            $gallery = $property->gallery;
            $gallery = $gallery ? array_merge($gallery, $request->gallery) : $request->gallery;
            $property->gallery = $gallery;
        }
        $property->save();
        $notification = array(
            'type' => 'success',
            'message' => 'Property Updated Sucessfully'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('user_id',Auth::user()->id)->where('id',$property->id)->firstOrFail();
        }
        $property->delete();
        $notification = array(
            'type' => 'success',
            'message' => 'Property Deleted Sucessfully'
        );
        return redirect()->back()->with($notification);
    }


    public function getCity($stateId)
    {
        $cities = City::where('state_id', $stateId)->select('name', 'id')->get();
        return response()->json($cities);
    }

    public function addBooking($property_id=null)
    {
        return  view('common.property.addbooking', compact('property_id'));
    }

    public function storeBooking(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'phone' => 'required'
        ]);

        $user = User::updateOrCreate(
            ['phone_number' => $request->phone],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('Nsn@' . rand(1, 99999999))
            ]
        );



        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->property_id = $request->property_id ?? 0;
        $booking->booking_start = $request['check_in'];
        $booking->booking_id = Booking::getBookingId();
        $booking->booking_end = $request['check_out'];
        $booking->no_of_room = $request['rooms'];
        $booking->no_of_adult = $request['adult'];
        $booking->final_amount = $request['price'];
        $booking->total_price = $request['price'];
        $booking->payment_type = $request['payment_type'];
        $booking->room_type = $request['room_type'];
        $booking->booking_type = $request['booking_type'];
        $booking->uuid = Str::uuid();
        $booking->is_paid  = $request->is_paid ? 1 : 0;
        $booking->booked_by  = Auth::user()?->id ?? 1;
        $booking->status  = 2;
        $booking->name = $request->name;
        $booking->phone_number = $request->phone;
        $booking->hotel_data=[
            'name'=>$request->hotel_name,
            'address'=>$request->hotel_address,
            'phone_number'=>$request->hotel_phone
        ];

        $booking->save();

        dispatch(new BookingNotifyViaWP($booking->id));
        dispatch(new BookingNotifyViaMsg($booking->id));

        $notification = array(
            'type' => 'success',
            'message' => 'Booking create successfully'
        );



        return redirect()->back()->with($notification);
    }


    public function status(Request $request)
    {
        $property= Property::findorFail($request->property_id);
        if (!Auth::user()->is_admin&&!Auth::user()->is_agent) {
            Property::where('owner_id',Auth::user()->id)->where('id',$property->id)->firstOrFail();
        }

        $property->status=$request->status;
        $property->save();
        $notification=array(
            'type'=>'success',
             'message'=>'Booking satus updated Sucessfully'
           );
           return redirect()->back()->with($notification);
    }
}
