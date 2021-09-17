<?php

namespace App\Http\Controllers\Mantenimiento\Vendedor;

use App\Http\Controllers\Controller;
use App\Mantenimiento\Persona\PersonaVendedor;
use App\Mantenimiento\Vendedor\Vendedor;
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
        $vendedores = Vendedor::where('estado','ACTIVO')->get();
        $coleccion = collect([]);
        foreach($vendedores as $vendedor){
            $coleccion->push([
                'id' => $vendedor->id,
                'documento' => $vendedor->persona->getDocumento(),
                'apellidos_nombres' => $vendedor->persona->getApellidosYNombres(),
                'telefono_movil' => $vendedor->persona->telefono_movil,
                'area' => $vendedor->area,
                'zona' => $vendedor->zona
            ]);
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

            $persona = new PersonaVendedor();
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
            $persona->estado_documento = $request->get('estado_documento');
            $persona->save();

            $vendedor = new Vendedor();
            $vendedor->persona_id = $persona->id;
            $vendedor->area = $request->get('area');
            $vendedor->profesion = $request->get('profesion');
            $vendedor->cargo = $request->get('cargo');
            $vendedor->telefono_referencia = $request->get('telefono_referencia');
            $vendedor->contacto_referencia = $request->get('contacto_referencia');
            $vendedor->grupo_sanguineo = $request->get('grupo_sanguineo');
            $vendedor->alergias = $request->get('alergias');
            $vendedor->numero_hijos = $request->get('numero_hijos');
            $vendedor->sueldo = $request->get('sueldo');
            $vendedor->sueldo_bruto = $request->get('sueldo_bruto');
            $vendedor->sueldo_neto = $request->get('sueldo_neto');
            $vendedor->moneda_sueldo = $request->get('moneda_sueldo');
            $vendedor->tipo_banco = $request->get('tipo_banco');
            $vendedor->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $vendedor->nombre_imagen = $name;
                $vendedor->ruta_imagen = $request->file('imagen')->store('public/vendedores/imagenes');
            }

            $vendedor->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $vendedor->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $vendedor->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $vendedor->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $vendedor->zona = $request->get('zona');
            $vendedor->comision = $request->get('comision');
            $vendedor->moneda_comision = $request->get('moneda_comision');
            $vendedor->save();

            //Registro de actividad
            $descripcion = "SE AGREGÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->persona->nombres.' '.$vendedor->persona->apellido_paterno.' '.$vendedor->persona->apellido_materno;
            $gestion = "VENDEDORES";
            crearRegistro($vendedor, $descripcion , $gestion);

        });



        Session::flash('success','Vendedor creado.');
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

            $persona =  $vendedor->persona;
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
            $persona->estado_documento = $request->get('estado_documento');
            $persona->update();

            $vendedor = $persona->empleado;
            $vendedor->persona_id = $persona->id;
            $vendedor->area = $request->get('area');
            $vendedor->profesion = $request->get('profesion');
            $vendedor->cargo = $request->get('cargo');
            $vendedor->telefono_referencia = $request->get('telefono_referencia');
            $vendedor->contacto_referencia = $request->get('contacto_referencia');
            $vendedor->grupo_sanguineo = $request->get('grupo_sanguineo');
            $vendedor->alergias = $request->get('alergias');
            $vendedor->numero_hijos = $request->get('numero_hijos');
            $vendedor->sueldo = $request->get('sueldo');
            $vendedor->sueldo_bruto = $request->get('sueldo_bruto');
            $vendedor->sueldo_neto = $request->get('sueldo_neto');
            $vendedor->moneda_sueldo = $request->get('moneda_sueldo');
            $vendedor->tipo_banco = $request->get('tipo_banco');
            $vendedor->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                //Eliminar Archivo anterior
                Storage::delete($vendedor->ruta_imagen);
                //Agregar nuevo archivo
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $vendedor->nombre_imagen = $name;
                $vendedor->ruta_imagen = $request->file('imagen')->store('public/vendedores/imagenes');
            }else{
                if ($vendedor->ruta_imagen) {
                    //Eliminar Archivo anterior
                    Storage::delete($vendedor->ruta_imagen);
                    $vendedor->nombre_imagen = '';
                    $vendedor->ruta_imagen = '';
                }
            }

            $vendedor->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $vendedor->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $vendedor->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $vendedor->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }

            $vendedor->zona = $request->get('zona');
            $vendedor->comision = $request->get('comision');
            $vendedor->moneda_comision = $request->get('moneda_comision');
            $vendedor->update();

            //Registro de actividad
            $descripcion = "SE MODIFICÓ EL VENDEDOR CON EL NOMBRE: ".$vendedor->persona->nombres.' '.$vendedor->persona->apellido_paterno.' '.$vendedor->persona->apellido_materno;
            $gestion = "VENDEDORES";
            modificarRegistro($vendedor, $descripcion , $gestion);

        });



        Session::flash('success','Vendedor modificado.');
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
        DB::transaction(function() use ($id) {

            $vendedor = Vendedor::findOrFail($id);
            $vendedor->estado = 'ANULADO';
            $vendedor->update();


            $persona = $vendedor->persona;
            $persona->estado = 'ANULADO';
            $persona->update();

            //Registro de actividad
            $descripcion = "SE ELIMINÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->persona->nombres.' '.$vendedor->persona->apellido_paterno.' '.$vendedor->persona->apellido_materno;
            $gestion = "VENDEDORES";
            eliminarRegistro($vendedor, $descripcion , $gestion);

        });




        Session::flash('success','Vendedor eliminado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('eliminar', 'success');
    }

    public function getDni(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $persona = PersonaVendedor::findOrFail($data['id']);
                if ($persona->tipo_documento == $data['tipo_documento'] && $persona->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $persona = PersonaVendedor::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $persona = PersonaVendedor::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($persona) && !is_null($persona->empleado->vendedor)) {
                $existe = true;
            }
        }

        $result = [
            'existe' => $existe,
            'igual_persona' => $igualPersona
        ];

        return response()->json($result);
    }
}

