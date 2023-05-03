<?php

namespace App\Http\Controllers;

use App\Libraries\Push;
use App\Http\Requests\CreateNotificationRequest;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Libraries\Firebase;
use Illuminate\Support\Facades\Broadcast;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\FcmMessage;
class NotificationController extends Controller
{

  public function sendPushNotification(Request $request)
    {
        $fcmToken = $request->input('fcm_token');
        
        $notificationTitle = $request->input('notification_title');
        
        $notificationMessage = $request->input('notification_message');
        
        $notificationData = $request->input('notification_data');
        
        try {
            // Create a new instance of the PushNotification notification
            $notification = new SendPushNotification($notificationTitle, $notificationMessage, $notificationData);
            
            // Send the notification to the user's FCM token
            Notification::route('fcm', $fcmToken)->notify($notification);
            // return 'hi';

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Push notification sent successfully.'
            ]);
        } catch (MessagingException $e) {
            // Log the error message and return an error response
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send push notification.'
            ], 500);
        }
    }


    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function updateFcmToken(Request $request)
    {
        $user = Auth::user();
        $user->fcm_token = $request->input('fcm_token');
        $user->save();

        return response()->json(['message' => 'FCM token updated successfully.']);
    }

    //
    // public function notify(){

    //     $data = json_decode(\request()->getContent());
        
    //     //$sender                 = $data->sender_user;
    //     $receiver               = $data->receiver_user;
    //    // $notification_payload   = $data->payload;
    //     $notification_title     = $data->title;
    //     $notification_message   = $data->message;
    //     $notification_push_type = $data->push_type;
    //     $notification_image = $data->image;

    //     try{
    //        // $sender_id = $sender;
            
    //         $receiver_id = $receiver;

    //         $firebase = new Firebase();
    //         $push = new Push();

    //         // optional payload

    //         //$payload = $notification_payload;

    //         $title = $notification_title ?? '';

    //         //notification message
    //         $message = $notification_message ?? '';

    //         //push type - single user / topic
    //         $push_type = $notification_push_type ?? '';

    //         $push->setTitle( $title );
    //         $push->setMessage( $message );
    //        // $push->setPayload( $payload );

    //         $datajson=[
    //             "to" => $receiver_id,
    //             "notification" => [
    //                 "title" => $notification_title ,
    //                 "body" => $notification_message,
    //                 "image" => $notification_image
    //             ],
    //             // "data" => [
    //             //     "ANYTHING EXTRA HERE"
    //             // ]
    //             ];

    //         $json     = '';
    //         $response = '';

    //         if( $push_type === 'topic' ){
    //             $json     = $datajson;//$push->getPush();
    //             $response = $firebase->sendToTopic($receiver_id, $json["notification"]);//'global', $json);
    //             return response()->json([
    //                 'response' => $response
    //             ]);
    //         }else if($push_type === 'individual' ){
    //             $json     = $push->getPush();
    //             $regId    = $receiver_id ?? '';
    //             $response = $firebase->send($regId, $json);

    //             return response()->json([
    //                 'response' => $response
    //             ]);
    //         }


            

    //     }catch ( \Exception $ex ) {
    //         return response()->json( [
    //            'error'   => true,
    //            'message' => $ex->getMessage()
    //         ] );
    //      }
    // }


//   /**
//    * Handle request to delete notification
//    *
//    * @param \App\Models\SystemNotification $system_notification
//    *
//    * @return RedirectResponse
//    * @author Abdullah Al-Faqeir <abdullah@devloops.net>
//    */
//   public function deleteNotification(\App\Models\SystemNotification $system_notification): ?RedirectResponse {
//     try {
//       $system_notification->delete();
//       /**
//        * delete users & drivers notifications as well.
//        */
//       DatabaseNotification::with('type', '=', \App\Models\SystemNotification::class)->delete();

//       return redirect()->to(route('admin.notifications.index'))
//         ->with('success', __('Notification deleted.'));
//     } catch (Exception $exception) {
//       return redirect()->to(route('admin.notifications.index'))
//         ->withErrors([__('Could not delete notification.')]);
//     }
//   }

//   /**
//    * Return admin menu
//    *
//    * @return array
//    * @author Abdullah Al-Faqeir <abdullah@devloops.net>
//    */
//   public static function getMenu(): array {
//     return [
//       [
//         'text' => 'NOTIFICATIONS',
//         'order' => 4,
//         'permission' => 'manage-notifications',
//         'icon' => 'fa fa-bell',
//         'submenu' => [
//           [
//             'text' => 'Notifications List',
//             'route' => 'admin.notifications.index',
//             'icon' => 'fa fa-bell',
//             'permission' => 'view-notifications',
//           ],
//           [
//             'text' => 'Send Notification',
//             'route' => 'admin.notifications.create',
//             'icon' => 'fa fa-plus-square',
//             'permission' => 'send-notifications',
//           ],
//         ],
//       ],
//     ];
//   }
}