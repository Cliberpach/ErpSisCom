<?php

namespace App\Http\Controllers;

use App\Pos\DetalleMovimientoEgresosCaja;
use App\Pos\Egreso;
use App\Pos\MovimientoCaja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EgresoController extends Controller
{
    public function index()
    {
        return view('Egreso.index');
    }
    public function getEgresos()
    {
        $datos = Egreso::where('estado', 'ACTIVO')->get();
        $data = array();
        foreach ($datos as $key => $value) {
            array_push($data, array(
                'id' => $value->id,
                'descripcion' => $value->descripcion,
                'importe' => $value->importe,
                'estado' => $value->estado,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('Y-m-d h:i:s')
            ));
        }
        return DataTables::of($data)->toJson();
    }
    public function store(Request $request)
    {
        $egreso = new Egreso();
        $egreso->descripcion = $request->descripcion;
        $egreso->importe = $request->importe;
        $egreso->save();
        $ultimoMovimiento = MovimientoCaja::orderBy('id', 'desc')->first();
        $detalleMovimientoEgreso = new DetalleMovimientoEgresosCaja();
        $detalleMovimientoEgreso->mcaja_id = $ultimoMovimiento->id;
        $detalleMovimientoEgreso->egreso_id = $egreso->id;
        $detalleMovimientoEgreso->save();

        return redirect()->route('Egreso.index');
    }
    public function update(Request $request, $id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->descripcion = $request->descripcion_editar;
        $egreso->importe = $request->importe_editar;
        $egreso->save();
        return redirect()->route('Egreso.index');
    }
    public function getEgreso(Request $request)
    {
        return Egreso::findOrFail($request->id);
    }
    public function destroy($id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->estado = "ANULADO";
        $egreso->save();
        return redirect()->route('Egreso.index');
    }
}
