<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraDocumentoPagoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_documento_pago_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('pos_caja_chica')->onDelete('cascade');
            // $table->string('tipo_pago');
            $table->unsignedDecimal('monto', 15,2);
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
        Schema::dropIfExists('compra_documento_pago_detalle');
    }
}
