<?php

namespace App\CobrosyaModels;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'token', 'id_cliente_comercio', 'nombre', 'apellido', 'email', 'cedula', 'celular', 'firma'
    ];
}
