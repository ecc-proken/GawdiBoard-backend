<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOffer extends Model
{
    use HasFactory;
    public $timestamps = false;

    # ユーザーに紐づいた募集を取得
    public function offers()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
