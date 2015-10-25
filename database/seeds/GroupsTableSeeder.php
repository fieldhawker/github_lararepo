<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('groups')->truncate();

        DB::table('groups')->insert([
            [
                'name' => '営業',
                'group' => '10',
                'email' => 'example@gmail.com',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'name' => '経理',
                'group' => '20',
                'email' => 'example@gmail.com',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'name' => '川崎',
                'group' => '30',
                'email' => 'example@gmail.com',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'name' => '第一開発課',
                'group' => '40',
                'email' => 'soft_grp1_chief@se-project.co.jp',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'name' => '第二開発課',
                'group' => '50',
                'email' => 'soft_grp2_chief@se-project.co.jp',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
        ]);

    }

}
