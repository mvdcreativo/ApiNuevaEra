<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_cobros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accion');
            $table->integer('id_medio_pago');
            $table->string('medio_pago');
            $table->integer('moneda');
            $table->float('monto');   
            $table->string('fecha');
            $table->integer('cuotas_codigo')->nullable();
            $table->string('cuotas_texto')->nullable();
            $table->string('autorizacion')->nullable();
            $table->string('id_compra')->nullable();
            $table->string('vencimiento')->nullable();
            $table->string('firma');
            $table->string('nro_talon');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_cobros');
    }
}
