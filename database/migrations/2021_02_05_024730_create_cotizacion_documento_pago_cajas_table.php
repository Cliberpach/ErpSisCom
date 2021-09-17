<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDocumentoPagoCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_documento_pago_cajas', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('caja_id')->nullable();
            $table->foreign('caja_id')->references('id')->on('pos_caja_chica')->onDelete('cascade');

            $table->unsignedDecimal('monto', 15,2);
            
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
        Schema::dropIfExists('cotizacion_documento_pago_cajas');
    }
}
