<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('prototipo_id')->unsigned();
            // $table->foreign('producto_id')
            //       ->references('id')->on('productos');
            //       ->onDelete('cascade');
            $table->unsignedInteger('unidades_a_producir')->unsigned();
            $table->string('area_responsable1')->nullable();
            $table->string('area_responsable2')->nullable();
            $table->date('fecha')->nullable();
            $table->string('observacion')->nullable();
            $table->BigInteger('usuario_id');
            $table->enum('estado',['ACTIVA','ANULADA'])->default('ACTIVA');
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
        Schema::dropIfExists('guias');
    }
}
