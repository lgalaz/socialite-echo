<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::all();
    }

    public function store(Request $request)
    {
        $message = new Message;

        $message->message = $request->message;

        $message->save();

        event(new MessageCreated($message));

        return $message;
    }
}
