<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Av_data', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->unsigned();
            $table->integer('video_id')->unsigned();
            $table->timestamps();

            $table->foreign('admin_id')->on('admins')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('video_id')->on('videos')->references('id')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Av_data');
    }
}