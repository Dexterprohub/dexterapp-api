<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Message;
use App\Events\NewMessageNotification;

class NewMessageController extends Controller
{
     public function send()
    {

        // message is being sent 

        //$message = new Message;

        //$message->setAttribute('from', 1);

        //$message->setAttribute('to', 2);

        //$message->setAttribute('message', 'Demo message from user 1 to user 2');

        //$message->save();

        
        // want to broadcast NewMessageNotification event 
        //event(new NewMessageNotification($message));
        // ... 
    }
}
