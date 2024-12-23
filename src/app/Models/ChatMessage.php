<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class ChatMessage extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'chat_messages';

    protected $fillable = [
        'user_id', 'message', 'created_at', 'read_by'
    ];

    public function getMentionedUsersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setMentionedUsersAttribute($value)
    {
        $this->attributes['mentioned_users'] = json_encode($value);
    }

    protected $casts = [
        'read_by' => 'array'
    ];
}
