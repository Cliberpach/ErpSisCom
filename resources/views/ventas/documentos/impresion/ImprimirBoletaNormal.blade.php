<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>documento Delivery</title>
        <style>
            .tipo-letra {
                font-size: 9pt;
                font-family: Arial, Helvetica, sans-serif;
                color: black;
            }

            .cuadroDerecha {
                position: relative;
                left: 70%;
                border: 1px #ccc solid;
                border-radius: 10px;
                padding: 5px;
                width: 20%;
                height: 80px;
            }

            .cuadroDerecha .title {

                margin-top: 5px !important;
                font-size: 15px;
                text-align: center;
            }

            .img-left
            {
                position: absolute;
                left: 0%;
                width: 20%;
            }

            .img-fluid 
            {
                width: 120px;
                height: 90px;
            }

            .div-left
            {
                position: absolute;
                font-size: 16px;
                text-transform: uppercase;
                left: 18%;
                width: 60%;

            }

            .nombre {
                position: relative;
                font-size: 14px;
                top: 10px;
                left: 5%;
            }

            .dni {
                position: absolute;
                font-size: 14px;
                top:10.8%;
                left: 48%;
            }

            .fecha {
                position: absolute;
                width: 200px;
                top: 10.8%;
                left: 66%;
                font-size: 14px;
            }
            .direccion{
                position: relative;
                font-size: 14px;
                top:10px;
                left: 5%;
            }
            .ruc{
                font-size: 14px;
                text-align: center;
            }
            .cabeceraTabla{
                border-top:1px solid;
                background-color: rgb(241, 239, 239);
            }
            .cuerpoTabla{
                border-top:1px solid;
                border-bottom:1px solid;
            }
        </style>
    </head>

    <body>
        <div style="width: 100%; margin-left: -9mm; margin-right: -9mm; margin-top: -5mm" class="tipo-letra">
            <div class="cabecera">
                <div class="img-left">
                    <img src="{{ base_path() . '/storage/app/'.$empresa->ruta_logo }}" class="img-fluid">
                </div>
                <div class="div-left">
                    {{ DB::table('empresas')->count() == 0 ? 'SISCOM ' : DB::table('empresas')->first()->razon_social }}
                </div>
                <div class="cuadroDerecha">
                    <br>
                    <div class="title">BOLETA DE VENTA
                        <br>
                        {{$documento->serie.'-'.$documento->correlativo}}
                    </div>
                </div>
            </div>
            
            <br>
            <div style="position:absolute;left: 18%;top:17px;">
                <p style="font-size: 15px;text-transform: uppercase; margin: 0; padding: 0;">RUC {{ DB::table('empresas')->count() == 0 ? '- ' : DB::table('empresas')->first()->ruc }}</p>
                <p style="font-size: 12px;text-transform: uppercase; margin: 0; padding: 0;">{{ DB::table('empresas')->count() == 0 ? '- ' : DB::table('empresas')->first()->direccion_fiscal }}</p>
                <p style="font-size: 12px; margin: 0; padding: 0;">Central telefónica: {{ DB::table('empresas')->count() == 0 ? '-' : DB::table('empresas')->first()->celular }}</p>
                <p style="font-size: 12px; margin: 0; padding: 0;">Email: {{ DB::table('empresas')->count() == 0 ? '-' : DB::table('empresas')->first()->correo }}</p>
            </div>
            <div class="nombre">
                Cliente: {{ $documento->clienteEntidad->nombre }}
            </div>
            <div class="dni">
                Dni: {{ $documento->clienteEntidad->documento }}
            </div>
            <div class="direccion">
                Direccion: {{ $documento->clienteEntidad->direccion }}
            </div>
            <div class="fecha">
                Fecha: {{ getFechaFormato( $documento->fecha_documento ,'d/m/Y')}}</div>
            </div>
            <br>
            <br>
            <table style="width: 100%">
                <thead class="cabeceraTabla">
                    <tr >
                        <th style="text-align: center">Cantidad</th>
                        <th style="text-align: center">Descripción</th>
                        <th style="text-align: center">Precio</th>
                        <th style="text-align: center">Total</th>

                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    @foreach ($detalles as $item)
                    <tr>
                        <td style="text-align: center">{{ $item->cantidad }}</td>
                        <td style="text-align: center">{{ $item->nombre_producto }}</td>
                        <td style="text-align: center">{{ number_format($item->precio_nuevo, 2) }}</td>
                        <td style="text-align: center">{{ number_format($item->valor_venta, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" hidden></th>
                        <th style="text-align:center">Sub Total S/.</th>
                        <th style="text-align:center">{{ number_format($documento->sub_total, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2" hidden></th>
                        <th style="text-align:center">IGV S/.</th>
                        <th style="text-align:center">{{ number_format($documento->total_igv, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2" hidden></th>
                        <th style="text-align:center">Total S/.</th>
                        <th style="text-align:center">{{ number_format($documento->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            <br><br>
            <img src="{{ base_path() . '/storage/app/'.$documento->ruta_qr }}">
        </div>


    </body>
</html>
