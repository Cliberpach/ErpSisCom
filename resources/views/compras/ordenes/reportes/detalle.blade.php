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
                @if($orden->empresa->ruta_logo)
                <img src="{{ base_path() . '/storage/app/'.$orden->empresa->ruta_logo }}">
                @else
                <img src="{{asset('storage/empresas/logos/default.png')}}">
                @endif
            </div>
            
            <div id="company">
                <h2 class="name">{{$orden->empresa->razon_social}}</h2>
                <div>RUC:{{$orden->empresa->ruc}}</div>
                <div>{{$orden->empresa->direccion_fiscal}}</div>
            </div>
      </div>
    
    </header>

    <main>
      <div id="details" class="clearfix">




        <div id="invoice">
            
          <table cellspacing="0" cellpadding="0" id="tabla-orden">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">ORDEN DE COMPRA</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="datos-orden-titulo">
                        N°:
                    </th>

                    <th class="datos-orden">
                        OC - {{$orden->id}}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA EMISION:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($orden->fecha_emision)->format('d/m/y') }}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA ENTREGA:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($orden->fecha_entrega)->format('d/m/y') }}
                    </th>

                </tr>
            </tbody>

          </table>
          
        </div>

        <div id="client">

            <div class="to">CONTACTO:</div>
            <h2 class="name">{{$nombre_completo}}</h2>
            <div class="address">{{$orden->usuario->empleado->persona->telefono_movil}}</div>
            <div class="email"><a href="mailto:{{$orden->usuario->empleado->persona->correo_electronico}}">{{$orden->usuario->empleado->persona->correo_electronico}}</a></div>
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
                    {{$orden->proveedor->descripcion}}
                </th>

            </tr>

            @if($orden->proveedor->ruc)

            <tr>
                <th class="datos-proveedor-titulo">
                    RUC:
                </th>

                <th class="datos-proveedor">
                    {{$orden->proveedor->ruc}}
                </th>

            </tr>

            @else
            <tr>
                <th class="datos-proveedor-titulo">
                    DNI:
                </th>

                <th class="datos-proveedor">
                    {{$orden->proveedor->dni}}
                </th>

            </tr>
            @endif

            <tr>
                <th class="datos-proveedor-titulo">
                    DIRECCION:
                </th>

                <th class="datos-proveedor">
                    {{$orden->proveedor->direccion}}
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    CONTACTO:
                </th>

                <th class="datos-proveedor">
                @if($orden->proveedor->contacto)
                {{$orden->proveedor->contacto}}
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
                    @if($orden->proveedor->telefono)
                    {{$orden->proveedor->telefono}}
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
                    <a href="mailto:{{$orden->proveedor->correo}}">{{$orden->proveedor->correo}}
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
            <td class="qty">{{$moneda.' '.$detalle->precio}}</td>
            <td class="total">{{$moneda.' '.$detalle->precio * $detalle->cantidad}}</td>
          </tr>
        @endforeach

        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td class="sub" colspan="1">SUBTOTAL</td>
            <td class="sub-monto">{{$moneda.'  '.$subtotal}}</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td class="sub" colspan="1">IGV {{$detalle->orden->igv}}%</td>
            <td class="sub-monto">{{$moneda.'  '.$igv}}</td>
          </tr>
          <tr>
            <td colspan="3"></td>
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
                    {{$orden->proveedor->ruc_transporte}}
                </th>

            </tr>

            <tr>
                <th class="datos-transporte-titulo">
                    EMPRESA:
                </th>

                <th class="datos-transporte">
                    {{$orden->proveedor->transporte}}
                </th>

            </tr>

            <tr>
                <th class="datos-transporte-titulo">
                    DIRECCION:
                </th>

                <th class="datos-transporte">
                    {{$orden->proveedor->direccion_transporte}}
                </th>

            </tr>

        </tbody>

      </table>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-adicional">
        <tbody>

            <tr>
                <th class="datos-adicional-titulo">
                    CONDICION DE ORDEN:
                </th>

                <th class="datos-adicional">
                    {{$orden->modo_compra}}
                </th>

            </tr>

            <tr>
                <th class="datos-adicional-titulo">
                    OBSERVACION:
                </th>

                <th class="datos-adicional">
                    {{$orden->observacion}}
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