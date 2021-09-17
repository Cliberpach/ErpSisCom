<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraDocumentoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_documento_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->foreign('documento_id')->references('id')->on('compra_documentos')->onDelete('cascade');
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
        Schema::dropIfExists('compra_documento_pagos');
    }
}
