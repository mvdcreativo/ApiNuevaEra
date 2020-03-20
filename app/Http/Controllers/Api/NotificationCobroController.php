<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificationCobro;

class NotificationCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $notification = new NotificationCobro;

        $notification->accion = $request->topic;
        $notification->nro_talon = $request->id;

        
        $notification->save();
        // return $notification;
        return response()->json("ok", 200);

        // return NotificationCobros::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        
        $notification = new NotificationCobro;

        $notification->topyc = $request->topic;
        $notification->id_notificacion = $request->id;
        $notification->save();


        
        // return $notification;
        return response()->json(200);
        // $notification = new NotificationCobro;

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
