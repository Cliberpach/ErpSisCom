<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDocumentoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_documento_detalles', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('documento_id');
            $table->foreign('documento_id')->references('id')->on('cotizacion_documento')->onDelete('cascade');
            $table->unsignedInteger('lote_id');
            $table->string('codigo_producto');
            $table->string('unidad');
            $table->string('nombre_producto');
            $table->string('codigo_lote');
            // $table->foreign('lote_id')->references('id')->on('lote_productos')->onDelete('cascade');
            $table->unsignedInteger('cantidad');
            $table->unsignedDecimal('precio', 15, 2);
            $table->unsignedDecimal('importe', 15, 2);
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
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
        Schema::dropIfExists('cotizacion_documento_detalles');
    }
}
