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
            'user_id' => auth()->id(),
            'message' => $request->message,
            'created_at' => now(),
        ]);

        $currentUserId = auth()->id();
        $users = User::where('id', '!=', $currentUserId)->get();
        foreach ($users as $user) {
            \Log::info('Sending notification to user: ' . $user->id);
            $user->notify(new TestPush(
                '新しいメッセージが届きました',
                 $request->message,
                 'localhost:8080/chat',
                 $currentUserId
                ));
        }

        return redirect()->route('chat.chat');
    }
}
