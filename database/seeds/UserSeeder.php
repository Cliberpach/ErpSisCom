<?php
use App\User;
use App\Mantenimiento\Persona\Persona;
use App\Mantenimiento\Colaborador\Colaborador;
use App\PersonaTrabajador;
use App\UserPersona;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = new Persona();
        $persona->tipo_documento = 'DNI';
        $persona->documento = '71114110';
        $persona->codigo_verificacion = 2;
        $persona->nombres = 'CARLOS';
        $persona->apellido_paterno = 'CUBAS';
        $persona->apellido_materno = 'RODRIGUEZ';
        $persona->fecha_nacimiento = Carbon::parse('2000-01-01');
        $persona->sexo = 'H';
        $persona->estado_civil = 'S';
        $persona->departamento_id = '02';
        $persona->provincia_id = '0218';
        $persona->distrito_id = '021809';
        $persona->direccion = 'CHEPEN';
        $persona->correo_electronico = 'CCUBAS@UNITRU.EDU.PE';
        $persona->telefono_movil = '99999999999';
        $persona->estado = 'ACTIVO';
        $persona->save();

        $personaTrabajador = new PersonaTrabajador();
        $personaTrabajador->persona_id = $persona->id;
        $personaTrabajador->area = 'COMERCIAL';
        $personaTrabajador->profesion = 'ING.SISTEMAS';
        $personaTrabajador->cargo = 'GERENTE GENERAL';
        $personaTrabajador->telefono_referencia = '2121212';
        $personaTrabajador->contacto_referencia = 'LOPEZ';
        $personaTrabajador->grupo_sanguineo = 'O-';
        $personaTrabajador->numero_hijos = 10;
        $personaTrabajador->sueldo = 1200;
        $personaTrabajador->sueldo_bruto = 1200;
        $personaTrabajador->sueldo_neto = 1200;
        $personaTrabajador->moneda_sueldo = 'S/.';
        $personaTrabajador->tipo_banco = 'BN';
        $personaTrabajador->numero_cuenta = '2020202';
        $personaTrabajador->fecha_inicio_actividad = Carbon::parse('2000-01-01');
        $personaTrabajador->fecha_fin_actividad = Carbon::parse('2000-01-01');
        $personaTrabajador->fecha_inicio_planilla = Carbon::parse('2000-01-01');
        $personaTrabajador->fecha_fin_planilla = Carbon::parse('2000-01-01');
        $personaTrabajador->estado = 'ACTIVO';
        $personaTrabajador->save();

        $colaborador = new Colaborador();
        $colaborador->persona_trabajador_id = $personaTrabajador->id;
        $colaborador->save();

        $user = new User();
        $user->usuario = 'ADMINISTRADOR';
        $user->email = 'ADMIN@SISCOM.COM';
        $user->password = bcrypt('ADMIN');
        $user->save();

        $user_persona=new UserPersona();
        $user_persona->user_id=$user->id;
        $user_persona->persona_id=$persona->id;
        $user_persona->save();

    }


}
