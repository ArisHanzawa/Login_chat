<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatMessage;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatMessage::on('mongodb')->create([
            'user_id' => 1,
            'message' => 'Hello, this is a test message',
            'created_at' => now()
        ]);
    }
}
