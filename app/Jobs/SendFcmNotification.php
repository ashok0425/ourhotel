<?php

namespace App\Jobs;

use App\Models\FcmNotification;
use App\Models\User;
use App\Service\FcmService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFcmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
   public  $id;
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fcm=FcmNotification::find($this->id);

        $users=User::whereIn('id',$fcm->userIds)->chunk(20,function($users) use ($fcm){
            $tokens=[];

            foreach ($users as $key => $value) {
             array_push($tokens,$value->fcm_token);
             array_push($tokens,$value->app_fcm_token);
            }

            $fcmService=new FcmService();
           $res= $fcmService->send($fcm->title,$fcm->body,$tokens);
        });

    }
}
