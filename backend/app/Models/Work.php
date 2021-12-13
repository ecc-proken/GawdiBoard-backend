<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $guarded = [];

    # レスポンスに必要ない情報を非表示
    protected $hidden = ['pivot'];
    public $timestamps = false;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'work_tags');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'student_number');
    }
}
