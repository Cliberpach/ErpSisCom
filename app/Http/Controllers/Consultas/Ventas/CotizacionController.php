<?php

namespace App\Http\Controllers\Consultas\Ventas;

use App\Http\Controllers\Controller;
use App\Ventas\Cotizacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        return view('consultas.ventas.cotizaciones.index');
    }

    public function getTable(Request $request){

        if($request->fecha_desde && $request->fecha_hasta)
        {
            $cotizaciones = Cotizacion::where('estado','!=','ANULADO')->whereBetween('fecha_documento', [$request->fecha_desde, $request->fecha_hasta])->orderBy('id', 'desc')->get();
        }
        else
        {
            $cotizaciones = Cotizacion::where('estado','!=','ANULADO')->orderBy('id', 'desc')->get();
        }
        

        
        $coleccion = collect();
        foreach($cotizaciones as $cotizacion){
            $coleccion->push([
                'id' => $cotizacion->id,
                'empresa' => $cotizacion->empresa->razon_social,
                'cliente' => $cotizacion->cliente->nombre,
                'fecha_documento' => Carbon::parse($cotizacion->fecha_documento)->format( 'd/m/Y'),
                'total' => $cotizacion->total,
                'estado' => $cotizacion->estado
            ]);
        }

        return response()->json([
            'success' => true,
            'cotizaciones' => $coleccion
        ]);
    }
}
