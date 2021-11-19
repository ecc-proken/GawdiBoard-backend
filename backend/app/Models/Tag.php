<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $fillable = ['tag_name', 'tag_genre_id'];
    public $timestamps = false;
}
