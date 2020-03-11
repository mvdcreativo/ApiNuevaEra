<?php
namespace App\Traits;

use Exception;
use Illuminate\Http\Request;

trait FirmaCobrosyaTrait{

        /* * $key = string de llave privada para generar la firma 
    * $arr = array con parámetros a concatenar, manteniendo el orden especificado */ 
    static function cobrosyaFirmar($key, $arr) { 
        // concatena parametros 
        $data = implode($arr); 
        // lee la llave privada 
        $pKey = openssl_pkey_get_private($key); 
        // genera la firma y lo convierte a formato Base64 
        if (openssl_sign($data, $firma, $pKey)) 
        return base64_encode($firma); 
        
        return false; 
    } 




    /* * $firma = firma recibida 
    * $key = string de llave pública para verificar la firma * $arr = array con parámetros a concatenar manteniendo el orden especificado */ 

    function cobrosyaVerificarFirma($firma, $key, $arr) { 
        // concatena los parametros 
        $data = implode($arr); 
        // lee la llave publica 
        $pKey = openssl_pkey_get_public($key); 
        // convierte desde formato Base64 y verifica la firma
        return openssl_verify($data, base64_decode($firma), $pKey); 
    }
}