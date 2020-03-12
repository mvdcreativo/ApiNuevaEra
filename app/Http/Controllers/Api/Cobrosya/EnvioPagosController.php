<?php

namespace App\Http\Controllers\Api\Cobrosya;
use App\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User;
use App\CobrosyaModels\Cliente;
use App\CobrosyaModels\Talon;

use App\Traits\FirmaCobrosyaTrait;


class EnvioPagosController extends Controller
{



    //////////////
    // REGISTRAR CLIENTE COBROSYA
    /////////////

    public function registrar_cliente(Request $request){

        ///fichero ubicado en storage nombre en variable de entorno
        $key = file_get_contents(storage_path().env('PRIVATE_KEY_CY'));

        // return $request->all();

        $cliente = [
        'token' => "f063a59d610c3900f78fc5874369ca2d",
        'id_cliente_comercio' => $request->user_id,///id Orden
        'nombre' => $request->name,
        'apellido' => $request->lastname,
        'email' => $request->email, //id_cliente_cobrosya": "00718949-f2b4-4e95-ba08-9e398bb5b8cc"
        'cedula' => $request->ci,
        'celular' => $request->phone,
        ];

        $data_a_firmar = [
            $cliente['token'],
            $cliente['id_cliente_comercio'],
            $cliente['nombre'],
            $cliente['apellido'],
            $cliente['email'],
            $cliente['cedula'],
            $cliente['celular']
        ];
        

        $firma = FirmaCobrosyaTrait::cobrosyaFirmar($key, $data_a_firmar);
        $cliente['firma'] = $firma;

        $options = [
            'form_params' => $cliente
        ];
        // return $array;

        $client = new Client();

        $response = $client->request('POST', 'http://api-sandbox5.cobrosya.com/v5.5/ws-registrar-cliente', $options );

        $respuesta = json_decode($response->getBody(), true);
        
        $user = User::find($request->user_id);
        $user->id_cliente_cobrosya = $respuesta['id_cliente_cobrosya'];
        $user->save();




        return $respuesta;
        
    }
    

    //////////////
    // CREAR TALON DE PAGO
    /////////////

    public function crear_talon(Request $request){

        ///fichero ubicado en storage nombre en variable de entorno
        $key = file_get_contents(storage_path().env('PRIVATE_KEY_CY'));

        // return $request->order['id'];
        $talon = [
        'token' => "f063a59d610c3900f78fc5874369ca2d",
        'id_transaccion' => $request->order['id'],
        'id_cliente_cobrosya' => $request->user['id_cliente_cobrosya'],
        'nombre' => $request->order['name'],
        'apellido' => $request->order['lastname'],
        'email' => $request->order['email'],
        'celular' => $request->order['phone'],
        'concepto' => "Orden Nº.: ".$request->order['id'],
        'moneda' => 858,
        'monto' => $request->order['total'],
        'fecha_vencimiento' => "",
        'url_respuesta' => "http://localhost:4200/pages/finaliza-pago",
        'consumo_final' => 1,
        'factura' => $request->order['id'],
        'monto_gravado' => $request->order['total'],
        ];
        


        $data_a_firmar = [ 
            $talon['token'],
            $talon['id_transaccion'],
            $talon['id_cliente_cobrosya'],
            $talon['nombre'],
            $talon['apellido'],
            $talon['email'],
            $talon['moneda'],
            $talon['monto'],
            $talon['url_respuesta'],
        ];
        $firma = FirmaCobrosyaTrait::cobrosyaFirmar($key, $data_a_firmar);
        $talon['firma'] = $firma;

 


        $options = [
            'form_params' => $talon
        ];
        // return $array;

        

        $client = new Client();
        $response = $client->request('POST', 'http://api-sandbox5.cobrosya.com/v5.5/ws-crear-talon', $options );

        $respuesta = json_decode($response->getBody(), true);


        $order = Order::find($request->order['id']);
        $order->talon_cobro = $respuesta['nro_talon'];
        $order->url_pdf = $respuesta['url_pdf'];
        $order->status_id = 3;
        $order->payment_method_id = $request->method;
        $order->save();

        return $respuesta;
    }



    /////////////
    // TARJETAS
    /////////////

    public function user_tarjetas(Request $request){

        ///fichero ubicado en storage nombre en variable de entorno
        $key = file_get_contents(storage_path().env('PRIVATE_KEY_CY'));

        $tarjeta = [
            'token' => "f063a59d610c3900f78fc5874369ca2d",
            'id_cliente_cobrosya' => '00718949-f2b4-4e95-ba08-9e398bb5b8cc',
            'id_medio_pago' => "7" ///7- visa o 12- Oca unicamente
        ];

        $data_a_firmar = [
            $tarjeta['token'],
            $tarjeta['id_cliente_cobrosya'],
            $tarjeta['id_medio_pago']
        ];

        $firma = FirmaCobrosyaTrait::cobrosyaFirmar($key, $data_a_firmar);
        $tarjeta['firma'] = $firma;

        $options = [
            'form_params' => $tarjeta
        ];
        // return $array;

        $client = new Client();

        $response = $client->request('POST', 'http://api-sandbox5.cobrosya.com/v5.5/ws-tarjetas', $options );

        return $body = json_decode($response->getBody(), true);

    }



    /////////////
    // URL COBRO
    /////////////

    public function navega_a_cobro(Request $request){
        // return Redirect::to('http://api-sandbox5.cobrosya.com/v5.5/cobrar-talon');
        ///fichero ubicado en storage nombre en variable de entorno

        
        $key = file_get_contents(storage_path().env('PRIVATE_KEY_CY'));

        $cobro = [
            'nro_talon' => $request->order['talon_cobro'],
            'id_medio_pago' => $request->order['payment_method_id'],
            'id_cliente_cobrosya' => $request->user['id_cliente_cobrosya'],
            'cuotas' => $request->cuotas,
            'id_tarjeta' => '',
            'cvv2' => '',
            'terminal' => '', 
        ];

        $data_a_firmar = [
            $cobro['nro_talon'],
            $cobro['id_medio_pago'],
            $cobro['id_cliente_cobrosya'],
            $cobro['cuotas'],
            $cobro['id_tarjeta'],
            $cobro['cvv2'],
            $cobro['terminal'],
        ];


        $firma = FirmaCobrosyaTrait::cobrosyaFirmar($key, $data_a_firmar);
        $cobro['firma'] = $firma;
        
        $options = [
            'form_params' => $cobro
        ];
        // return $array;

        $client = new Client();

        $response = $client->request('POST', 'http://api-sandbox5.cobrosya.com/v5.5/cobrar-talon', $options );

        // return redirect()->away('http://api-sandbox5.cobrosya.com/v5.5/cobrar-talon');
        

        return $body = json_decode($response->getBody(), true);
        
    }


    public function firma(Request $request){

        $key = file_get_contents(storage_path().env('PRIVATE_KEY_CY'));
        $data_a_firmar = [
                $request->nro_talon,
                $request->order['payment_method_id'],
                $request->user['id_cliente_cobrosya'],
                $request->cuotas,
                '',
                '',
                '',
            
        ];


        $firma = FirmaCobrosyaTrait::cobrosyaFirmar($key, $data_a_firmar);

        return response()->json($firma, 200);    }


}
