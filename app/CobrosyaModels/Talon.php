<?php

namespace App\CobrosyaModels;

use Illuminate\Database\Eloquent\Model;

class Talon extends Model
{
    protected $fillable = [
        'token',
        'id_transaccion',
        'id_cliente_cobrosya',
        'nombre',
        'apellido',
        'email',
        'celular',
        'concepto',
        'moneda',
        'monto',
        'fecha_vencimiento',
        'url_respuesta',
        'consumo_final',
        'factura',
        'monto_gravado',
        'firma'
    ];

}
