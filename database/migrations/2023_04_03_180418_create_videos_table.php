<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->unique();
            $table->string('nama_video');
            $table->integer('kategori_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->string('keterangan_video');
            $table->json('video_dokumentasi');
            $table->string('nama_admin');
            $table->date('tanggal_video');
            $table->timestamps();
            
            $table->foreign('kategori_id')->on('kategoris')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_id')->on('admins')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}