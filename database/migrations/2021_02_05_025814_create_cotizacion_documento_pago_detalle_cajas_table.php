<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDocumentoPagoDetalleCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_documento_pago_detalle_cajas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cotizacion_documento_pago_cajas')->onDelete('cascade');

            $table->unsignedInteger('pago_id');
            $table->foreign('pago_id')->references('id')->on('cotizacion_documento_pagos')->onDelete('cascade');


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
        Schema::dropIfExists('cotizacion_documento_pago_detalle_cajas');
    }
}
