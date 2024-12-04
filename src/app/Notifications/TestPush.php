<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Support\Facades\Log;

class TestPush extends Notification
{
    use Queueable;

    private $title;
    private $body;
    private $url;
    private $senderId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $title, string $body, string $url, int $senderId)
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
        $this->senderId = $senderId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
         return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWebPush($WebPushMessage,)
    {
        Log::info('Preparing push notification:', [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'senderId' => $this->senderId
        ]);


        return (new WebPushMessage())
            ->title($this->title)
            ->body($this->body)
            ->action('View app', $this->url)
            ->data([
                'url' => $this->url,
                'senderId' => $this->senderId
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'sender_id' => $this->senderId,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'sender_id' => $this->senderId,
        ]);
    }
}
