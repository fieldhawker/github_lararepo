<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => 'TESTUSER1',
                'email' => 'fieldhawker+test@gmail.com',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-31 23:59:59',
                'updated_at' => '2015-01-31 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => 'TESTUSER2',
                'email' => 'fieldhawker+test2@gmail.com',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-02-20 23:59:59',
                'updated_at' => '2015-02-20 23:59:59',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '高野 圭史',
                'email' => 'takano@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '西田 匠',
                'email' => 'nishidatakumi@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '今野 力',
                'email' => 'konnochikara@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '小林 佑輔',
                'email' => 'kobayashiyuusuke@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '法川 大次郎',
                'email' => 'norikawadaijiro@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '伊藤 慎吾',
                'email' => 'itoshingo@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '1',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '松重 信行',
                'email' => 'matsushige@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '泉 康紀',
                'email' => 'izumi@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '松金 瑛介',
                'email' => 'matsukane@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '畔 浩幸',
                'email' => 'kuro@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '小倉 三佳',
                'email' => 'oguramika@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
            [
                'key' => sha1( uniqid( null , true ) ),
                'name' => '鳴海 健',
                'email' => 'narumi@se-project.co.jp',
                'password' => bcrypt('password'),
                'role' => '2',
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
                'updated_by' => 'SYSTEM',
            ],
        ]);

    }

}
