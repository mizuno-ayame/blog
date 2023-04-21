<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //DBはクエリビルダ
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.＝データベース初期値設定の実行
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
