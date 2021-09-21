<?php

use App\Pos\Caja;
use App\Ventas\Documento\Pago\Caja as PagoCaja;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caja=new Caja();
        $caja->nombre="Caja Principal";
        $caja->save();
    }
}
