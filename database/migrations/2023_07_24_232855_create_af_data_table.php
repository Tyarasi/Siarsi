<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Af_data', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->unsigned();
            $table->integer('foto_id')->unsigned();
            $table->timestamps();

            $table->foreign('admin_id')->on('admins')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('foto_id')->on('fotos')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Af_data');
    }
}