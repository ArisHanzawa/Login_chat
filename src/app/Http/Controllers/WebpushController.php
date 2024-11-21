<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TestPush;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebpushController extends Controller
{
    public function setSubscription(Request $request): JsonResponse
    {
        $user = User::find(1);
        $tempData = $request->json()->all();
        $user->updatePushSubscription(
            $tempData['endpoint'],
            $tempData['keys']['p256dh'],
            $tempData['keys']['auth'],
            $tempData['contentEncoding']
        );
        return response() -> json();
    }

    public function send(Request $request)
    {
        $user = User::find(1);
        $currentUserId = auth()->id();
        $user->notify(new TestPush('タイトル', '内容', 'https://google.co.jp',$currentUserId));
    }
}
