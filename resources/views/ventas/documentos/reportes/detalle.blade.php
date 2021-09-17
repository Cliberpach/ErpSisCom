<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ecovalle | Sistema de Producción</title>
    <link rel="stylesheet" href="{{asset('css/informe.css')}}" />   
    <link rel="icon" href="{{asset('img/ecologo.ico')}}" /> 
  </head>
  <body>
    <header class="clearfix">
    
        <div>
            <div id="logo">
                @if($documento->empresa->ruta_logo)
                <img src="{{ base_path() . '/storage/app/'.$documento->empresa->ruta_logo }}">
                @else
                <img src="{{asset('storage/empresas/logos/default.png')}}">
                @endif
            </div>
            
            <div id="company">
                <h2 class="name">{{$documento->empresa->razon_social}}</h2>
                <div>RUC:{{$documento->empresa->ruc}}</div>
                <div>{{$documento->empresa->direccion_fiscal}}</div>
            </div>
      </div>
    
    </header>

    <main>
      <div id="details" class="clearfix">




        <div id="invoice">
            
          <table cellspacing="0" cellpadding="0" id="tabla-orden">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">DOCUMENTO DE COMPRA</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="datos-orden-titulo">
                        N°:
                    </th>

                    <th class="datos-orden">
                        DC - {{$documento->id}}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA EMISION:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($documento->fecha_emision)->format('d/m/y') }}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA ENTREGA:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($documento->fecha_entrega)->format('d/m/y') }}
                    </th>

                </tr>
            </tbody>

          </table>
          
        </div>

        <div id="client">

            <div class="to">CONTACTO:</div>
            <h2 class="name">{{$nombre_completo}}</h2>
            <div class="address">{{$documento->usuario->empleado->persona->telefono_movil}}</div>
            <div class="email"><a href="mailto:{{$documento->usuario->empleado->persona->correo_electronico}}">{{$documento->usuario->empleado->persona->correo_electronico}}</a></div>
        </div>



      </div>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-proveedor">
        <thead>
          <tr>
            <th colspan="2" class="text-center">DATOS DEL PROVEEDOR</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <th class="datos-proveedor-titulo">
                    RAZON SOCIAL:
                </th>

                <th class="datos-proveedor">
                    {{$documento->proveedor->descripcion}}
                </th>

            </tr>

            @if($documento->proveedor->ruc)

            <tr>
                <th class="datos-proveedor-titulo">
                    RUC:
                </th>

                <th class="datos-proveedor">
                    {{$documento->proveedor->ruc}}
                </th>

            </tr>

            @else
            <tr>
                <th class="datos-proveedor-titulo">
                    DNI:
                </th>

                <th class="datos-proveedor">
                    {{$documento->proveedor->dni}}
                </th>

            </tr>
            @endif

            <tr>
                <th class="datos-proveedor-titulo">
                    DIRECCION:
                </th>

                <th class="datos-proveedor">
                    {{$documento->proveedor->direccion}}
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    CONTACTO:
                </th>

                <th class="datos-proveedor">
                @if($documento->proveedor->contacto)
                {{$documento->proveedor->contacto}}
                @else
                -
                @endif
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    TELEFONO:
                </th>

                <th class="datos-proveedor">
                    @if($documento->proveedor->telefono)
                    {{$documento->proveedor->telefono}}
                    @else
                    -
                    @endif
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    CORREO:
                </th>

                <th class="datos-proveedor">
                    <a href="mailto:{{$documento->proveedor->correo}}">{{$documento->proveedor->correo}}
                    </a>
                </th>

            </tr>
        </tbody>

      </table>


      <table border="0" cellspacing="0" cellpadding="0" id="tabla-productos">
        <thead>
          <tr>
            <th class="no">CANT.</th>
            <th class="desc">PRESENTACION</th>
            <th class="unit">PRODUCTO</th>
            <th class="qty">COSTO FLETE</th>
            <th class="qty">PRECIO</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>

        @foreach($detalles as $detalle)
          <tr>
            <td class="no">{{$detalle->cantidad}}</td>
            <td class="desc">
            @foreach($presentaciones as $presentacion)
                @if($presentacion->descripcion == $detalle->articulo->presentacion)
                    {{$presentacion->simbolo}}
                @endif
            @endforeach
            </td>
            <td class="unit">{{$detalle->articulo->descripcion}}</td>
            <td class="qty">{{$moneda.' '.$detalle->costo_flete}}</td>
            <td class="qty">{{$moneda.' '.$detalle->precio}}</td>
            <td class="total">{{$moneda.' '.$detalle->precio * $detalle->cantidad}}</td>
          </tr>
        @endforeach

        </tbody>
        <tfoot>
          <tr>
            <td colspan="4"></td>
            <td class="sub" colspan="1">SUBTOTAL</td>
            <td class="sub-monto">{{$moneda.'  '.$subtotal}}</td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td class="sub" colspan="1">IGV 
                @if($detalle->documento->igv)
                    {{$detalle->documento->igv}}%
                @else
                    18%
                @endif
                </td>
            <td class="sub-monto">{{$moneda.'  '.$igv}}</td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td class="sub" colspan="1">TOTAL</td>
            <td class="sub-monto">{{$moneda.'  '.$total}}</td>
          </tr>
        </tfoot>
      </table>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-transporte">
        <thead>
          <tr>
            <th colspan="2" class="text-center">DATOS DEL TRANSPORTISTA</th>
          </tr>
        </thead>
        <tbody>

            <tr>
                <th class="datos-transporte-titulo">
                    RUC:
                </th>

                <th class="datos-transporte">
                    {{$documento->proveedor->ruc_transporte}}
                </th>

            </tr>

            <tr>
                <th class="datos-transporte-titulo">
                    EMPRESA:
                </th>

                <th class="datos-transporte">
                    {{$documento->proveedor->transporte}}
                </th>

            </tr>

            <tr>
                <th class="datos-transporte-titulo">
                    DIRECCION:
                </th>

                <th class="datos-transporte">
                    {{$documento->proveedor->direccion_transporte}}
                </th>

            </tr>

        </tbody>

      </table>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-adicional">
        <tbody>

            <tr>
                <th class="datos-adicional-titulo">
                    TIPO DE DOCUMENTO:
                </th>

                <th class="datos-adicional">
                    {{$documento->tipo_compra}}
                </th>

            </tr>

            <tr>
                <th class="datos-adicional-titulo">
                    CONDICION DE DOCUMENTO:
                </th>

                <th class="datos-adicional">
                    {{$documento->modo_compra}}
                </th>

            </tr>

            <tr>
                <th class="datos-adicional-titulo">
                    OBSERVACION:
                </th>

                <th class="datos-adicional">
                    {{$documento->observacion}}
                </th>

            </tr>

        </tbody>

      </table>

    </main>
    <footer>
      SISCOM SAC
    </footer>
  </body>
</html>