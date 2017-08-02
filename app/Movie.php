<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'id', 'name', 'last_update', 'tracking', 'season', 'episode', 'url', 'img',
    ];
}
