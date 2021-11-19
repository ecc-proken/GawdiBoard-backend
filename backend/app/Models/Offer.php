<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "offer_tags");
    }
}
