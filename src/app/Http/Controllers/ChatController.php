<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\TestPush;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::all();
        $userId = Auth::id();
        return view('chat.chat', compact('messages', 'userId'));
    }

    public function store(Request $request)
    {
        $request-> validate([
            'message' => 'required|string|max:255',
        ]);

        $chatMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'created_at' => now(),
        ]);

        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->get();
        foreach ($users as $user) {
            $user->notify(new TestPush(
                '新しいメッセージが届きました',
                 $request->message,
                 'http://localhost:8080/chat',
                 $currentUserId
                ));
        }

        return redirect()->route('chat.chat');
    }
}
