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
use Illuminate\Support\Facades\Log;

class CheckinNotifyViaWP implements ShouldQueue
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
    $res= $interktService->sendCheckinMsg('91'.$booking->user->phone_number,$booking->user->name??$booking->name??'user',$booking->booking_id);
     $interktService->sendCheckinMsg('919958277997',$booking->user->name??$booking->name??'user',$booking->booking_id);
Log::info($res);

    }
}
