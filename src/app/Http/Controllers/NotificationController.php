<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $auth = [
            'VAPID' => [
                'subject' => config('webpush.vapid.subject'),
                'publicKey' => config('webpush.vapid.public_key'),
                'privateKey' => config('webpush.vapid.private_key'),
            ],
        ];

        $webPush = new WebPush($auth);

        // サブスクリプション情報を取得して通知を送信
        $subscription = Subscription::create([
            'endpoint' => $request->input('endpoint'),
            'publicKey' => $request->input('publicKey'),
            'authToken' => $request->input('authToken'),
        ]);

        $webPush->sendOneNotification(
            $subscription,
            "Hello, this is a push notification!"
        );

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();

            if ($report->isSuccess()) {
                echo "[v] Message sent successfully for subscription {$endpoint}.";
            } else {
                echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
            }
        }

        return response()->json(['message' => 'Notification sent!']);
    }
}
