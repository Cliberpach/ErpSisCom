<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido Delivery</title>
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
            width: 200px;
            height: 40px;
        }

        .cuadroDerecha .title {

            margin-top: 5px !important;
            font-size: 15px;
            text-align: center;
        }
        .restaurant
        {
            position: absolute;
            font-size: 18px;
            text-transform: uppercase;
            left: 15%;

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
            top:8%;
            left: 48%;
        }

        .fecha {
            position: absolute;
            width: 200px;
            top: 8%;
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
            background-color: rgb(209, 206, 206);
        }
        .cuerpoTabla{
            border-top:1px solid;
            border-bottom:1px solid;
        }
    </style>
</head>

<body>
    <div style="width: 100%; margin-left: -9mm; margin-right: -9mm; margin-top: -5mm" class="tipo-letra">
        <br>
        <div class="restaurant">
            {{ DB::table('empresa')->count() == 0 ? 'EMPRESA RESTAURANT ' : DB::table('empresa')->first()->nombre }}
        </div>
        <div class="cuadroDerecha">
            <div class="ruc">R.U.C: {{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->ruc }}</div>

            <div class="title">TICKET
                <br>
                {{$pedido->tipoDocumento()->serie}}
            </div>
        </div>
        <br>
        <div style="font-size:14px;position:absolute;left: 15%;top:17px;">
            Direccion:{{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->direccion }}
            <br>
            Correo: {{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->email }}
            <br>
            Telefono: {{ DB::table('empresa')->count() == 0 ? '- ' : DB::table('empresa')->first()->telefono }}
        </div>
        <div class="nombre">
            Cliente: {{ $pedido->cliente->persona->nombres . ' ' . $pedido->cliente->persona->apellidos }}
        </div>
        <div class="dni">
            Dni: {{ $pedido->cliente->persona->dni }}
        </div>
        <div class="direccion">
            Direccion: {{ $pedido->cliente->persona->direccion }}
        </div>
        <div class="fecha">
            Fecha: {{ date('Y/m/d') }}</div>

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
            {{ $total = 0 }}
            <tbody class="cuerpoTabla">
                 @foreach ($pedido->DPedido as $i => $item)
                    <tr>
                        <td style="text-align: center">{{ $item->cantidad }}</td>
                        <td style="text-align: center">{{ $item->Plato_Prod->nombre }}</td>
                        <td style="text-align: center">{{ number_format($item->p_venta, 2) }}</td>
                        <td style="text-align: center">{{ number_format($item->p_venta * $item->cantidad, 2) }}</td>
                        {{ $total = $total +$item->p_venta * $item->cantidad }}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" hidden></th>
                    <th style="text-align:center">Total A Pagar S/.</th>
                    <th style="text-align:center">{{ $total }}</th>
                </tr>
            </tfoot>
        </table>
        Pago:
        <br>
        <span>{{ DB::table('empresa')->count() == 0 ? 'Cuenta :-' : 'Cuenta: '.DB::table('empresa')->first()->cuenta }}</span>
        <br>
        <span>{{ DB::table('empresa')->count() == 0 ? 'CCI :-' : 'CCI: '.DB::table('empresa')->first()->cci }}</span>
        <br>
        <br><br>

    </div>


</body>

</html>
