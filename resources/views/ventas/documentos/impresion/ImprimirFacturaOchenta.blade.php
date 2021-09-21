<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido Nº {{ $pedido->id }}</title>
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
            <span>{{ DB::table('empresa')->count() == 0 ? 'EMPRESA RESTAURANT ' : DB::table('empresa')->first()->nombre }}</span>
            <br>
            <span>Ruc: {{ DB::table('empresa')->count() == 0 ? '- ' :  DB::table('empresa')->first()->ruc }}</span>
            <br>
            <span>Direccion:{{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->direccion }}</span>
            <br>
            <span>Correo: {{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->email }}</span>
            <br>
            <span>Telefono: {{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->telefono }}</span>
        </div>
        <br>
        <div style="text-align: center; font-size: 10pt; margin-top: 10pt">
            <span>BOLETA DE VENTA-ELECTRONICA</span>
            <br>
            <span>{{$pedido->tipoDocumento()->serie}}</span>
        </div>
        <br>
        <div style="margin-top: 5pt">
            Razon Social: {{  $detalle->razon_social }}
        </div>
        <div style="margin-top: 5pt">
            Ruc: {{ $detalle->ruc }}
        </div>
        <div class="direccion">
            Direccion: {{ $detalle->direccion }}
        </div>
        <div style="margin-top: 5pt">
            <span>Fecha Generada: {{ date('Y-m-d h:i') }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Estado: {{ $pedido->estado }}</span>
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
            {{$total=0}}
            <tbody>
                @foreach ($pedido->DPedido as $i => $item)
                   <tr>
                       <td style="text-align: center">{{ $item->Plato_Prod->nombre }}</td>
                       <td style="text-align: center">{{ number_format($item->p_venta, 2) }}</td>
                       <td style="text-align: center">{{ $item->cantidad }}</td>
                       <td style="text-align: center">{{ number_format($item->p_venta * $item->cantidad, 2) }}</td>
                       {{ $total = $total +$item->p_venta * $item->cantidad }}
                   </tr>
               @endforeach
           </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" hidden></th>
                    <th style="text-align:center">Subtotal</th>
                    <th style="text-align:center">{{ $total-($total*0.18) }}</th>
                </tr>
                <tr>
                    <th colspan="2" hidden></th>
                    <th style="text-align:center">Igv</th>
                    <th style="text-align:center">{{ $total*0.18 }}</th>
                </tr>
                <tr>
                    <th colspan="2" hidden></th>
                    <th style="text-align:center">Total A Pagar S/.</th>
                    <th style="text-align:center">{{ $total }}</th>
                </tr>
            </tfoot>
        </table>
        <div>
            <span>----------------------------------------------------------------</span>
        </div>
        <div>
            Pago:
            <br>
            <span>{{ DB::table('empresa')->count() == 0 ? 'Cuenta :-' : 'Cuenta: '.DB::table('empresa')->first()->cuenta }}</span>
            <br>
            <span>{{ DB::table('empresa')->count() == 0 ? 'CCI :-' : 'CCI: '.DB::table('empresa')->first()->cci }}</span>
        </div>
        <br>
        <br><br>
        <br>
        <div style="margin-top: 5pt; text-align: center">
            <span>!!! PEDIDO IMPRESO !!!</span>
        </div>
        <br><br>
        <div style="text-align: center">
            <span>{{ DB::table('empresa')->count() == 0 ? '!!! GRACIAS POR SU CONFIANZA !!! ' : DB::table('empresa')->first()->mensaje_reporte }}</span>
        </div>
        <span style="position:absolute;top:90%;left:5%;">
            {{ (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
            "https" : "http") . "://" . $_SERVER['HTTP_HOST']."/buscarDocumento"}}
        </span>
    </div>


</body>

</html>
