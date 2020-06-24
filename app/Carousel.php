<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    //
    protected $fillable = [
        'name', 'platform'
    ];

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }
}
