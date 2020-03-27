<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name', 'code'
    ];



    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function message()
    {
        return $this->hasMany('App\Message');
    }
}
