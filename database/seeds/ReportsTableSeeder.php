<?php

use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->truncate();

        DB::table('reports')->insert([
            [
                'user_key'     => 'aaaaaaaaaaaaaaaaa',
                'week'        => '2015-W01',
                'station'        => '代官山',
                'place'        => 'Veritrans',
                'work'        => 'テスト業務内容',
                'language'        => 'PHP',
                'report'        => 'テスト報告内容',
                'sales'        => 'テスト営業情報',
                'created_at'  => '2015-01-10 23:59:59',
                'updated_at'  => '2015-01-20 23:59:59',
                'updated_by'  => 'SYSTEM',
            ],
            [
                'user_key'     => 'aaaaaaaaaaaaaaaaa',
                'week'        => '2015-W02',
                'station'        => '代官山',
                'place'        => 'Veritrans',
                'work'        => 'テスト業務内容2',
                'language'        => 'PHP',
                'report'        => 'テスト報告内容2',
                'sales'        => 'テスト営業情報2',
                'created_at'  => '2015-02-10 23:59:59',
                'updated_at'  => '2015-02-20 23:59:59',
                'updated_by'  => 'SYSTEM',
            ],
            [
                'user_key'     => 'bbbbbbbbbbbbbbb',
                'week'        => '2015-W01',
                'station'        => '渋谷',
                'place'        => 'SkillUpJapan',
                'work'        => 'テスト業務内容3',
                'language'        => 'PHP,Javascript',
                'report'        => 'テスト報告内容3',
                'sales'        => 'テスト営業情報3',
                'created_at'  => '2015-03-10 23:59:59',
                'updated_at'  => '2015-03-20 23:59:59',
                'updated_by'  => 'SYSTEM',
            ],
        ]);
    }
}
