<?php

namespace App\Listeners;

use App\Ventas\Documento\Detalle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Luecano\NumeroALetras\NumeroALetras;

class GenerarComprobante
{
    public function handle($event)
    {
        
        //ARREGLO COMPROBANTE
        $arreglo_comprobante = array(
            "tipoOperacion" => $event->documento->tipoOperacion(),
            "tipoDoc"=> $event->documento->tipoDocumento(),
            "serie" => $event->serie,
            "correlativo" => $event->documento->correlativo,
            "fechaEmision" => self::obtenerFecha($event),
            "observacion" => $event->documento->observacion,
            "tipoMoneda" => $event->documento->simboloMoneda(),
            "client" => array(
                "tipoDoc" => $event->documento->tipoDocumentoCliente(),
                "numDoc" => $event->documento->documento_cliente,
                "rznSocial" => $event->documento->cliente,
                "address" => array(
                    "direccion" => $event->documento->direccion_cliente,
                )),
            "company" => array(
                "ruc" =>  $event->documento->ruc_empresa,
                "razonSocial" => $event->documento->empresa,
                "address" => array(
                    "direccion" => $event->documento->direccion_fiscal_empresa,
                )),
            "mtoOperGravadas" => $event->documento->sub_total,
            "mtoOperExoneradas" => 0,
            "mtoIGV" => $event->documento->total_igv,
            
            "valorVenta" => $event->documento->sub_total,
            "totalImpuestos" => $event->documento->total_igv,
            "mtoImpVenta" => $event->documento->total ,
            "ublVersion" => "2.1",
            "details" => self::obtenerProductos($event->documento->id),
            "legends" =>  self::obtenerLeyenda($event),
        );

        return json_encode($arreglo_comprobante);


    }
    public function obtenerLeyenda($event)
    {
        $formatter = new NumeroALetras();
        $convertir = $formatter->toInvoice($event->documento->total, 2, 'SOLES');

        //CREAR LEYENDA DEL COMPROBANTE
        $arrayLeyenda = Array();
        $arrayLeyenda[] = array(  
            "code" => "1000",
            "value" => $convertir
        );
        return $arrayLeyenda;
    }

    public function obtenerProductos($id)
    {
        $detalles =  Detalle::where('documento_id',$id)->get();
        $arrayProductos = Array();
        for($i = 0; $i < count($detalles); $i++){

            $arrayProductos[] = array(
                "codProducto" => $detalles[$i]->codigo_producto,
                "unidad" => $detalles[$i]->unidad,
                "descripcion"=> $detalles[$i]->nombre_producto.' - '.$detalles[$i]->codigo_lote,
                "cantidad" => $detalles[$i]->cantidad,
                "mtoValorUnitario" => $detalles[$i]->precio / 1.18,
                "mtoValorVenta" => ($detalles[$i]->precio / 1.18) * $detalles[$i]->cantidad,
                "mtoBaseIgv" => ($detalles[$i]->precio / 1.18) * $detalles[$i]->cantidad, 
                "porcentajeIgv" => 18,
                "igv" => ($detalles[$i]->precio - ($detalles[$i]->precio / 1.18 )) * $detalles[$i]->cantidad,
                "tipAfeIgv" => 10,
                "totalImpuestos" =>  ($detalles[$i]->precio - ($detalles[$i]->precio / 1.18 )) * $detalles[$i]->cantidad,
                "mtoPrecioUnitario" => $detalles[$i]->precio

            );
        }

        return $arrayProductos;
    }

    public function obtenerFecha($event)
    {
        $date = strtotime($event->documento->fecha_documento);
        $fecha_emision = date('Y-m-d', $date); 
        $hora_emision = date('H:i:s', $date); 
        $fecha = $fecha_emision.'T'.$hora_emision.'-05:00';

        return $fecha;
    }
}
