<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGuest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama');
            $table->string('id_request')->unique()->nullable();
            $table->text('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->text('pekerjaan')->nullable();
            $table->string('tujuan')->nullable();
            $table->datetime('cin')->nullable();
            $table->datetime('cout')->nullable();
            $table->bigInteger('ruang_id');
            $table->string('nama_ruang');
            $table->tinyInteger('rating')->nullable();
            $table->text('kesan')->nullable();
            $table->boolean('status')->nullable();
            $table->string('approved_by')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('guest');
    }
}
