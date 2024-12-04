<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\TestPush;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRoom;

class ChatRoomController extends Controller
{
    public function index(Request $request)
    {
        // $chatroom = ChatRoom::all();
        // $chatroomcreated = ChatRoom::create([
        //     'room_id' => Auth::id(),
        //     'user_id' => Auth::id(),
        //     'message' => $request->message,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // $chatroomdeleted = ChatRoom::delete([
        //     'room_id' => Auth::id(),
        //     'user_id' => Auth::id(),
        //     'message' => $request->message,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // $chatroomupdated = ChatRoom::update([
        //     'room_id' => Auth::id(),
        //     'user_id' => Auth::id(),
        //     'message' => $request->message,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        $messages = ChatMessage::all();
        $userId = Auth::id();
        return view('chat.chat', compact('messages', 'userId'));
    }
}
