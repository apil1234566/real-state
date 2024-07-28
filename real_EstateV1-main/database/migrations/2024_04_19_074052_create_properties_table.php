<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',255)->nullable();
            // $table->string('property_slug',255)->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('total_rooms');
            $table->unsignedBigInteger('category_id');
            $table->longText('description')->nullable();
            $table->integer('views')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('status')->default(0);
            $table->string('property_video',255)->nullable();
            $table->string('property_area', 255)->nullable();
            $table->string('property_plan',255)->nullable();
            $table->string('panoromic_image', 255)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('properties');
    }
}
