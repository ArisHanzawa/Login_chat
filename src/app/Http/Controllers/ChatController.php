<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\Subscription;
use Minishlink\WebPush\WebPush;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::all();
        return view('chat.chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'created_at' => now(),
        ]);

        // サブスクリプション情報を取得
        $subscriptions = Subscription::all();

        // WebPush通知を送信
        $auth = [
            'VAPID' => [
                'subject' => 'mailto:hanzawa@aris-kk.co.jp',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        foreach ($subscriptions as $subscription) {
            $webPush->sendOneNotification(
                Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'publicKey' => $subscription->public_key,
                    'authToken' => $subscription->auth_token,
                ]),
                json_encode(['title' => 'New Message', 'body' => $message->message])
            );
        }

        return redirect()->route('chat.chat');
    }
}
