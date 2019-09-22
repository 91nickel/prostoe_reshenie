<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function films()
    {
        return $this->belongsToMany('App\Film', 'film_tag_links');
    }
}
