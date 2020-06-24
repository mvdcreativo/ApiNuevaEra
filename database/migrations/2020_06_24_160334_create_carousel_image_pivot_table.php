<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselImagePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel_image', function (Blueprint $table) {
            $table->unsignedBigInteger('carousel_id')->index();
            $table->foreign('carousel_id')->references('id')->on('carousels')->onDelete('cascade');
            $table->unsignedBigInteger('image_id')->index();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->primary(['carousel_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carousel_image');
    }
}
