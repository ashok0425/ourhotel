<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    static function getBookingId()  {
        // Gets the booking id from the database and adds one to it.
        $bookingId = Booking::max('id');
        return 'NSN'.rand(100,9999999).'0'.$bookingId + 1 ;
}

public function user(){
    return $this->belongsTo(User::class);
}
}
