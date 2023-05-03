<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
// use Kreait\Laravel\Firebase\Facades\Firebase;
use NotificationChannels\Firebase\FirebaseMessagingChannel;
use NotificationChannels\Firebase\FirebaseMessage;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

use Kreait\Firebase\Facades\Firebase;


use App\Models\User;
use App\Models\Vendor;
use App\Models\Checkout;
class OrderPlacedNotification extends Notification
{
    use Queueable;
    private $checkout;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->checkout = $checkout;
        // $this->vendor = $vendor;
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

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('support@getdexterapp.com', 'Suppport')
            ->subject('Welcome To Dexterapp')
            ->greeting("Hello ")
            ->line('Welcome to dexterapp')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!')
        ;
    }


    // public function toFirebase($notifiable)
    // {

    //     $vendorFcmToken =  $this->checkout->shop->vendor->first_name; //vendorFcmTokens->pluck('token')->toArray();
    //     // $userFcmTokens = $this->order->user->fcmTokens()->pluck('token')->toArray();
    //     // $vendor_device_tokens = VendorDeviceToken::where('vendor_id', $this->order->restaurant->vendor_id)->get();

    //     $data = [
    //         // 'type' => 'new_order',
    //         // 'order_id' => $this->order->id,
    //         // 'checkout_id' => $this->checkout->id,
    //         // 'customer_name' => $this->checkout->user->first_name,
    //         // 'shop_name' => $this->checkout->shop->name,
    //         // 'total_amount' => $this->checkout->total_amount,
    //         // add any additional order data here
    //     ];


        
    //     $message = CloudMessage::withTarget('token', $vendorFcmToken)->withNotification(FirebaseNotification::create(
    //             'New order received',
    //             'You have received a new order from '.$this->checkout->user->first_name.' '.$this->checkout->user->last_name, 
    //         ))->withData([
    //             'type' => 'order',
    //             'order_id' => $this->checkout->id,
    //         ]);
    //     return $message;
    // }

    //  public function toFcm($notifiable)
    // {
    //     return FcmMessage::create()
    //         ->setData([
    //             'title' => 'New order!',
    //             'body' => 'You have a new order waiting for you.'
    //         ])
    //         ->setNotification([
    //             'title' => 'New order!',
    //             'body' => 'You have a new order waiting for you.'
    //         ]);
    // }

   
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
        
    //     return [
    //         // 'title' => 'Your order details',
    //         // 'Subtotal before discount' => $this->food->restaurant->discount,
    //         // 'product_quantity' => $this->quantity,
    //         // 'discount' => $this->food->restaurant->discount,
    //         // 'subtotal_before_discount' => $this->food,
    //         // 'delivery_fee' => $this->food->restaurant->delivery_fee,

    //         // 'Total' => $this->total_amount,
    //         // 'delivery_address' => $this->address,
    //         // 'vendor' => $this->food->restaurant->name,
    //         // 'order_number' => $this->order_number,
    //        'returned data' => 'this data',
    //        'user is' => $this->checkout->user->first_name,
    //     ];
    // }

    // public function toBroadcast($notifiable){
    //     return new BroadcastMessage([
    //         'order_number' =>$this->order_number,
    //         'quantity' =>$this->quantity
    //     ]);
    // }
}
