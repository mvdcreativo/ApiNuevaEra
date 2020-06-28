<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = [
        'title', 'subtitle', 'status', 'url', 'position'
    ];

    public function carousels()
    {
        return $this->belongsToMany('App\Carousel');
    }

}
