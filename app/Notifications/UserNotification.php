<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable, Notifiable;
    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $user = $this->order->user;
        // $username = $user->first_name;
        // $name = $user->first_name . ' ' . $user->last_name;
        // $address = $this->order->address;

        // $food = $this->order->food;

        // $food_name = $food->name;
        // $food_price = $food->price;
        // $food_quantity = $this->order->quantity;
        
        // return (new MailMessage)
            // ->line('Hello ' . $username,)
            // ->line('Thanks for ordering with Dexterapp. We are preparing your order now. Kindly note that orders accepted by vendors cannot be canceled. Click here for more information. ')
            // ->action('Notification Action', url('/'))

            // ->line('Customer information')
            // ->line($name)
            // ->line(' ')
            // ->line($address)
            // ->line('Information about your order')
            // ->line($food_quantity. ' X '. $food_name . ' ' . $food_price)
           
            // ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'Order Placed. Our riders will get to you as soon as possible'
        ];
    }

    // public function toBroadcast($notifiable){
    //     return new BroadcastMessage([
    //         'order_number' =>$this->order_number,
    //         'quantity' =>$this->quantity
    //     ]);
    // }
}
