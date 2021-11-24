<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $guarded = [];

    # レスポンスに必要ない情報を非表示
    protected $hidden = ['pivot'];
    public $timestamps = false;

    # 宣伝に紐づいたタグを取得
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'promotion_tags');
    }

    # 宣伝に紐づいたユーザーを取得
    public function users()
    {
        return $this->belongsTo(User::class, 'student_number');
    }
}
