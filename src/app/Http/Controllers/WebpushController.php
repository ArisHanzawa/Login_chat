<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PushSubscription;
use App\Notifications\TestPush;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class WebpushController extends Controller
{
    public function setSubscription(Request $request): JsonResponse
    {
        $user = Auth::user();
        $currentUserId = auth()-> id();
        $url = 'http://localhost:8080/chat';
        Log::info('Sending push notification to user:', ['user_id' => $user->id]);
        // Log::info('Authenticated user:', ['user' => Auth::user()]);
        // dd(Auth::user());

            Log::info('Push notification sent successfully');

        if (!$user) {
            Log::error('User not authenticated');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        Log::info('Authenticated user:', ['user' => $user]);

        $tempData = $request->json()->all();
        Log::info('Subscription data:', $tempData);

        try{
            Log::info('Before updating push subscription');
            $user->updatePushSubscription(
                $tempData['endpoint'],
                $tempData['keys']['p256dh'],
                $tempData['keys']['auth'],
                $tempData['contentEncoding']
            );
            Log::info('After updating push subscription');
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
        Log::info('Sending push notification to user:', ['user_id' => $user->id]);

        try{
            Notification::send($user, new TestPush('タイトル', '内容', 'http://localhost:8080/chat', $currentUserId));
            Log::info('Push notification sent successfully');
        } catch (\Exception $e) {
            Log::error('Error sending push notification:', ['error' => $e->getMessage()]);
        }
    }
}
