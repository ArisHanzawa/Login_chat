<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;
use App\Models\AnnouncementRead;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user_ids = User::orderBy('id')->pluck('id');

        for($i = 0 ; $i < 25 ; $i++) {

            $announcement = new Announcement();
            $announcement->title = 'テストタイトル - '. $i;
            $announcement->description = "テストお知らせ\nテストお知らせ\nテストお知らせ - ". $i;
            $announcement->save();

            foreach ($user_ids as $user_id) {
                $read = new AnnouncementRead();
                $read->user_id = $user_id;
                $read->announcement_id = $announcement->id;
                $read->save();
            }
        }
    }
}
