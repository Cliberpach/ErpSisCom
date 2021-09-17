<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoPagoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_pago_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('detalle_id');
            $table->foreign('detalle_id')->references('id')->on('compra_documento_pago_detalle')->onDelete('cascade');

            $table->unsignedInteger('pago_id');
            $table->foreign('pago_id')->references('id')->on('compra_documento_pagos')->onDelete('cascade');


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
        Schema::dropIfExists('documento_pago_detalle');
    }
}
