<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class ChatMessage extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'chat_messages';

    protected $fillable = [
        'user_id', 'message', 'created_at'
    ];
}
