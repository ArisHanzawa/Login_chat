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
        $messages = ChatMessage::orderBy('created_at', 'desc')->take(20)->get();

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

        $messageText = $request->message;

        // メンションの検出
        preg_match_all('/@(\w+)/', $messageText, $matches);
        $mentionedUsernames = $matches[1];

        // メンションされたユーザーの特定と保存
        $mentionedUserIds = [];
        foreach ($mentionedUsernames as $username) {
            $user = User::where('name', $username)->first();
            if ($user) {
                $mentionedUserIds[] = $user->id;
                // メンション情報を保存（例: メッセージにメンションされたユーザーIDを保存）
                // 通知の送信（例: リアルタイム通知やメール通知）
                //TODO ここにお知らせ機能の一覧に追加する処理、追加時に通知する処理を追加
                // Notification::send($user, new MentionNotification($message));
            }
        }

        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'mentioned_users' => $mentionedUserIds,
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

    public function loadMore($lastMessageId)
    {
        // 最後のメッセージIDより古いメッセージを15件取得
        $messages = ChatMessage::where('id', '<', $lastMessageId)
            ->orderBy('created_at', 'desc')
            ->skip(20)
            ->take(15)
            ->get();

        // メッセージを古い順に並べ替え
        $messages = $messages->sortBy('created_at');

        return response()->json($messages);
    }
}
