<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDocumentoPagoTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_documento_pago_transferencias', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('documento_id')->unsigned();
            $table->foreign('documento_id')
                  ->references('id')->on('cotizacion_documento')
                  ->onDelete('cascade');

            $table->BigInteger('id_banco_empresa');
            $table->unsignedDecimal('monto', 15,2);
    
            $table->date('fecha_pago');

            $table->string('ruta_archivo')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->mediumText('observacion')->nullable();

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
        Schema::dropIfExists('cotizacion_documento_pago_transferencias');
    }
}
