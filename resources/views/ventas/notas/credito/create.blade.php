@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documento-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVA NOTA DE CRÉDITO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documento.index')}}">Documentos</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nota de crédito</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    <form action="{{route('ventas.notas.store')}}" method="POST" id="enviar_documento">
                        {{csrf_field()}}
                        <input type="hidden" name="documento_id" value="{{old('documento_id', $documento->id)}}">
                        <input type="hidden" name="tipo_nota" value="{{ $documento->tipo_nota }}">
                        <div class="row">
                            <div class="col-12 col-md-5 b-r">
                                <div class="row">
                                    <div class="col-12">
                                        <p style="text-transform:uppercase"><strong><i class="fa fa-caret-right"></i> Información de nota de crédito</strong></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Tipo Nota de Crédito</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <select name="cod_motivo" id="cod_motivo" class="select2_form form-control">
                                            <option value=""></option>
                                            @foreach(cod_motivos() as $item)
                                                <option value="{{ $item->simbolo }}">{{ $item->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Motivo</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <textarea name="des_motivo" id="des_motivo" rows="2" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="row">
                                    <div class="col-12">
                                        <p style="text-transform:uppercase"><strong><i class="fa fa-caret-right"></i> Información de cliente</strong></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group row">
                                            <div class="col-12 col-md-5">
                                                <label class="required">Cliente ID</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" value="{{ $documento->clienteEntidad->id }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class=" form-group row">
                                            <div class="col-12 col-md-5">
                                                <label class="required">Tipo Doc. / Nro. Doc</label>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <input type="text" class="form-control" value="{{ $documento->clienteEntidad->tipo_documento }}" readonly>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" class="form-control" value="{{ $documento->clienteEntidad->documento }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-12 col-md-4">
                                                <label class="required">Nombre / Razón Social</label>
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <input type="text" class="form-control" name="cliente" id="cliente" value="{{ $documento->clienteEntidad->nombre }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-5">
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">{{ $documento->tipo_documento_cliente }}</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="documento_cliente" value="{{ $documento->tipo_documento_cliente }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Serie Nota</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="serie_nota" value="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Nro. Nota</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="numero_nota" value="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Emisión de Nota</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="date" class="form-control" name="fecha_emision" value="{{ $fecha_hoy }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Fecha Documento</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="date" class="form-control" name="fecha_documento" value="{{ $documento->fecha_documento }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Serie doc. afectado</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="serie_doc" value="{{ $documento->serie }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Nro. doc. afectado</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="numero_doc" value="{{ $documento->correlativo }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Tipo Pago</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control text-uppercase" name="tipo_pago" value="{{ $documento->formaPago() }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Sub Total</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="sub_total" value="{{ $documento->sub_total }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">IGV {{$documento->igv }}%</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="total_igv" value="{{ $documento->total_igv }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Total</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="total" value="{{ $documento->total }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-5">
                                        <label class="required">Nuevo Total</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" name="nuevo_total" value="{{ $documento->total }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="table-responsive">
                                    <table id="tbl-detalles" class="table tbl-detalles" style="width: 100%; text-transform:uppercase;">
                                        <thead>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>P. Unitario</th>
                                            <th>Total</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-md-6 text-left" style="color:#fcbc6c">
                                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                    (<label class="required"></label>) son obligatorios.</small>
                            </div>

                            <div class="col-md-6 text-right">

                                <a href="{{route('ventas.documento.index')}}" id="btn_cancelar"
                                    class="btn btn-w-m btn-default">
                                    <i class="fa fa-arrow-left"></i> Regresar
                                </a>
                                
                                <button type="submit" id="btn_grabar" class="btn btn-w-m btn-primary">
                                    <i class="fa fa-save"></i> Grabar
                                </button>
                            </div>

                        </div>

                    </form>

                </div>


            </div>
        </div>

    </div>

</div>
@include('ventas.documentos.modal')
@include('ventas.documentos.modalLote')

@stop
@push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

@endpush

@push('scripts')
<!-- Data picker -->
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<!-- Date range picker -->
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>

    $(document).ready(function() {

        $(".select2_form").select2({
            placeholder: "SELECCIONAR",
            allowClear: true,
            height: '200px',
            width: '100%',
        });

        actualizarData('{{ $documento->id }}')
        viewData();
    });

    function actualizarData(id) {
        let url = '{{ route("ventas.getDetalles",":id") }}';
        url = url.replace(':id',id);
        $('#tbl-detalles').dataTable().fnDestroy();
        $('#tbl-detalles').DataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": url,
            "columns": [
                { data: 'cantidad', className: 'cantidad' },
                { data: 'descripcion', className: 'descripcion' },
                { data: 'precio_nuevo', className: 'precio_nuevo' },
                { data: 'total_venta', className: 'total_venta' },
                {
                    defaultContent: '<div class="btn-group">' +
                        '<button id="editar" type="button" class="btn btn-sm btn-primary">' +
                        '<span class="glyphicon glyphicon-pencil" > </span>' +
                        '</button>' +
                        '<button id="eliminar" type="button" class="btn btn-sm btn-danger">' +
                        '<span class="glyphicon glyphicon-trash" > </span>' +
                        '</button>' +
                        '<button id="aceptar" type="button" class="btn btn-sm btn-success" style="display:none;">' +
                        '<span class="glyphicon glyphicon-ok" > </span>' +
                        '</button>' +
                        '<button id="cancelar" type="button" class="btn btn-sm btn-warning" style="display:none;">' +
                        '<span class="glyphicon glyphicon-remove" > </span>' +
                        '</button>' +
                        '</div>',
                    className: 'text-right',
                },
            ],
            "language": {
                "url": "/Spanish.json"
            },
            "order": [
                [1, 'asc']
            ],
        });
    }

    function viewData() {
    $("#tbl-detalles").on('click', '#editar', function() {

        //var data = $("#propuestas").dataTable().fnGetData($(this).closest('tr'));

        $(this).parents("tr").find(".cantidad").each(function() {
            var cont = $(this).html();
            var input = '<input type="text" class="form-control" value="' + cont + '" onkepress="return isNumber(this)"/>';
            $(this).html(input);
        });

        $(this).parents("tr").find(".precio_nuevo").each(function() {
            var cont = $(this).html();
            var input = '<input type="text" class="form-control" value="' + cont + '" onkepress="return isNumber(this)"/>';
            $(this).html(input);
        });

        $(this).parent().find("#editar").hide();
        $(this).parent().find("#eliminar").hide();
        $(this).parent().find("#aceptar").show();
        $(this).parent().find("#cancelar").show();
    });
}

</script>
@endpush