<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Pos\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class CajaController extends Controller
{
    public function index()
    {
        return view('pos.caja_chica.index');
    }
    public function getBox(){

        $cajas = DB::table('pos_caja_chica')
        ->join('colaboradores','pos_caja_chica.colaborador_id','=','colaboradores.id')
        ->join('personas','colaboradores.persona_id','=','personas.id')
        ->select('pos_caja_chica.*','colaboradores.id as empleado_id','personas.apellido_materno','personas.apellido_paterno','personas.nombres',DB::raw('CONCAT(personas.apellido_paterno,\' \',personas.apellido_materno,\' \',personas.nombres) AS nombre_completo'),DB::raw('DATE_FORMAT(pos_caja_chica.created_at, "%d/%m/%Y %h:%i:%s ") as creado'), DB::raw('DATE_FORMAT(cierre, "%d/%m/%Y %h:%i:%s") as cierre'))
        ->where('pos_caja_chica.estado','!=',"ANULADO")
        ->get();

        $coleccion = collect([]);
       

        foreach($cajas as $caja){
                
                $tipo_moneda = '';
                foreach(tipos_moneda() as $moneda){
                    if ($moneda->descripcion == $caja->moneda) {
                        $tipo_moneda= $moneda->simbolo;
                    }
                }
                
                $restante = calcularMontoRestanteCaja($caja->id);
                $ventas = calcularSumaMontosPagosVentas($caja->id);
                
                $quedando = $caja->saldo_inicial - $restante;
                $total_ventas = $quedando+$ventas;
                
                //EVALUAR MONTO EN CAJA 
                self::ventasCaja($caja->id, $ventas);
                $coleccion->push([
                    'id' => $caja->id,
                    'empleado_id' => $caja->empleado_id,
                    'num_referencia' => $caja->num_referencia,
                    'nombre_completo' => $caja->nombre_completo,
                    'creado' => $caja->creado,
                    'cierre' => $caja->cierre,
                    'restante' => number_format($total_ventas,2,'.',''),
                    'saldo_inicial' => $caja->saldo_inicial,
                    'moneda' => $tipo_moneda.' '.$caja->moneda,
                    'estado' => $caja->estado,
                    'uso' => $caja->uso,
                    ]);
        }
          


        return DataTables::of($coleccion)->toJson();

        
    }

    public function ventasCaja($caja,$ventas)
    {
        //VENTAS EN CAJA -> 1 SIN VENTAS O BORRADAS -> 0
        $caja_old = Caja::findOrFail($caja);
        if ($ventas == 0 ) {
            $caja_old->uso = '0';
        }else{
            $caja_old->uso = '1';
        }
        $caja_old->update();


    }
    public function store(Request $request){

        
        $data = $request->all();

        $rules = [
            'empleado_id' => 'required',
            'saldo_inicial' => 'required',
            'moneda' => 'required',
        ];
        
        $message = [
            'empleado_id.required' => 'El campo Empleado es obligatorio.',
            'saldo_inicial.required' => 'El campo Saldo Inicial es obligatorio.',
            'moneda.required' => 'El campo Moneda es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $caja = new Caja();
        $caja->colaborador_id = $request->get('empleado_id');
        $caja->saldo_inicial = $request->get('saldo_inicial');
        $caja->num_referencia = $request->get('num_referencia');
        $caja->moneda = $request->get('moneda');
        $caja->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA CAJA CHICA DEL COLABORADOR CON EL NOMBRE: ". $caja->empleado->persona->nombres.' '.$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno;
        $gestion = "CAJA CHICA";
        crearRegistro($caja, $descripcion , $gestion);

        Session::flash('success','Caja Chica creada.');
        return redirect()->route('pos.caja.index')->with('guardar', 'success');
    }

    public function update(Request $request){

        $data = $request->all();

        $rules = [
            'caja_id' => 'required',
            'empleado_id_editar' => 'required',
            'saldo_inicial_editar' => 'required',
        ];
        
        $message = [
            'empleado_id_editar.required' => 'El campo Empleado es obligatorio.',
            'saldo_inicial_editar.required' => 'El campo Saldo Inicial es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();
        
        $caja = Caja::findOrFail($request->get('caja_id'));
        $caja->colaborador_id = $request->get('empleado_id_editar');
        $caja->saldo_inicial = $request->get('saldo_inicial_editar');
        $caja->num_referencia = $request->get('num_referencia_editar');
        $caja->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA CAJA CHICA DEL COLABORADOR CON EL NOMBRE: ". $caja->empleado->persona->nombres.' '.$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno;
        $gestion = "CAJA CHICA";
        modificarRegistro($caja, $descripcion , $gestion);

        Session::flash('success','Caja chica modificada.');
        return redirect()->route('pos.caja.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        $caja = Caja::findOrFail($id);
        $restante = calcularMontoRestanteCaja($id);

        if ($restante != $caja->saldo_inicial && $restante != 0) {
            Session::flash('error','No es posible eliminar Caja Chica.');
            return redirect()->route('pos.caja.index')->with('error_caja', 'success');
            
        }else{
            $caja->estado = 'ANULADO';
            $caja->update();
       
            //Registro de actividad
            $descripcion = "SE ELIMINÓ LA CAJA CHICA DEL EMPLEADO CON EL NOMBRE: ". $caja->empleado->persona->nombres.' '.$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno;
            $gestion = "CAJA CHICA";
            eliminarRegistro($caja, $descripcion , $gestion);
       
            Session::flash('success','Caja eliminado.');
            return redirect()->route('pos.caja.index')->with('eliminar', 'success');
        }
        




    }

    public function cerrar($id)
    {
        
        $caja_old = Caja::findOrFail($id);
        $caja_old->estado = 'CERRADA';
        $caja_old->update();

        $caja = Caja::findOrFail($id);
        $caja->cierre = $caja_old->updated_at;
        $caja->update();

        Session::flash('success','Caja Chica Cerrada.');
        return redirect()->route('pos.caja.index')->with('cerrada', 'success');

    }

    public function getEmployee(){

        $colaboradores = DB::table('colaboradores')
        ->join('personas','colaboradores.id','=','personas.id')
        ->select('colaboradores.id as empleado_id', 'personas.*')
        ->where('colaboradores.estado','!=',"ANULADO")
        ->get();

        return $colaboradores;
    }
}
