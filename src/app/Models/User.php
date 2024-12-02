<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use NotificationChannels\WebPush\PushSubscription;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPushSubscriptions;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pushSubscriptions()
    {
        return $this->hasMany(PushSubscription::class);
    }

    public function updatePushSubscription($endpoint, $publicKey, $authToken, $contentEncoding)
    {
        $subscription = $this->pushSubscriptions()->where('endpoint', $endpoint)->first();

        if (!$subscription) {
            $subscription = new PushSubscription();
            $subscription->endpoint = $endpoint;
            $subscription->user_id = $this->id;
        }

        $subscription->public_key = $publicKey;
        $subscription->auth_token = $authToken;
        $subscription->content_encoding = $contentEncoding;
        $subscription->save();

        return $subscription;
    }
}
