<?php

namespace App\Http\Controllers;

use App\Events\MessageDelivered;
use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\GenericUser;
 use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('message.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $msg= new Message();
        $msg->body = $request->body;
        $msg->user_id=1;
        $msg->save();
         // $msg = Auth::id()->messagesfunc()->create($request->all());
         broadcast(new MessageDelivered($msg))->toOthers();
        //  event(new MessageDelivered($msg));
    }
}
