@extends('layout') @section('content')

@section('consulta-active', 'active')
@section('consulta-ventas-active', 'active')
@section('consulta-ventas-documento-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 col-md-12">
       <h2  style="text-transform:uppercase"><b>Listado de Documentos de Venta</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Documentos de Ventas</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-12">
            <div class="row align-items-end">
                <div class="col-12 col-md-5">
                    <div class="form-group">
                        <label for="fecha_desde">Fecha desde</label>
                        <input type="date" id="fecha_desde" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="form-group">
                        <label for="fecha_desde">Fecha hasta</label>
                        <input type="date" id="fecha_hasta" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" onclick="initTable()"><i class="fa fa-refresh"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-orden table-striped table-bordered table-hover"
                        style="text-transform:uppercase">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 20%">CLIENTE</th>
                                    <th class="text-center" style="width: 20%">TIPO</th>
                                    <th class="text-center" style="width: 10%"># DOC</th>
                                    <th class="text-center" style="width: 10%">FECHA</th>
                                    <th class="text-center" style="width: 5%">MONTO</th>
                                    <th class="text-center" style="width: 10%">MODO</th>
                                    <th class="text-center" style="width: 5%">EFECT.</th>
                                    <th class="text-center" style="width: 5%">TRANSF.</th>
                                    <th class="text-center" style="width: 5%">YAPE/PLIN</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"  class="text-right">EFECTIVO</td>
                                    <td colspan="4" class="text-right" id="efectivo"></td>
                                </tr>
                                <tr>
                                    <td colspan="5"  class="text-right">TRANSFERENCIA</td>                                    
                                    <td colspan="4" class="text-right" id="transferencia"></td>
                                </tr>
                                <tr>
                                    <td colspan="5"  class="text-right">YAPE/PLIN</td>      
                                    <td colspan="4" class="text-right" id="yape_plin"></td>
                                </tr>
                                <tr>
                                    <td colspan="5"  class="text-right">TOTAL</td>      
                                    <td colspan="4" class="text-right" id="total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<style>
    .letrapequeña {
        font-size: 11px;
    }

</style>
@endpush

@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>
$(document).ready(function() {
    var ventas = [];
    // DataTables
    initTable();

    tablaDatos = $('.dataTables-enviados').DataTable();

});

function initTable()
{
    let verificar = true;
    var fecha_desde = $('#fecha_desde').val();
    var fecha_hasta = $('#fecha_hasta').val();
    if (fecha_desde !== '' && fecha_desde !== null && fecha_hasta == '') {
        verificar = false;
        toastr.error('Ingresar fecha hasta');
    }

    if (fecha_hasta !== '' && fecha_hasta !== null && fecha_desde == '') {
        verificar = false;
        toastr.error('Ingresar fecha desde');
    }

    if (fecha_desde > fecha_hasta && fecha_hasta !== '' && fecha_desde !== '') {
        verificar = false;
        toastr.error('Fecha desde debe ser menor que fecha hasta');
    }

    if(verificar)
    {
        let timerInterval;
        Swal.fire({
            title: 'Cargando...',
            icon: 'info',
            customClass: {
                container: 'my-swal'
            },
            timer: 10,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                Swal.stopTimer();
                $.ajax({
                    dataType : 'json',
                    type : 'post',
                    url : '{{ route('consultas.ventas.documento.getTable') }}',
                    data : {'_token' : $('input[name=_token]').val(), 'fecha_desde' : fecha_desde, 'fecha_hasta' : fecha_hasta},
                    success: function(response) {
                        if (response.success) {
                            ventas = [];
                            ventas = response.ventas;
                            $('#efectivo').html('S/. ' + response.efectivo.toFixed(2));
                            $('#transferencia').html('S/. ' + response.transferencia.toFixed(2));
                            $('#yape_plin').html('S/. ' + response.yape_plin.toFixed(2));
                            $('#total').html('S/. ' + response.total.toFixed(2));
                            loadTable();
                            timerInterval = 0;
                            Swal.resumeTimer();
                            //console.log(colaboradores);
                        } else {
                            Swal.resumeTimer();
                            ventas = [];
                            loadTable();
                        }
                    }
                });
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        });
    }

    /*$.ajax({
        dataType : 'json',
        type : 'post',
        url : '{{ route('consultas.ventas.documento.getTable') }}',
        data : {'_token' : $('input[name=_token]').val(), 'fecha_desde' : fecha_desde, 'fecha_hasta' : fecha_hasta}
    }).done(function (result){
        if (result.success) {
            ventas = [];
            ventas = result.ventas;
            loadTable();
        }
        else
        {
            ventas = []
            loadTable();
        }
    });*/
    return false;
}

function loadTable()
{
    $('.dataTables-orden').dataTable().fnDestroy();
    $('.dataTables-orden').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'CONSULTA DOCUMENTO VENTA'
            },
            {
                titleAttr: 'Imprimir',
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "data": ventas,
        "columns": [ 
            
            {data: 'cliente', name:'cliente', className: "letrapequeña"},
            {data: 'tipo_venta', name:'tipo_venta', className: "letrapequeña"},
            {data: 'numero_doc',name:'numero_doc', className: "letrapequeña"},
            {data: 'fecha_documento',name:'fecha_documento', className: "letrapequeña"},
            {data: 'total',name:'total', className: "letrapequeña"},
            {data: 'forma_pago',name:'forma_pago', className: "letrapequeña"},
            {data: 'efectivo',name:'efectivo', className: "letrapequeña"},
            {data: 'transferencia',name:'transferencia', className: "letrapequeña"},
            {data: 'otros',name:'otros', className: "letrapequeña"},
        ],
        "language": {
                    "url": "{{asset('Spanish.json')}}"
        },
        "order": [[ 0, "desc" ]],
        

    });
    return false;
}
</script>
@endpush