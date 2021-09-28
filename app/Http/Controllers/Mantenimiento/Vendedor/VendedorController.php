<?php

namespace App\Http\Controllers\Mantenimiento\Vendedor;

use App\Http\Controllers\Controller;
use App\Mantenimiento\Persona\Persona;
use App\Mantenimiento\Persona\PersonaVendedor;
use App\Mantenimiento\Vendedor\Vendedor;
use App\PersonaTrabajador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VendedorController extends Controller
{
    public function index()
    {
        return view('mantenimiento.vendedores.index');
    }

    public function getTable()
    {
        $vendedores = Vendedor::all();
        $coleccion = collect([]);
        foreach($vendedores as $vendedor) {
            if($vendedor->persona_trabajador->persona->estado == "ACTIVO")
            {
                $coleccion->push([
                    'id' => $vendedor->id,
                    'documento' => $vendedor->persona_trabajador->persona->getDocumento(),
                    'apellidos_nombres' => $vendedor->persona_trabajador->persona->getApellidosYNombres(),
                    'telefono_movil' => $vendedor->persona_trabajador->persona->telefono_movil,
                    'area' => $vendedor->persona_trabajador->getArea(),
                    'cargo' =>$vendedor->persona_trabajador->getCargo(),
                ]);
            }

        }
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        return view('mantenimiento.vendedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($request) {

            $persona = new Persona();
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->correo_corporativo= $request->get('correo_corporativo');
            $persona->telefono_trabajo= $request->get('telefono_trabajo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->save();

            $personaTrabajador = new PersonaTrabajador();
            $personaTrabajador->persona_id = $persona->id;
            $personaTrabajador->area = $request->get('area');
            $personaTrabajador->profesion = $request->get('profesion');
            $personaTrabajador->cargo = $request->get('cargo');
            $personaTrabajador->telefono_referencia = $request->get('telefono_referencia');
            $personaTrabajador->contacto_referencia = $request->get('contacto_referencia');
            $personaTrabajador->grupo_sanguineo = $request->get('grupo_sanguineo');
            $personaTrabajador->alergias = $request->get('alergias');
            $personaTrabajador->numero_hijos = $request->get('numero_hijos');
            $personaTrabajador->sueldo = $request->get('sueldo');
            $personaTrabajador->sueldo_bruto = $request->get('sueldo_bruto');
            $personaTrabajador->sueldo_neto = $request->get('sueldo_neto');
            $personaTrabajador->moneda_sueldo = $request->get('moneda_sueldo');
            $personaTrabajador->tipo_banco = $request->get('tipo_banco');
            $personaTrabajador->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $personaTrabajador->nombre_imagen = $name;
                $personaTrabajador->ruta_imagen = $request->file('imagen')->store('public/colaboradores/imagenes');
            }

            $personaTrabajador->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $personaTrabajador->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $personaTrabajador->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $personaTrabajador->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $personaTrabajador->save();
            $colaborador=new Vendedor();
            $colaborador->persona_trabajador_id = $personaTrabajador->id;
            $colaborador->save();
            //Registro de actividad
            $descripcion = "SE AGREGÓ EL VENDEDOR CON EL NOMBRE: ". $personaTrabajador->persona->nombres.' '.$personaTrabajador->persona->apellido_paterno.' '.$personaTrabajador->persona->apellido_materno;
            $gestion = "vendedores";
            crearRegistro($colaborador, $descripcion , $gestion);

        });



        Session::flash('success', 'Vendedor creado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('guardar', 'success');
    }

    public function edit($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('mantenimiento.vendedores.edit', [
            'vendedor' => $vendedor
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $vendedor = Vendedor::findOrFail($id);
        DB::transaction(function () use ($request, $vendedor) {

            $persona =  $vendedor->persona_trabajador->persona;
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->correo_corporativo= $request->get('correo_corporativo');
            $persona->telefono_trabajo= $request->get('telefono_trabajo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->update();


            $vendedor->persona_trabajador->area = $request->get('area');
            $vendedor->persona_trabajador->profesion = $request->get('profesion');
            $vendedor->persona_trabajador->cargo = $request->get('cargo');
            $vendedor->persona_trabajador->telefono_referencia = $request->get('telefono_referencia');
            $vendedor->persona_trabajador->contacto_referencia = $request->get('contacto_referencia');
            $vendedor->persona_trabajador->grupo_sanguineo = $request->get('grupo_sanguineo');
            $vendedor->persona_trabajador->alergias = $request->get('alergias');
            $vendedor->persona_trabajador->numero_hijos = $request->get('numero_hijos');
            $vendedor->persona_trabajador->sueldo = $request->get('sueldo');
            $vendedor->persona_trabajador->sueldo_bruto = $request->get('sueldo_bruto');
            $vendedor->persona_trabajador->sueldo_neto = $request->get('sueldo_neto');
            $vendedor->persona_trabajador->moneda_sueldo = $request->get('moneda_sueldo');
            $vendedor->persona_trabajador->tipo_banco = $request->get('tipo_banco');
            $vendedor->persona_trabajador->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                //Eliminar Archivo anterior
                Storage::delete($vendedor->persona_trabajador->ruta_imagen);
                //Agregar nuevo archivo
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $vendedor->persona_trabajador->nombre_imagen = $name;
                $vendedor->persona_trabajador->ruta_imagen = $request->file('imagen')->store('public/vendedores/imagenes');
            }else{
                if ($vendedor->persona_trabajador->ruta_imagen) {
                    //Eliminar Archivo anterior
                    Storage::delete($vendedor->persona_trabajador->ruta_imagen);
                    $vendedor->persona_trabajador->nombre_imagen = '';
                    $vendedor->persona_trabajador->ruta_imagen = '';
                }
            }

            $vendedor->persona_trabajador->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $vendedor->persona_trabajador->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $vendedor->persona_trabajador->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $vendedor->persona_trabajador->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $vendedor->persona_trabajador->update();
            //Registro de actividad
            $descripcion = "SE MODIFICÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->persona_trabajador->persona->nombres.' '.$vendedor->persona_trabajador->persona->apellido_paterno.' '.$vendedor->persona_trabajador->persona->apellido_materno;
            $gestion = "vendedores";
            modificarRegistro($vendedor, $descripcion , $gestion);
        });



        Session::flash('success', 'Vendedor modificado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('modificar', 'success');
    }

    public function show($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('mantenimiento.vendedores.show', [
            'vendedor' => $vendedor
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $vendedor = Vendedor::findOrFail($id);
            $persona = $vendedor->persona_trabajador->persona;
            $persona->estado = 'ANULADO';
            $persona->update();

            //Registro de actividad
            $descripcion = "SE ELIMINÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->persona_trabajador->persona->nombres.' '.$vendedor->persona_trabajador->persona->apellido_paterno.' '.$vendedor->persona_trabajador->persona->apellido_materno;
            $gestion = "vendedores";
            eliminarRegistro($vendedor, $descripcion , $gestion);
        });




        Session::flash('success', 'Vendedor eliminado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('eliminar', 'success');
    }

    public function getDni(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        /*if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $persona = Persona::findOrFail($data['id']);
                if ($persona->tipo_documento == $data['tipo_documento'] && $persona->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $persona = Persona::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $persona = Persona::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($persona) && !is_null($persona->empleado->vendedor)) {
                $existe = true;
            }
        }*/

        $result = [
            'existe' => $existe,
            'igual_persona' => $igualPersona
        ];

        return response()->json($result);
    }
}
