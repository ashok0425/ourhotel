<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\TourBooking;
use App\Service\InteraktService;
use App\Service\InterktService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class BookingCancelNotifyViaWP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */


    protected $bookingId;
    protected $type;


    public function __construct($bookingId,$type='property')
    {
        $this->bookingId=$bookingId;
        $this->type=$type;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $interktService=new InteraktService();

        if ($this->type=='tour') {
      $booking= TourBooking::findOrFail($this->bookingId);
        }else{
            $booking= Booking::findOrFail($this->bookingId);
        }
    $res= $interktService->sendBookingCanelMsg('91'.$booking->user->phone_number,$booking->user->name??$booking->name??'user',$booking->booking_id);
     $interktService->sendBookingCanelMsg('919958277997',$booking->user->name??$booking->name??'user',$booking->booking_id);


    }
}
