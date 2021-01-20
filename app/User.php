<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'discount', 'company', 'ci', 'rut', 'city', 'state', 'address','role','phone', 'social_id', 'user_apple'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function orders()
    {
        return $this->hasMany('App\Order');
    }


            ///SCOPES///

            public function scopeSearcher($query, $searcher){
                if($searcher)
                
                    return $query->where('name', 'LIKE', "%$searcher%")
                        ->orWhere('email', 'LIKE', "%$searcher%")
                        ->orWhere('phone', 'LIKE', "%$searcher%")
                        ->orWhere('lastname', 'LIKE', "%$searcher%")
                        ->orWhere('address', 'LIKE', "%$searcher%")
                        ->orWhere('ci', 'LIKE', "%$searcher%")
                        ->orWhere('rut', 'LIKE', "%$searcher%")
                        ->orWhere('company', 'LIKE', "%$searcher%");
     
            }

}
