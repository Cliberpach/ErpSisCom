<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Mantenimiento\Colaborador\Colaborador;
use App\Pos\Caja;
use App\Pos\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CajaController extends Controller
{

    public function index(){
        return view('pos.Cajas.index');
    }
    public function store(Request $request){
        $caja=new Caja();
        $caja->nombre=$request->nombre;
        $caja->save();
        return redirect()->route('Caja.index');
    }
    public function update(Request $request,$id)
    {
        $caja=Caja::findOrFail($id);
        $caja->nombre=$request->nombre;
        $caja->save();
        return redirect()->route('Caja.index');
    }
    public function destroy($id)
    {

    }
    public function indexMovimiento()
    {
        $colaboradores = Colaborador::where('estado', 'ACTIVO')->get();
        return view('pos.MovimientoCaja.indexMovimiento', compact('colaboradores'));
    }
    public function getMovimientosCajas()
    {
        $datos = array();
        $movimientos = MovimientoCaja::get();
        foreach ($movimientos as $key => $movimiento) {
            array_push($datos, array(
                'id' => $movimiento->id,
                'caja' => $movimiento->caja->nombre,
                'cantidad_inicial' => $movimiento->monto_inicial,
                'cantidad_final' => $movimiento->monto_final == null ? "-" : $movimiento->monto_final,
                'fecha_Inicio' => $movimiento->fecha_apertura,
                'fecha_Cierre' => $movimiento->fecha_cierre == null ? "-" : $movimiento->fecha_cierre
            ));
        }
        return DataTables::of($datos)->toJson();
    }
    public function estadoCaja()
    {
        $mensaje = "Sin Aperturar";
        $consulta = MovimientoCaja::orderBy('id', 'desc');
        if ($consulta->count() !== 0) {
            $movimientofinal = $consulta->first();
            $mensaje = $movimientofinal->estado_movimiento == "APERTURA" ? "Aperturado" : $mensaje;
        }
        return $mensaje;
    }
    public function aperturaCaja(Request $request)
    {
        $movimiento = new MovimientoCaja();
        $movimiento->caja_id = $request->caja; //como solo hay una caja siempre será 1
        $movimiento->colaborador_id = $request->colaborador_id;
        $movimiento->monto_inicial = $request->saldo_inicial;
        $movimiento->estado_movimiento = "APERTURA";
        $movimiento->fecha_apertura = date('Y-m-d h:i:s');
        $movimiento->save();
        return redirect()->route('Caja.Movimiento.index');
    }
    public function cerrarCaja(Request $request)
    {
        $ultimoMovimiento = MovimientoCaja::orderBy('id', 'desc')->first();
        $movimiento =MovimientoCaja::findOrFail($ultimoMovimiento->id);
        $movimiento->estado_movimiento = "CIERRE";
        $movimiento->fecha_cierre= date('Y-m-d h:i:s');
        $movimiento->monto_final= $request->saldo;
        $movimiento->save();
        return redirect()->route('Caja.Movimiento.index');
    }
    public function cajaDatosCierre()
    {
        $ultimoMovimiento = MovimientoCaja::orderBy('id', 'desc')->first();
        $colaborador = $ultimoMovimiento->colaborador;
        $ingresos = $ultimoMovimiento->totalIngresos($ultimoMovimiento->detalleMovimientoVentas);
        $egresos = $ultimoMovimiento->totalEgresos($ultimoMovimiento->detalleMoviemientoEgresos);
        return array(
            "monto_inicial" => $ultimoMovimiento->monto_inicial,
            "colaborador" => $colaborador->persona->apellido_paterno . " " . $colaborador->persona->apellido_paterno . " " . $colaborador->persona->nombre,
            "egresos" => $egresos,
            "ingresos" => $ingresos,
            "saldo" => ($ultimoMovimiento->monto_inicial + $ingresos) - $egresos
        );
    }
}
