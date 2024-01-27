<?php

namespace App\Http\Controllers;

use App\Events\EventTest;
use Illuminate\Http\Request;

class TebsocketsTest extends Controller
{
    function send_msg(Request $r){
         $message = $r->message;
        // Broadcast the message
        broadcast(new EventTest($message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }
}
