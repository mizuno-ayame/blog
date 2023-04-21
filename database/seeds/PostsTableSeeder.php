<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //DBはクエリビルダ


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'content' => 'content1',
                'user_id' => '1',
            ],
            [
                'content' => 'content2',
                'user_id' => '1',
            ],
            [
                'content' => 'content3',
                'user_id' => '1',
            ]
        ]);
    }
}
