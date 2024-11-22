<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PushSubscription;
use App\Notifications\TestPush;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebpushController extends Controller
{
    public function setSubscription(Request $request): JsonResponse
    {
        $user = Auth::user();
        $tempData = $request->json()->all();
        Log::info('Subscription data:', $tempData);

        try{
            $user->updatePushSubscription(
                $tempData['endpoint'],
                $tempData['keys']['p256dh'],
                $tempData['keys']['auth'],
                $tempData['contentEncoding']
            );
            return response() -> json();
        } catch (\Exception $e) {
            Log::error('Error updating push subscription:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update push subscription'], 500);
        }
    }

    public function send(Request $request)
    {
        $user = Auth::user();
        $currentUserId = auth()->id();
        $user->notify(new TestPush('タイトル', '内容', 'http://localhost:8080/chat', $currentUserId));
    }
}
