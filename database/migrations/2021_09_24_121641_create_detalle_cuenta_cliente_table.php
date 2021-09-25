<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleCuentaClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cuenta_cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cuenta_cliente_id');
            $table->foreign('cuenta_cliente_id')->references('id')->on('cuenta_cliente')->onDelete('cascade');
            $table->date('fecha');
            $table->text('observacion');
            $table->unsignedDecimal('monto');
            $table->unsignedDecimal('saldo');
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
        Schema::dropIfExists('detalle_cuenta_cliente');
    }
}
