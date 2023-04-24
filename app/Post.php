<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //$fillableを書くとテーブルのカラムで登録しないといけないものが分かる
    protected $fillable = [
        'content',
        'user_id',
    ];
}
