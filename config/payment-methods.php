<?php

return [

    'enabled' => [
        'mercadopago',
    ],

    'use_sandbox' => env('SANDBOX_GATEWAYS', false),

    'mercadopago' => [
        // 'logo' => '/img/payment/mercadopago.png',
        'display' => 'MercadoPago',
        'client' => env('MP_CLIENT'),
        'secret' => env('MP_SECRET'),
    ],



];