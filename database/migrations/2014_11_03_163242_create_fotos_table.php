<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->unique();
            $table->integer('kategori_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->string('nama_foto');
            $table->string('nama_admin');
            $table->json('foto_dokumentasi');
            $table->string('keterangan_foto');
            $table->date('tanggal_foto');
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
        Schema::dropIfExists('fotos');
    }
}