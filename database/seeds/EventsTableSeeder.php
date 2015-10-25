<?php

use Illuminate\Database\Seeder;
use App\Events;

class EventsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('events')->truncate();

        DB::table('events')->insert([
            [
                'title' => '八戸航空基地祭',
                'image_path' => 'http://placehold.jp/800x200.png',
                'article_url' => 'http://www.mod.go.jp/msdf/hatinohe/event/event_kichisai.html',
                'status' => '1',
                'place' => '八戸',
                'start_date' => '2015-10-31 23:59:59',
                'end_date' => '2015-10-31 23:59:59',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'title' => '八戸航空基地祭',
                'image_path' => 'http://placehold.jp/800x200.png',
                'article_url' => 'http://www.mod.go.jp/msdf/hatinohe/event/event_kichisai.html',
                'status' => '1',
                'place' => '八戸',
                'start_date' => '2015-10-31 23:59:59',
                'end_date' => '2015-11-21 23:59:59',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
        ]);

    }

}
