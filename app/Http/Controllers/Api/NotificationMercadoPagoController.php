<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificationMercadoPago;
use GuzzleHttp\Client;


class NotificationMercadoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $notification = new NotificationMercadoPago;

        $notification->topic = $request->topic;
        $notification->id_notificacion = $request->id;

        
        $notification->save();
        // return $notification;
        return response()->json("ok", 200);

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


        if($notification->topic === "payment"){
            
            $id = $notification->id;
            $client = new Client();

            $response = $client->request('GET','https://api.mercadopago.com/v1/payments/'.$id.'?access_token='.env('MP_TOKEN'));


            $respuesta = json_decode($response->getBody(), true);

            // payment_type_id
            // payment_method_id
            // external_reference
            // status
            // status_detail
            // transaction_details->total_paid_amount
            //                     ->net_received_amount

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
