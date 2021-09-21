<?php

use App\Mantenimiento\Tabla\Detalle;
use App\Mantenimiento\Tabla\General;
use Illuminate\Database\Seeder;

class PruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabla = new General();
        $tabla->descripcion = 'TURNOS';
        $tabla->sigla = 'TURNO';
        $tabla->save();
        $detalle = new Detalle();
        $detalle->descripcion = "MAÑANA";
        $detalle->simbolo = 'AM';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 30;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "TARDE";
        $detalle->simbolo = 'PM';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 30;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "NOCHE";
        $detalle->simbolo = 'PM';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 30;
        $detalle->save();
    }
}
