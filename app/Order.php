<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [ 'user_id', 'total', 'status', 'name' ,'lastname' ,'company','address','city','state','mail', 'phone','talon_cobro' ];




    public function productos()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity','price','discount_user','discount_product');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    // public function nro_talon()
    // {
    //     return $this->hasOne('App\NotificationCobros', 'nro_talon', 'talon_cobro');
    // }


        ///SCOPES///

        public function scopeSearcher($query, $searcher){
            if($searcher)
            
                return $query->where('name', 'LIKE', "%$searcher%")
                    ->orWhere('email', 'LIKE', "%$searcher%")
                    ->orWhere('phone', 'LIKE', "%$searcher%")
                    ->orWhere('id', 'LIKE', "%$searcher%");
 
        }
}
