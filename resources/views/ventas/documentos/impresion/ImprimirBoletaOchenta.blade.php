<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Venta Nº {{ $documento->id }}</title>
    <style>
        .tipo-letra {
            font-size: 9pt;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }

    </style>
</head>

<body>
    <div style="width: 100%; margin-left: -9mm; margin-right: -9mm; margin-top: -5mm" class="tipo-letra">
        <div style="text-align: center; font-size: 12pt">
            <span>***** Restaurant *****</span>
        </div>
        <br>
        <div style="text-align: center; font-size: 12pt">
            <span>{{ DB::table('empresas')->count() == 0 ? 'SISCOM' : DB::table('empresas')->first()->razon_social }}</span>
            <br>
            <span>Ruc: {{ DB::table('empresas')->count() == 0 ? '- ' :  DB::table('empresas')->first()->ruc }}</span>
            <br>
            <span>Direccion:{{ DB::table('empresas')->count() == 0 ? '- ' : DB::table('empresas')->first()->direccion_fiscal }}</span>
            <br>
            <span>Correo: {{ DB::table('empresas')->count() == 0 ? '- ' : DB::table('empresas')->first()->correo }}</span>
            <br>
            <span>Telefono: {{ DB::table('empresas')->count() == 0 ? '- ' : DB::table('empresas')->first()->telefono }}</span>
        </div>
        <br>
        <div style="text-align: center; font-size: 10pt; margin-top: 10pt">
            <span>{{ $documento->nombreDocumento() }}</span>
            <br>
            <span>{{$documento->serie.'-'.$documento->correlativo}}</span>
        </div>
        <br>
        <div style="margin-top: 5pt">
            <span>Cliente: {{ $documento->clienteEntidad->nombre }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Dni-Cliente: {{ $documento->clienteEntidad->documento  }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Fecha Emision: {{ getFechaFormato( $documento->fecha_documento ,'d/m/Y') }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Estado: {{ $documento->estado }}</span>
        </div>
        <br>
        <div>
            <span>----------------------------------------------------------------</span>
        </div>
        <br>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left">Descripción</th>
                    <th style="text-align: left">Precio</th>
                    <th style="text-align: left">Cant</th>
                    <th style="text-align: left">SubTotal</th>

                </tr>
            </thead>
            <tbody class="cuerpoTabla">
                @foreach ($documento->detalles as $i => $item)
                   <tr>
                       <td style="text-align: center">{{ $item->nombre_producto }}</td>
                       <td style="text-align: center">{{ $item->precio_unitario }}</td>
                       <td style="text-align: center">{{ $item->cantidad }}</td>
                       <td style="text-align: center">{{ $item->valor_venta }}</td>
                   </tr>
               @endforeach
           </tbody>
            <tfoot>
                <tr>
                    <th style="text-align:center" colspan="3">Total</th>
                    <th style="text-align:center">{{ number_format($documento->total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
        <div>
            <span>----------------------------------------------------------------</span>
        </div>
        <div>
            
        </div>
        <br>
        <br><br>
        <br>
        <div style="margin-top: 5pt; text-align: center">
            <span>!!! documento IMPRESO !!!</span>
        </div>
        <br><br>
        <div style="text-align: center">
            <span>!!! GRACIAS POR SU CONFIANZA !!! </span>
        </div>
        <span style="position:absolute;top:90%;left:8%;">
            {{ (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
            "https" : "http") . "://" . $_SERVER['HTTP_HOST'].""}}
        </span>
    </div>


</body>

</html>
