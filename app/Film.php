<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name',
        'year',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'film_tag_links');
    }
}
