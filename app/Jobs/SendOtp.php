<?php

namespace App\Jobs;

use App\Models\User;
use App\Service\InteraktService;
use App\Service\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $phone;
    protected $country_code;
    protected $signature;


    public function __construct($country_code,$phone,$signature=null)
    {
        $this->phone=$phone;
        $this->country_code=$country_code;
        $this->signature=$signature;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $otp=str_pad(rand(1,1000000),6,'0');
        $user = User::where('phone_number','=',$this->phone)->update(['otp' => $otp]);
        if($user){
            $InteraktService=new InteraktService();
           $res= $InteraktService->sendOtp($this->country_code.$this->phone,$otp,$this->signature);
           Log::info($res);
            $smsService=new SmsService();
            $sms=$smsService->sendOtpMessage($this->country_code.$this->phone,$otp,$this->signature);
            Log::info($sms);
        }
    }
}
