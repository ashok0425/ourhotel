<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendBookingEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   protected  $booking_id;

    public function __construct($booking_id)
    {
        $this->booking_id=$booking_id;
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
        return (new MailMessage)
                    ->subject('Booking Detail with NSNHotels.')
                    ->line('Thank you for booking hotel with NSNHotels.')
                    ->view('common.booking.print', ['booking_id'=>$this->booking_id]);

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
