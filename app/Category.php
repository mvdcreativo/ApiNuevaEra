<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'status'
    ];


    //relations

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function brands()
    {
        return $this->belongsToMany('App\Brands');
    }
}
