<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [''];

    #povotはレスポンスに必要ないので非表示
    protected $hidden = ['pivot'];
    public $timestamps = false;

    # タグに紐づいたジャンルを取得
    public function genres()
    {
        return $this->belongsTo(TagGenre::class, 'tag_genre_id');
    }

    # タグに紐づいたターゲットを取得
    public function targets()
    {
        return $this->belongsTo(Tagtarget::class, 'tag_target_id');
    }
}
