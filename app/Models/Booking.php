<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts=[
        'hotel_data'=>'array',
        'total_price'=>'string'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function property(){
        return $this->belongsTo(Property::class,'property_id','id');
    }

    public function bookedBy(){
        return $this->belongsTo(User::class,'booked_by','id');
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    static function getBookingId()  {
            // Gets the booking id from the database and adds one to it.
            $bookingId = Booking::max('id');
            return 'NSN'.rand(100,9999999).'0'.$bookingId + 1 ;
    }

}
