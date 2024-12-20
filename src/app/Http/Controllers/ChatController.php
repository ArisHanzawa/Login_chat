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
        // 最新の15件のメッセージを取得
        $messages = ChatMessage::orderBy('created_at', 'desc')->take(15)->get();

        // メッセージを古い順に並べ替え
        $messages = $messages->sortBy('created_at');

        return view('chat.chat', [
            'userId' => auth()->id(),
            'messages' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $request-> validate([
            'message' => 'required|string|max:255',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('ログインしてください。');
        }

        $chatMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'created_at' => now(),
            'read_by' => [],
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

    public function markAsRead($messageId)
    {
        $message = ChatMessage::find($messageId);
        if ($message) {
            $readBy = $message->read_by ?? [];
            if (!in_array(Auth::id(), $readBy)) {
                $readBy[] = Auth::id();
                $message->read_by = $readBy;
                $message->save();
            }
        }

        return response()->json(['status' => 'success']);
    }
}
