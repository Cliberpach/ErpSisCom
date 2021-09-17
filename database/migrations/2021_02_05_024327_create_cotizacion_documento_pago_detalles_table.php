<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDocumentoPagoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_documento_pago_detalles', function (Blueprint $table) {
            $table->increments('id');
        
            $table->unsignedInteger('pago_id');
            $table->foreign('pago_id')->references('id')->on('cotizacion_documento_pagos')->onDelete('cascade');
    
            // $table->unsignedInteger('caja_id')->nullable();
            // $table->foreign('caja_id')->references('id')->on('cotizacion_documento_pago_cajas')->onDelete('cascade');
    
            // $table->date('fecha_pago');
            $table->unsignedDecimal('monto', 15,2);
            // $table->string('moneda');
    
            $table->string('ruta_archivo')->nullable();
            $table->string('nombre_archivo')->nullable();
    
            $table->mediumText('observacion')->nullable();
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
            $table->string('tipo_pago');

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
        Schema::dropIfExists('cotizacion_documento_pago_detalles');
    }
}
