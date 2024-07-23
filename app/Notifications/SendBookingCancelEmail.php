<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendBookingCancelEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   protected  $booking;

    public function __construct($booking)
    {
        $this->booking=$booking;
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
        $url=route('recipt',['uuid'=>$this->booking->uuid]);
        $bookingId=$this->booking->booking_id;

        return (new MailMessage)
                    ->subject('Booking Cancellation Notify.')
                    ->line("Your booking ($bookingId) with NSNHotels is cancelled.")
                    ->line('Click link below to view your receipt .')
                    ->action('click here',url($url))
                    ->line('Thank you for booking hotel with NSNHotels');

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
