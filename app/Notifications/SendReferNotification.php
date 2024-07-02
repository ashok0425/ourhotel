<?php

namespace App\Notifications;

use App\Models\ReferPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendReferNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $name;
    protected $code;

    public function __construct($name,$code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $referPrice=ReferPrice::first();
        return (new MailMessage)
                    ->line("Hello $this->name")
                    ->line("Use refer code $this->code to get $referPrice->join_price in your NSN wallet.")
                    ->line("Use refer code $this->code to get $referPrice->join_price in your NSN wallet or click the below link")
                    ->action("Click here",route('user_register',['q'=>'NSN' . $this->code]))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
