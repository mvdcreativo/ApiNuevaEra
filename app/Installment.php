<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [ 'name', 'quantity'];



    public function payment_methods()
    {
        return $this->belongsToMany('App\PaymentMethod');
    }

}
