<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourBookingEmail extends Notification
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
        $booking=$this->booking;
        $booking_start=\Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y');
        $booking_end=\Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y');

        return (new MailMessage)
                    ->subject('Tour Booking Detail with NSNHotels.')
                    ->line('Thank you for booking Tour with NSNHotels.')
                    ->line('Your Booking details is mentioned below')
                    ->line("Tour Name: $booking->tour_name")
                    ->line("Customer Name: $booking->name")
                    ->line("Phone Number: $booking->phone_number")
                    ->line("Email Adress: $booking->email")
                    ->line("Number of Adult: $booking->no_of_adult")
                    ->line("Number of Children: $booking->no_of_child")
                    ->line("Start Date: $booking_start")
                    ->line("End Date: $booking_end")
                    ->line("Total Amount: $booking->amount")
                    ->line("Paid Amount: $booking->paid_amount")
                    ->line("Remark: $booking->remark");

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
