<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [ 'user_id', 'total', 'status', 'name' , 'company','address','city','state','mail', 'phone' ];




    public function productos()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity','price');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
