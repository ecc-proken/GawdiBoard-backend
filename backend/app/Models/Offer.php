<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    # povotはレスポンスに必要ないので非表示
    protected $hidden = array('pivot');
    public $timestamps = false;


    # 募集に紐づいたタグを取得
    public function tags()
    {
        return $this->belongsToMany(Tag::class, "offer_tags");
    }

    #TODO : 募集に紐づいたユーザーを取得
}
