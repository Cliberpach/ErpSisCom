<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleCuentaProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cuenta_proveedor', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cuenta_proveedor_id');
            $table->foreign('cuenta_proveedor_id')->references('id')->on('cuenta_proveedor')->onDelete('cascade');
            $table->date('fecha');
            $table->text('observacion');
            $table->decimal('monto');
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
        Schema::dropIfExists('detalle_cuenta_proveedor');
    }
}
