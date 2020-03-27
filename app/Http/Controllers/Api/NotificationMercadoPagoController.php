<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificationMercadoPago;
use GuzzleHttp\Client;
use App\Order;

class NotificationMercadoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $notification = NotificationMercadoPago::all();
        return response()->json($notification, 200);

        // return NotificationMercadoPagos::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        
        $notification = new NotificationMercadoPago;

        $notification->topic = $request->topic;
        $notification->id_notificacion = $request->id;
        $notification->save();


        if($notification->topic && $notification->topic === "merchant_orders"){
            
            $id = $notification->id_notificacion;
            $order_mp_client = new Client();
            $url_merchant_orders = 'https://api.mercadopago.com//merchant_orders/';

            $response = $order_mp_client->request('GET',$url_merchant_orders.$id.'?access_token='.env('MP_TOKEN'));


            $respuesta = json_decode($response->getBody(), true);


            //actualiza orden
            $order_local = Order::find($respuesta['external_reference']);
            // $order_local->payment_metod_mp = $respuesta['payment_metod'];
            $order_local->order_id_mp = $respuesta['id'];
            $order_local->order_status_mp = $respuesta['order_status'];
            $order_local->cancelled_mp = $respuesta['cancelled'];
            $order_local->status_mp = $respuesta['status'];

            if($respuesta['payments']){
                $paiment_mp_client = new Client();
                $url_payment = 'https://api.mercadopago.com/v1/payments/';
                $id_payment = $respuesta['payments'][0]['id'];
                $response_payment = $paiment_mp_client->request('GET',$url_payment.$id_payment.'?access_token='.env('MP_TOKEN'));
                $respuesta_payment = json_decode($response_payment->getBody(), true);
                
                $order_local->payment_metod_mp = $respuesta_payment['payment_method_id'];
            }

            $order_local->save();

            return $order_local;
        }
        
        // return $notification;
        return response()->json("ok", 200);
        // $notification = new NotificationMercadoPago;

        // $notification->accion = $request->accion;
        // $notification->nro_talon = $request->nro_talon;
        // $notification->id_medio_pago = $request->id_medio_pago;
        // $notification->medio_pago = $request->medio_pago;
        // $notification->moneda = $request->moneda;
        // $notification->monto = $request->monto;
        // $notification->fecha_hora = $request->fecha_hora;
        // $notification->cuotas_codigo = $request->cuotas_codigo;
        // $notification->cuotas_texto = $request->cuotas_texto;
        // $notification->autorizacion = $request->autorizacion;
        // $notification->id_compra = $request->id_compra;
        // $notification->digitos = $request->digitos;
        // $notification->vencimiento = $request->vencimiento;
        // $notification->mensaje = $request->mensaje;
        // $notification->firma = $request->firma;
        
        // $notification->save();
        // // return $notification;
        // return response()->json(["message" => "ok recibido", "data" => $notification], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
