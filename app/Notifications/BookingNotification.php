<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Message;

class BookingNotification extends Notification
{
    use Queueable;
    
    public $booking;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){

    }

    // public function toFcm($notifiable){
    //     $message = new Message();
    //     $message->setNotification([
    //         'title' => 'New Booking Request',
    //         'body' => 'A new booking request has been made for your service.',
    //     ]);
        
    //     $message->setData([
    //         'booking_id' => $this->booking->id,
    //     ]);
    //     return $message;
    // }

   

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
