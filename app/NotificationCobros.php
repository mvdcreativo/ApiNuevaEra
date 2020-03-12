<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationCobros extends Model
{

    protected $fillable = [ 
    'accion',
    'nro_talon',
    'id_medio_pago',
    'medio_pago',
    'moneda',
    'monto',   
    'fecha',
    'cuotas_codigo',
    'cuotas_texto',
    'autorizacion',
    'id_compra',
    'vencimiento',
    'firma',
    ];



}
