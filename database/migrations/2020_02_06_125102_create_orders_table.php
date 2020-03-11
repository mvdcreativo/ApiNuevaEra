<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->start_from(50000);
            $table->unsignedBigInteger('user_id');
            $table->float('total');
            $table->string('name');
            $table->string('lastname');
            $table->string('company')->nullable();
            $table->string('ci')->nullable();
            $table->string('rut')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('email');
            $table->string('phone');
            $table->string('talon_cobro')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('status_id');

            

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
