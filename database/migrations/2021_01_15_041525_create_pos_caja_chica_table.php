<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCajaChicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_caja_chica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('moneda');
            $table->timestamp('cierre')->nullable();
            $table->unsignedDecimal('saldo_inicial', 15,2);
            $table->unsignedDecimal('saldo_final', 15,2)->nullable();
            $table->enum('estado',['APERTURADA','CERRADA','ANULADO'])->default('APERTURADA');
            $table->enum('uso',['0','1'])->default('0');
            $table->unsignedInteger('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->string('num_referencia')->nullable();
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
        Schema::dropIfExists('pos_caja_chica');
    }
}
