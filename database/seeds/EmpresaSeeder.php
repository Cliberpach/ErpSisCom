<?php

use Illuminate\Database\Seeder;

use App\Compras\Proveedor;
use App\Mantenimiento\Empresa\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Agroensancha S.R.L
        $empresa = new Empresa();
        $empresa->ruc = '10706602009';
        $empresa->razon_social = 'ESCOBEDO PEREZ GRISELDA';
        $empresa->razon_social_abreviada = 'ESCOBEDO PEREZ GRISELDA';
        $empresa->direccion_fiscal = 'Av. Cesar Vallejo 429 Urb. Palermo - Trujillo';
        $empresa->direccion_llegada = 'TRUJILLO';
        $empresa->dni_representante = '70004110';
        $empresa->nombre_representante = 'NOMBRE APELLIDOPAT APELLIDOMAT';
        $empresa->num_asiento = 'A00001';
        $empresa->num_partida = '11036086';
        $empresa->estado_ruc = 'ACTIVO';
        $empresa->estado_dni_representante= 'ACTIVO';
        $empresa->save();

        $proveedor = new Proveedor();
        $proveedor->descripcion = 'LIMPIATODO S.A.C';
        $proveedor->tipo_documento = 'RUC';
        $proveedor->tipo_persona = 'PERSONA JURIDICA';
        $proveedor->direccion = 'Jr. Puerto Inca Nro. 250 Dpto. 402';
        $proveedor->correo = 'AXELGUTIERREZLOPEZ26@GMAIL.COM';
        $proveedor->telefono = '043313520';
        $proveedor->zona = 'NOROESTE';
        $proveedor->contacto = 'LIZ FLORES';
        $proveedor->telefono_contacto = '957819664';
        $proveedor->correo_contacto = 'AXELGUTIERREZLOPEZ26@GMAIL.COM';
        $proveedor->transporte = 'SEDACHIMBOTE S.A.';
        $proveedor->ruc_transporte = '20136341066';
        $proveedor->direccion_transporte = 'JR. LA CALETA NRO. 176 A.H.  MANUEL SEOANE CORRALES - ANCASH - SANTA - CHIMBOTE';

        $proveedor->estado_transporte = 'ACTIVO';
        $proveedor->estado_documento = 'ACTIVO';
        $proveedor->save();

        // $persona = new Persona();
        // $persona->tipo_documento = 'DNI';
        // $persona->documento = '10000000';
        // $persona->nombres = 'AXEL GASTON KEVIN';
        // $persona->apellido_paterno = 'GUTIERREZ';
        // $persona->apellido_materno = 'LOPEZ';
        // $persona->fecha_nacimiento = '2021-01-06';
        // $persona->sexo = 'M';
        // $persona->estado = 'ACTIVO';
        // $persona->save();


        // $empleado = new Empleado();
        // $empleado->persona_id = 1;
        // $empleado->area = '1';
        // $empleado->profesion = '1';
        // $empleado->cargo = '1';
        // $empleado->sueldo = '1000';
        // $empleado->sueldo_bruto = '1000';
        // $empleado->sueldo_neto = '10000';
        // $empleado->moneda_sueldo = 'SOLES';
        // $empleado->fecha_inicio_actividad = '2021-01-06';
        // $empleado->estado = 'ACTIVO';
        // $empleado->save();

        // $cliente = new Cliente();
        // $cliente->tipo_documento = '70004110';
        // $cliente->documento = 'DNI';
        // $cliente->direccion_negocio = 'JR. LA CALETA NRO. 176 A.H.  MANUEL SEOANE CORRALES - ANCASH - SANTA - CHIMBOTE';
        // $cliente->direccion = 'JR. LA CALETA NRO. 176 A.H.  MANUEL SEOANE CORRALES - ANCASH - SANTA - CHIMBOTE';
        // $cliente->correo_electronico = 'AXELGUTIERREZLOPEZ26@GMAIL.COM';
        // $cliente->telefono_movil = '1345678';
        // $cliente->activo = '1';
        // $cliente->save();


    }
}
