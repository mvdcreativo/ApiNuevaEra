<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image_url','status', 'destaca'
    ];



    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
