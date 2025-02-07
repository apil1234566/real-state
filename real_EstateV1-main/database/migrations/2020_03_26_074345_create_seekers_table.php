<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seekers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone')->nullable();
            $table->string('link')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('description')->nullable();
            $table->string('image',255)->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('seekers');
    }
}
