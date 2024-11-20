<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\TestPush;

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

        $user = auth()->user();
        if ($user) {
            $user->notify(new TestPush('新しいメッセージが届きました', $request->message, route('chat.chat')));
        }

        return redirect()->route('chat.chat');
    }
}
