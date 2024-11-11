<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::all();
        return view('chat.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $request-> validate([
            'message' => 'required|string|max:255',
        ]);

        ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'created_at' => now(),
        ]);

        return redirect()->route('chat.chat');
    }
}
