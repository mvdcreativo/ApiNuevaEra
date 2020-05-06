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
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->float('total');
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('company')->nullable();
            $table->string('ci')->nullable();
            $table->string('rut')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('talon_cobro')->nullable();
            $table->string('url_pdf')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('status_id');
           

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 50000;");
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
