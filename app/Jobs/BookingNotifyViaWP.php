<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Service\InteraktService;
use App\Service\InterktService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class BookingNotifyViaWP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $bookingId;



    public function __construct($bookingId)
    {
        $this->bookingId=$bookingId;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $interktService=new InteraktService();

                $booking= Booking::findOrFail($this->bookingId);
                $hotelName=$booking->property?->name??$booking->hotel_data['name'];
                $checkin = Carbon::parse($booking->booking_start)->format('d M,Y');
                $checkout = Carbon::parse($booking->booking_end)->format('d M,Y');
                $amount = $booking->final_amount;
                $adult = $booking->no_of_adult;
                $no_of_room = $booking->no_of_room;
                $no_of_child = $booking->no_of_child;
                $from  =Carbon::parse($booking->booking_start);
                $to = Carbon::parse($booking->booking_end);
                $number_of_night = $from->diffInDays($to);
                $booking_id = $booking->booking_id;
                $partner_address=$booking->property?->address??$booking->hotel_data['address'];

                $data = "Hotel Name: $hotelName, Check-in Date: $checkin 12pm onwards, Check-out Date: $checkout 11 am, Number of Rooms:$no_of_room, Number of Nights: $number_of_night, Number of Adult:-$adult, Number of Children: $no_of_child, Booking Amount: $amount, Hotel Address: $partner_address";
                $phone='91'.$booking?->property?->owner?->phone_number??$booking->hotel_data['phone'];
                // $interktService->sendBookingMsg($phone,$booking->name,$booking_id,$data);
                // $interktService->sendBookingMsg('919958277997',$booking->name,$booking_id,$data);
               $res= $interktService->sendBookingMsg('91'.$booking->user->phone_number,$booking->name,$booking_id,$data);

    }
}
