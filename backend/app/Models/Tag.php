<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    # このタグを持つ募集
    public function offers()
    {
        return $this->belongsToMany(Offer::class, "offer_tags");
    }
}
