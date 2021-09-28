<?php

use Illuminate\Database\Seeder;

use App\Compras\Proveedor;
use App\Mantenimiento\Empresa\Empresa;
use App\Mantenimiento\Empresa\Facturacion;
use App\Mantenimiento\Empresa\Numeracion;

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
        $empresa->estado_ruc = 'ACTIVO';
        $empresa->estado_fe= '1';
        $empresa->save();

        $facturacion = new Facturacion();
        $facturacion->empresa_id = $empresa->id; //RELACION CON LA EMPRESA
        $facturacion->fe_id = 1048; //ID EMPRESA API
        $facturacion->sol_user = 'NALLYNCE';
        $facturacion->sol_pass = 'ocottleau';
        $facturacion->plan = 'free';
        $facturacion->ambiente = 'beta';
        $facturacion->certificado =  null;
        $facturacion->token_code =  'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzEzNzE0NjQsImV4cCI6NDc4NDk3MTQ2NCwidXNlcm5hbWUiOiJMZXN0ZXIiLCJjb21wYW55IjoiMTA3MDY2MDIwMDkifQ.rO1aEO_yuX0YeDGeGYNaW6el_nlUpFe6asTNp646vIdpmV3ekHuoc5-aB-059M6qc9HJYiTzjykcHHTEhQM4PuLDMo8imS5q1zYRviVBTNYs6d4dY3BVamA2GJJCoPuKqsZo11NNWpVjThMyYzFeXKIeNZde_IN_8Nslkl-QsNxTPHpdmVkyxSgHtJGzTE3SuxDCbu9KiIQZPcpx3d6dCBhCc0bQCUZ0OTDTpiHXLA9JCiN3wXmlZwP0EUQfpHkDiD9k6Un-54Wd9ukq8ihL5iE47NkN6E1bhrgpuRsx_4GwqOli2Fkwuf7ywJWXYfm0UfMYssHgbrhvq7r3CDAgXtg7FhqZ9rXkFLsYgo0LxHuebecJ7o9cZm6aNU9S0IStsS8UBjWowtbuoBTni11GE8JEQQH7fsgDP8ftsvASElYFIXioPV2mG6Tuza1eFrnJHCIW9kzAe0Fbo4pF2ddHmzkD0d3Ujr7Jwv2uJX-5XK9rTOmdo9dWwj997GEbOJ9w7ZkeqYPBXzGXRf39JodhvBvzb8E4HY99IA8aItm0osMBk6gktGvQ2KKoU-RgyRdD_ksxpw1dSyQG6q51pGNctcOwlexSXlwswLxn3apbevgWhQQscapsKNR8xD4G5Nbk-qtApvHLxRk2DnqhnCMYAUs8u2dY2iOhjKCbFY38wfo';
        $facturacion->save();

        Numeracion::create([
            'empresa_id' => $empresa->id,
            'serie' => 'F001',
            'tipo_comprobante' => 127,
            'numero_iniciar' => 1,
            'emision_iniciada' => 1,
        ]);

        Numeracion::create([
            'empresa_id' => $empresa->id,
            'serie' => 'B001',
            'tipo_comprobante' => 128,
            'numero_iniciar' => 1,
            'emision_iniciada' => 1,
        ]);

        Numeracion::create([
            'empresa_id' => $empresa->id,
            'serie' => 'N001',
            'tipo_comprobante' => 129,
            'numero_iniciar' => 1,
            'emision_iniciada' => 1,
        ]);



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
