<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Service\SmsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BookingNotifyViaMsg implements ShouldQueue
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
        $booking= Booking::findOrFail($this->bookingId);

        $phone=$booking->phone_number;
        $partner_name=$booking->property?->name??$booking->hotel_data['name'];
        $partner_phone=$booking->property?->owner?->phone_number??$booking->hotel_data['phone_number']??null;

        $checkin=$booking->booking_start;
        $checkout=$booking->booking_end;
        $adult=$booking->no_of_adult;
        $price=$booking->final_amount;
        $child=$booking->no_of_child;
        $payment_type=$booking->payment_type;
        $no_of_room=$booking->no_of_room;
        $booking_id=$booking->booking_id;
        $from  =Carbon::parse($booking->booking_start);
        $to = Carbon::parse($booking->booking_end);
        $number_of_night = $from->diffInDays($to);
        $smsService=new SmsService();

        if($partner_phone){
        $smsService->sendBookingMsg($partner_phone,$partner_name,$checkin,$checkout,$number_of_night,$adult,$child,$price,$payment_type,$no_of_room,$booking_id);
        }
       $smsService->sendBookingMsg($phone,$partner_name,$checkin,$checkout,$number_of_night,$adult,$child,$price,$payment_type,$no_of_room,$booking_id);
        $smsService->sendBookingMsg('9958277997',$partner_name,$checkin,$checkout,$number_of_night,$adult,$child,$price,$payment_type,$no_of_room,$booking_id);

    }
}
