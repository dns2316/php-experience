<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movie';

    protected $fillable = [
        'id', 'name', 'last_update', 'tracking', 'season', 'episode', 'url', 'img',
    ];
}
