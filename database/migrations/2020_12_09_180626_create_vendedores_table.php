<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->string('zona');
            $table->unsignedDecimal('comision', 15,2);
            $table->string('moneda_comision');
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
        Schema::dropIfExists('vendedores');
    }
}
