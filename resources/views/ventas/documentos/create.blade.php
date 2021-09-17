@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documento-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO DOCUMENTO DE VENTA</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documento.index')}}">Documentos de Venta</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registrar</strong>
            </li>

        </ol>
    </div>



</div>


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    <input type="hidden" id='asegurarCierre' >
                    <form action="{{route('ventas.documento.store')}}" method="POST" id="enviar_documento">
                        {{csrf_field()}}

                        @if (!empty($cotizacion))
                            <input type="hidden" name="cotizacion_id" value="{{$cotizacion->id}}" >
                        @endif
                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <h4 class=""><b>Documento de venta</b></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Registrar datos del documento de venta:</p>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-lg-6 col-xs-12" id="fecha_documento">
                                        <label class="">Fecha de Documento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            @if (!empty($cotizacion))
                                            <input type="text" id="fecha_documento_campo" name="fecha_documento"
                                                class="form-control {{ $errors->has('fecha_documento') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_documento',getFechaFormato($cotizacion->fecha_documento, 'd/m/Y'))}}"
                                                autocomplete="off" required readonly disabled >
                                            @else
                                            <input type="text" id="fecha_documento_campo" name="fecha_documento"
                                                class="form-control {{ $errors->has('fecha_documento') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_documento',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
                                                autocomplete="off" required readonly disabled>
                                            @endif

                                            @if ($errors->has('fecha_documento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_documento') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xs-12" id="fecha_entrega">
                                        <label class="">Fecha de Atención</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            
                                            @if (!empty($cotizacion))
                                            <input type="text" id="fecha_atencion_campo" name="fecha_atencion_campo"
                                                class="form-control {{ $errors->has('fecha_atencion') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_atencion',getFechaFormato( $cotizacion->fecha_atencion ,'d/m/Y'))}}"
                                                autocomplete="off" readonly disabled>
                                            @else

                                            <input type="text" id="fecha_atencion_campo" name="fecha_atencion_campo"
                                                class="form-control {{ $errors->has('fecha_atencion') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_atencion',getFechaFormato( $fecha_hoy ,'d/m/Y'))}}"
                                                autocomplete="off" required readonly disabled>

                                            @endif

                                            @if ($errors->has('fecha_atencion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_atencion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Tipo: </label>
                                        <select
                                            class="select2_form form-control {{ $errors->has('tipo_venta') ? ' is-invalid' : '' }}"
                                            style="text-transform: uppercase; width:100%" value="{{old('tipo_venta')}}"
                                            name="tipo_venta" id="tipo_venta" required  @if (!empty($cotizacion)) '' @else onchange="consultarSeguntipo()" @endif >
                                            <option></option>
                                            
                                                @foreach (tipos_venta() as $tipo)
                                                    @if( $tipo->tipo == 'VENTA' || $tipo->tipo == 'AMBOS' )
                                                        <option value="{{$tipo->id}}" @if(old('tipo_venta')==$tipo->nombre ) {{'selected'}} @endif >{{$tipo->nombre}}</option>
                                                    @endif
                                                @endforeach

                                                @if ($errors->has('tipo_venta'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tipo_venta') }}</strong>
                                                </span>
                                                @endif
                                            


                                        </select>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <label >Moneda:</label>
                                        <select id="moneda" name="moneda" class="select2_form form-control {{ $errors->has('moneda') ? ' is-invalid' : '' }}" disabled >
                                            <option selected>SOLES</option>
                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label class="required">Empresa: </label>

                                        @if (!empty($cotizacion))
                                            <select
                                            class="select2_form form-control {{ $errors->has('empresa_id') ? ' is-invalid' : '' }}"
                                            style="text-transform: uppercase; width:100%" value="{{old('empresa_id',$cotizacion->empresa_id)}}"
                                            name="empresa_id" id="empresa_id" disabled>
                                            <option></option>
                                            @foreach ($empresas as $empresa)
                                            <option value="{{$empresa->id}}" @if(old('empresa_id',$cotizacion->empresa_id)==$empresa->id )
                                                {{'selected'}} @endif >{{$empresa->razon_social}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                            <select class="select2_form form-control {{ $errors->has('empresa_id') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('empresa_id')}}"
                                            name="empresa_id" id="empresa_id" required onchange="obtenerTiposComprobantes(this)" disabled >
                                            <option></option>
                                            @foreach ($empresas as $empresa)
                                            <option value="{{$empresa->id}}" @if(old('empresa_id')==$empresa->id )
                                                {{'selected'}} @endif >{{$empresa->razon_social}}</option>
                                            @endforeach
                                            </select>
                                        @endif


                                    
                                </div>


                                <div class="form-group">
                                    <label class="required">Cliente: </label>
                                    <input type="hidden" name="tipo_cliente_documento" id="tipo_cliente_documento">
                                    <input type="hidden" name="tipo_cliente_2" id="tipo_cliente_2" value='1'>
                                    @if (!empty($cotizacion))
                                    <select
                                    class="select2_form form-control {{ $errors->has('cliente_id') ? ' is-invalid' : '' }}"
                                    style="text-transform: uppercase; width:100%" value="{{old('cliente_id', $cotizacion->cliente_id)}}"
                                    name="cliente_id" id="cliente_id"   disabled >
                                        <option></option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}" @if(old('cliente_id',$cotizacion->cliente_id)==$cliente->id )
                                            {{'selected'}} @endif >{{ $cliente->getDocumento() }} - {{ $cliente->nombre }}</option>
                                        @endforeach
                                        </select>
                                    @else
                                        <select class="select2_form form-control {{ $errors->has('proveedor_id') ? ' is-invalid' : '' }}"
                                        style="text-transform: uppercase; width:100%" value="{{old('cliente_id')}}"
                                        name="cliente_id" id="cliente_id" required disabled onchange="obtenerTipocliente(this.value)" >
                                        <option></option>
                                        </select>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Observación:</label>
                               
                                    <textarea type="text" placeholder=""
                                        class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                        name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                        value="{{old('observacion')}}">{{old('observacion')}}</textarea>
                                

                                    @if ($errors->has('observacion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observacion') }}</strong>
                                    </span>
                                    @endif


                                </div>


                                <!-- OBTENER TIPO DE CLIENTE -->
                                <input type="hidden" class="form-control" name="" id="tipo_cliente">
                                <!-- OBTENER DATOS DEL PRODUCTO -->
                                <input type="hidden" class="form-control" name="" id="presentacion_producto">
                                <input type="hidden" class="form-control" name="" id="codigo_nombre_producto">
                                <!-- LLENAR DATOS EN UN ARRAY -->
                                <input type="hidden" class="form-control" id="productos_tabla" name="productos_tabla[]">
                                <!-- TIPO PAGO -->
                                <input type="hidden" class="form-control" name="tipo_pago_id" id="tipo_pago_id">
                                <!-- EFECTIVO -->
                                <input type="hidden" class="form-control" name="efectivo" id="efectivo_form">
                                <!-- IMPORTE -->
                                <input type="hidden" class="form-control" name="importe" id="importe_form">

                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle del Documento de Venta</b></h4>
                                    </div>
                                    <div class="panel-body">

                                    @if (empty($cotizacion))
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12">
                                                <label class="col-form-label required">Producto:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="producto_lote" readonly> 
                                                    <span class="input-group-append"> 
                                                        <button type="button" class="btn btn-primary" disabled id="buscarLotes" data-toggle="modal" data-target="#modal_lote"><i class='fa fa-search'></i> Buscar
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="invalid-feedback"><b><span id="error-producto"></span></b>
                                                </div>
                                            </div>

                                            <input type="hidden" name="producto_id" id="producto_id">
                                            <input type="hidden" name="producto_unidad" id="producto_unidad">

                                            <div class="col-lg-2 col-xs-12">

                                                <label class="col-form-label required">Cantidad:</label>
                                                <input type="number" value='0.00' id="cantidad" class="form-control" disabled>
                                                <div class="invalid-feedback"><b><span id="error-cantidad"></span></b>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-form-label required" for="amount">Precio:</label>
                                                    <input type="number" id="precio" class="form-control" disabled >
                                                    <div class="invalid-feedback"><b><span id="error-precio"></span></b>
                                                    </div>
                                                </div>
                                            </div>
                                            


                                            <div class="col-lg-2 col-xs-12">

                                                <div class="form-group">
                                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                                    <button type=button class="btn btn-block btn-warning" style='color:white;' id="btn_agregar_detalle" disabled> <i class="fa fa-plus"></i> AGREGAR</button>
                                                </div>

                                            </div>



                                        </div>
                                        <hr>
                                    @endif


                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-detalle-documento table-striped table-bordered table-hover"
                                                style="text-transform:uppercase">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">CANTIDAD</th>
                                                        <th class="text-center">UNIDAD DE MEDIDA</th>
                                                        <th class="text-center">DESCRIPCION DEL PRODUCTO</th>
                                                        <th class="text-center">PRECIO</th>
                                                        <th class="text-center">TOTAL</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" style="text-align:right">Sub Total:</th>
                                                        <th><span id="subtotal">@if (!empty($cotizacion)) {{$cotizacion->sub_total}} @else 0.0 @endif</span></th>

                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-center">IGV <span
                                                                id="igv_int"></span>:</th>
                                                        <th class="text-center"><span id="igv_monto">@if (!empty($cotizacion)) {{$cotizacion->total_igv}} @else 0.0 @endif</span></th>

                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" class="text-center">TOTAL:</th>
                                                        <th class="text-center"><span id="total">@if (!empty($cotizacion)) {{$cotizacion->total}} @else 0.0 @endif</span></th>

                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="monto_sub_total" id="monto_sub_total" value="{{ old('monto_sub_total') }}">
                        <input type="hidden" name="monto_total_igv" id="monto_total_igv" value="{{ old('monto_total_igv') }}">
                        <input type="hidden" name="monto_total" id="monto_total" value="{{ old('monto_total') }}">

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
                                @if(empty($errores))
                                    <button type="button" id="btn_grabar" class="btn btn-w-m btn-primary">
                                        <i class="fa fa-save"></i> Grabar
                                    </button>
                                @else
                                    @if ( count($errores) == 0)
                                    <button type="button" id="btn_grabar" class="btn btn-w-m btn-primary">
                                        <i class="fa fa-save"></i> Grabar
                                    </button>
                                    @endif
                                @endif
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
@include('ventas.documentos.modalPago')
@stop

@push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

<style>
    .my-swal {
        z-index: 3000 !important;
    }
</style>

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

        $('#cantidad').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            let max= parseInt(this.max);
            let valor = parseInt(this.value);
            if(valor>max){
                toastr.error('La cantidad ingresada supera al stock del producto Max('+max+').', 'Error');
                this.value = max;
            }
        });

        //Editar Registro
        $(document).on('click', '.btn-edit', function(event) {
            var table = $('.dataTables-detalle-documento').DataTable();
            var data = table.row($(this).parents('tr')).data();
            let indice = table.row($(this).parents('tr')).index();
            $.ajax({
                type : 'POST',
                url : '{{ route('ventas.documento.obtener.lote') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'lote_id' : data[0],
                }
            }).done(function (response){
                if(response.success)
                {
                    $('#indice').val(indice);
                    $('#producto_lote_editar').val(data[4]);
                    $('#producto_editar').val(data[0]);
                    $('#precio_editar').val(data[5]);
                    $('#presentacion_producto_editar').val(data[3]);
                    $('#codigo_nombre_producto_editar').val(data[4]);
                    $('#cantidad_editar').val(data[2]);
                    $('#cantidad_editar_actual').val(data[2]);
                    $('#medida_editar').val(data[7]);
                    $('#modal_editar_detalle').modal('show');

                    let suma_cant = parseFloat(response.lote.cantidad_logica) + parseFloat(data[2]);
                    //AGREGAR LIMITE A LA CANTIDAD SEGUN EL LOTE SELECCIONADO
                    $("#cantidad_editar").attr({
                        "max" : suma_cant,
                        "min" : 1,
                    });
                }
                else{
                    toastr.warning('Ocurrió un error porfavor recargar la pagina.')
                } 
            });

        })


        function obtenerMax(id) {
            $.get('/almacenes/productos/obtenerProducto/'+ id, function (data) {
                //AGREGAR LIMITE A LA CANTIDAD
                $("#cantidad_editar").attr({ 
                    "max" : data.producto.stock,
                    "min" : 1,
                });
            })
        }


        //Borrar registro de Producto
        $(document).on('click', '.btn-delete', function(event) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false
            })

            Swal.fire({
                title: 'Opción Eliminar',
                text: "¿Seguro que desea eliminar Producto?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    var table = $('.dataTables-detalle-documento').DataTable();
                    var data = table.row($(this).parents('tr')).data();
                    var detalle = {
                        producto_id: data[0],
                        cantidad: data[2],
                    }
                    //DEVOLVER LA CANTIDAD LOGICA
                    cambiarCantidad(detalle,'0')
                    table.row($(this).parents('tr')).remove().draw();
                    sumaTotal()

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'La Solicitud se ha cancelado.',
                        'error'
                    )
                }
            })
        });

        $(document).ready(function() {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                width: '100%',
            });

            $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                language: 'es',
                format: "dd/mm/yyyy"
            });
        });

        function obtenerProducto(id) {
            // Consultamos nuestra BBDD
            var url = '{{ route("almacenes.producto.productoDescripcion", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                dataType : 'json',
                type : 'get',
                url : url,
            }).done(function (result){

                $('#presentacion_producto').val(result.medida)
                $('#codigo_nombre_producto').val(result.codigo+' - '+result.nombre)
                llegarDatos()
                sumaTotal()
                limpiarDetalle()
            });
        }

        $(document).ready(function() {

            //DATATABLE - COTIZACION
            table = $('.dataTables-detalle-documento').DataTable({
                "dom": 'lTfgitp',
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        searchable: false,
                        "targets": [1],
                        data: null,

                        render: function(data, type, row) {
                            @if (!empty($cotizacion))
                                return "-";
                            @else
                                return  "<div class='btn-group'>" +
                                        "<a class='btn btn-sm btn-warning btn-edit' style='color:white'>"+ "<i class='fa fa-pencil'></i>"+"</a>" +
                                        "<a class='btn btn-sm btn-danger btn-delete' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+ 
                                        "</div>";
                            @endif
                        }
                        
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                    },
                    {
                        "targets": [4],
                    },
                    {
                        "targets": [5],
                    },
                    {
                        "targets": [6],
                    },
                    {
                        "targets": [7],
                        "visible": false,
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '25%', sClass: 'text-left' },
                    { sWidth: '15%', sClass: 'text-center' },
                    { sWidth: '15%', sClass: 'text-center' },
                ],
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });

            @if (!empty($cotizacion))

            @if ($cotizacion->igv_check == '1') 

                $('#igv').prop('disabled', false)
                $("#igv_check").prop('checked',true)

                $('#igv_requerido').addClass("required")
                $('#igv').prop('required', true)
                var igv = ($('#igv').val()) + ' %'
                $('#igv_int').text(igv)
                // sumaTotal()
            @else
                if ($("#igv_check").prop('checked')) {
                    $('#igv').attr('disabled', false)
                    $('#igv_requerido').addClass("required")
                } else {
                    $('#igv').attr('disabled', true)
                    $('#igv_requerido').removeClass("required")
                }
            @endif

            @if ($lotes) 
                obtenerTabla()
                // sumaTotal()
            @endif

            @endif


            //Controlar Error
            $.fn.DataTable.ext.errMode = 'throw';
        });

        function limpiarErrores() {
            $('#cantidad').removeClass("is-invalid")
            $('#error-cantidad').text('')

            $('#precio').removeClass("is-invalid")
            $('#error-precio').text('')

            $('#producto').removeClass("is-invalid")
            $('#error-producto').text('')
        }

        //Validacion al ingresar tablas
        $("#btn_agregar_detalle").click(function() {
            limpiarErrores()
            var enviar = false;
            if ($('#producto_id').val() == '') {
                toastr.error('Seleccione Producto.', 'Error');
                enviar = true;
                $('#producto_id').addClass("is-invalid")
                $('#error-producto').text('El campo Producto es obligatorio.')
            } else {
                var existe = buscarProducto($('#producto_id').val())
                if (existe == true) {
                    toastr.error('Producto ya se encuentra ingresado.', 'Error');
                    enviar = true;
                }
            }

            if ($('#precio').val() == '') {
                toastr.error('Ingrese el precio del producto.', 'Error');
                enviar = true;
                $("#precio").addClass("is-invalid");
                $('#error-precio').text('El campo Precio es obligatorio.')
            }else{
                if ($('#precio').val() == 0) {
                    toastr.error('Ingrese el precio del producto superior a 0.0.', 'Error');
                    enviar = true;
                    $("#precio").addClass("is-invalid");
                    $('#error-precio').text('El campo precio debe ser mayor a 0.')
                }
            }

            if ($('#cantidad').val() == '') {
                toastr.error('Ingrese cantidad del artículo.', 'Error');
                enviar = true;
                $("#cantidad").addClass("is-invalid");
                $('#error-cantidad').text('El campo Cantidad es obligatorio.')
            }

            if ($('#cantidad').val() == 0) {
                toastr.error('El stock del producto es 0.', 'Error');
                enviar = true;
                $("#cantidad").addClass("is-invalid");
                $('#error-cantidad').text('El campo cantidad debe ser mayor a 0.')
            }

            if (enviar != true) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })

               
                Swal.fire({
                    title: 'Opción Agregar',
                    text: "¿Seguro que desea agregar Producto?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        llegarDatos()
                        $('#asegurarCierre').val(1)
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })

            }



        })

        function buscarProducto(id) {
            var existe = false;
            var t = $('.dataTables-detalle-documento').DataTable();
            t.rows().data().each(function(el, index) {
                if (el[0] == id) {
                    existe = true
                }
            });
            return existe
        }

        function llegarDatos() {
            var detalle = {
                producto_id: $('#producto_id').val(),
                presentacion: $('#producto_unidad').val(),
                producto: $('#producto_lote').val(),
                precio: $('#precio').val(),
                cantidad: $('#cantidad').val(),
            }
            agregarTabla(detalle);
            cambiarCantidad(detalle,'1');
        }

        //AGREGAR EL DETALLE A LA TABLA
        function agregarTabla($detalle) {
            var t = $('.dataTables-detalle-documento').DataTable();
            t.row.add([
                $detalle.producto_id,
                '',
                Number($detalle.cantidad),
                $detalle.presentacion,
                $detalle.producto,
                Number($detalle.precio).toFixed(2),
                ($detalle.cantidad * $detalle.precio).toFixed(2),
                $detalle.presentacion
            ]).draw(false);
            cargarProductos()
            //INGRESADO EL PRODUCTO SUMA TOTAL DEL DETALLE
            sumaTotal()
            //LIMPIAR LOS CAMPOS DESPUES DE LA BUSQUEDA
            $('#precio').val('')
            $('#cantidad').val('')
            $('#producto_unidad').val('')
            $('#producto_id').val('')
            $('#producto_lote').val('')
        }
        //CARGAR EL DETALLE A UNA VARIABLE
        function cargarProductos() {
            var productos = [];
            var table = $('.dataTables-detalle-documento').DataTable();
            var data = table.rows().data();
            data.each(function(value, index) {
                let fila = {
                    producto_id: value[0],
                    presentacion: value[3],
                    precio: value[5],
                    cantidad: value[2],
                    total: value[6],
                };
                productos.push(fila);
            });

            $('#productos_tabla').val(JSON.stringify(productos));
        }
        //CAMBIAR LA CANTIDAD LOGICA DEL PRODUCTO
        function cambiarCantidad(detalle, condicion) {
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('ventas.documento.cantidad') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'producto_id' : detalle.producto_id,
                    'cantidad' : detalle.cantidad,
                    'condicion' : condicion,
                }
            }).done(function (result){
                alert('REVISAR')
            });
        }
        //DEVOLVER CANTIDADES A LOS LOTES
        function devolverCantidades() {
            //CARGAR PRODUCTOS PARA DEVOLVER LOTE
            cargarProductos() 
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('ventas.documento.devolver.cantidades') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'cantidades' :  $('#productos_tabla').val(),
                }
            }).done(function (result){
                alert('DEVOLUCION REALIZADA')
            });
        }

        function sumaTotal() {
            var t = $('.dataTables-detalle-documento').DataTable();
            var subtotal = 0;
            t.rows().data().each(function(el, index) {
                subtotal = Number(el[6]) + subtotal
            });

            @if (!empty($cotizacion))
                @if ($cotizacion->igv_check == '1')
                    table.rows().data().each(function(el, index) {
                        var dinero;
                        var precionuevo;
                        var pdescuento = 0;
                        var precio = el[5];
                        dinero = precio * (convertFloat('{{ $cotizacion->igv }}')/100),
                        precionuevo = precio - dinero;
                        table.cell({
                            row: index,
                            column: 5
                        }).data(precionuevo.toFixed(2));
                        table.cell({
                            row: index,
                            column: 6
                        }).data((precionuevo.toFixed(2) * el[2]).toFixed(2));
                    });
                    //conIgv(subtotal)
                    let igv_back = convertFloat('{{ $cotizacion->igv }}');
                    let calcularIgv = igv_back / 100;
                    let igv =  subtotal * calcularIgv;
                    let total = subtotal - igv
                    $('#igv_int').text(igv_back+'%')
                    $('#subtotal').text(total.toFixed(2))
                    $('#igv_monto').text(igv.toFixed(2))
                    $('#total').text(subtotal.toFixed(2))
                @else
                    sinIgv(subtotal)
                @endif
            @else
                conIgv(subtotal)
            @endif

        }

        function sinIgv(subtotal) {
            var calcularIgv = 18 / 100
            var base = subtotal / (1 + calcularIgv)
            //var nuevo_igv = subtotal - base;
            var nuevo_igv = 0;
            //$('#igv_int').text(18+'%')
            $('#igv_int').text(0+'%')
            $('#subtotal').text(subtotal.toFixed(2))
            $('#igv_monto').text(nuevo_igv.toFixed(2))
            $('#total').text(subtotal.toFixed(2))
        }

        function conIgv(subtotal) {
            let igv =  subtotal * 0.18
            let total = subtotal - igv
            $('#igv_int').text('18%')
            $('#subtotal').text(total.toFixed(2))
            $('#igv_monto').text(igv.toFixed(2))
            $('#total').text(subtotal.toFixed(2))

        }

        function registrosProductos() {
            var table = $('.dataTables-detalle-documento').DataTable();
            var registros = table.rows().data().length;
            return registros
        }

        function validarFecha() {
            var enviar = false
            var productos = registrosProductos()
            if ($('#fecha_documento_campo').val() == '') {
                toastr.error('Ingrese Fecha de Documento.', 'Error');
                $("#fecha_documento_campo").focus();
                enviar = true;
            }

            if ($('#fecha_atencion_campo').val() == '') {
                toastr.error('Ingrese Fecha de Atención.', 'Error');
                $("#fecha_atencion_campo").focus();
                enviar = true;
            }

            if (productos == 0) {
                toastr.error('Ingrese al menos 1 Producto.', 'Error');
                enviar = true;
            }
            return enviar
        }

        function validarTipo() {

            var enviar = false

            if ($('#tipo_cliente_documento').val() == '0' &&  $('#tipo_venta').val() == 'FACTURA' ) {
                toastr.error('El tipo de documento del cliente es diferente a RUC.', 'Error');
                enviar = true;
            }
            return enviar

        }

        /*$('#enviar_documento').submit(function(e) {
            e.preventDefault();
            var correcto = validarFecha()

            if (correcto == false) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })

                Swal.fire({
                    title: 'Opción Guardar',
                    text: "¿Seguro que desea guardar cambios?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var tipo = validarTipo()

                        if (tipo == false) {
                            cargarProductos();
                            //CARGAR DATOS TOTAL
                            $('#monto_sub_total').val($('#subtotal').text())
                            $('#monto_total_igv').val($('#igv_monto').text())
                            $('#monto_total').val($('#total').text())

                            document.getElementById("moneda").disabled = false;
                            document.getElementById("observacion").disabled = false;
                            document.getElementById("fecha_documento_campo").disabled = false;
                            document.getElementById("fecha_atencion_campo").disabled = false;
                            document.getElementById("empresa_id").disabled = false;
                            document.getElementById("cliente_id").disabled = false;
                            //HABILITAR EL CARGAR PAGINA
                            $('#asegurarCierre').val(2)
                            this.submit();
                        }

                        
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            }

        })*/

        $('#btn_grabar').click(function(e) {
            e.preventDefault();
            cargarProductos();
            let correcto = validarCampos();

            $('#monto_sub_total').val($('#subtotal').text())
            $('#monto_total_igv').val($('#igv_monto').text())
            $('#monto_total').val($('#total').text())

            if (correcto) {
                let total = $('#monto_total').val();
                $('#monto_venta').val(total);
                $('#importe_venta').val(total);
                $('#modal_pago').modal('show');
                $('#modo_pago').val('1-EFECTIVO').trigger('change.select2');
            }
        });

        $('#btn_grabar_pago').click(function(e) {
            e.preventDefault();
            let monto = convertFloat($('#monto_venta').val());
            let importe = convertFloat($('#importe_venta').val());
            let efectivo = convertFloat($('#efectivo_venta').val());
            let suma = importe + efectivo;
            
            $('#importe_form').val(importe);
            $('#efectivo_form').val(efectivo);

            let correcto = validarCampos();

            if($('#monto_venta').val() == null || $('#monto_venta').val() == '')
            {
                correcto = false;
                toastr.error('El campo monto es requerido.');
            }

            if($('#importe_venta').val() == null || $('#importe_venta').val() == '')
            {
                correcto = false;
                toastr.error('El campo monto es requerido.');
            }

            if($('#efectivo_venta').val() == null || $('#efectivo_venta').val() == '')
            {
                correcto = false;
                toastr.error('El campo efectivo es requerido.');
            }

            if(monto.toFixed(2) != suma.toFixed(2))
            {
                correcto = false;
                toastr.error('La suma del importe y el efectivo debe ser igual al monto de la venta.');
            }
            
            if (correcto) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })

                Swal.fire({
                    title: 'Opción Guardar',
                    text: "¿Seguro que desea guardar cambios?",
                    icon: 'question',
                    customClass: {
                        container: 'my-swal'
                    },
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var tipo = validarTipo()

                        if (tipo == false) {
                            cargarProductos();
                            //CARGAR DATOS TOTAL
                            $('#monto_sub_total').val($('#subtotal').text())
                            $('#monto_total_igv').val($('#igv_monto').text())
                            $('#monto_total').val($('#total').text())

                            document.getElementById("moneda").disabled = false;
                            document.getElementById("observacion").disabled = false;
                            document.getElementById("fecha_documento_campo").disabled = false;
                            document.getElementById("fecha_atencion_campo").disabled = false;
                            document.getElementById("empresa_id").disabled = false;
                            document.getElementById("cliente_id").disabled = false;
                            //HABILITAR EL CARGAR PAGINA
                            $('#asegurarCierre').val(2)
                            $('#enviar_documento').submit();
                        }

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            }
        });

        function validarCampos(){
            let correcto = true;
            let moneda = $('#moneda').val();
            let observacion = $('#observacion').val();
            let fecha_documento_campo = $('#fecha_documento_campo').val();
            let fecha_atencion_campo = $('#fecha_atencion_campo').val();
            let empresa_id = $('#empresa_id').val();
            let cliente_id = $('#cliente_id').val();
            let tipo_venta = $('#tipo_venta').val();

            
            let detalles = $('#productos_tabla').val();
            let detalles_convertido = JSON.parse(detalles);
            if(detalles_convertido.length < 1)
            {
                correcto = false;
                toastr.error('El documento de venta debe tener almenos un producto vendido.');
            }
            if(moneda == null || moneda == '')
            {
                correcto = false;
                toastr.error('El campo moneda es requerido.');
            }
            if(fecha_documento_campo == null || fecha_documento_campo == '')
            {
                correcto = false;
                toastr.error('El campo fecha de documento es requerido.');
            }
            if(fecha_atencion_campo == null || fecha_atencion_campo == '')
            {
                correcto = false;
                toastr.error('El campo fecha de atención es requerido.');
            }
            if(empresa_id == null || empresa_id == '')
            {
                correcto = false;
                toastr.error('El campo empresa es requerido.');
            }
            if(cliente_id == null || cliente_id == '')
            {
                correcto = false;
                toastr.error('El campo cliente es requerido.');
            }
            if(tipo_venta == null || tipo_venta == '')
            {
                correcto = false;
                toastr.error('El campo tipo de venta es requerido.');
            }

            return correcto;
        }

        function obtenerTabla() {
            var t = $('.dataTables-detalle-documento').DataTable();
            @if (!empty($cotizacion))
                @foreach($lotes as $lote)
                    t.row.add([
                        "{{$lote->producto_id}}",
                        '',
                        "{{$lote->cantidad}}",
                        "{{$lote->unidad}}",
                        "{{$lote->descripcion_producto}}",
                        "{{$lote->precio}}",
                        "{{$lote->importe}}",
                        "{{$lote->presentacion}}",
                    ])                    
                @endforeach
                //SUMATORIA TOTAL
                sumaTotal()
            @endif
        }

        //OBTENER TIPOS DE COMPROBANTES 
        function obtenerTiposComprobantes() {

            if ($('#empresa_id').val() != '') {            
                $.ajax({
                    dataType : 'json',
                    url: '{{ route("ventas.vouchersAvaible")}}',
                    type:'post',
                    data : {
                        '_token' : $('input[name=_token]').val(),
                        'empresa_id' :$('#empresa_id').val(),
                        'tipo_id': $('#tipo_venta').val()
                    },
                    success : function(response){
                        if (response.existe == false) {
                            toastr.error('La empresa '+response.empresa+' no tiene registrado el comprobante '+response.comprobante, 'Error');    
                        }else{
                            toastr.success('La empresa '+response.empresa+' tiene registrado el comprobante '+response.comprobante, 'Accion Correcta');
                        }
                        
                    },            
                })
            }

        }
        
        function consultarSeguntipo() {
            $('#empresa_id').prop("disabled", false);
            obtenerTiposComprobantes()
            obtenerClientes()
        }

        function obtenerClientes() {
            if ($('#tipo_id').val() != '') {            
                $.ajax({
                    dataType : 'json',
                    url: '{{ route("ventas.customers")}}',
                    type:'post',
                    data : {
                        '_token' : $('input[name=_token]').val(),
                        'tipo_id': $('#tipo_venta').val()
                    },
                    success : function(data){
                        if(data.clientes.length > 0){
                            $('#cliente_id').val($('#cliente_id option:first-child').val()).trigger('change');
                            $('#cliente_id').prop("disabled", false);
                            var clientes = '<option value="" selected disabled >SELECCIONAR</option>'
                            for (var i = 0; i < data.clientes.length; i++)
                                clientes += '<option value="' + data.clientes[i].id + '">'+data.clientes[i].tipo_documento+': '+data.clientes[i].documento +' - '+data.clientes[i].nombre+ '</option>';

                        }else{
                            $('#cliente_id').val($('#cliente_id option:first-child').val()).trigger('change');
                            $('#cliente_id').prop("disabled", true);
                            toastr.error('Clientes no encontrados.','Error');
                        }

                        $("#cliente_id").html(clientes);
                        $('#tipo_cliente_documento').val(data.tipo);
                    },            
                })
            }
        }

        function obtenerTipocliente(cliente_id) {
            if (cliente_id) {
                $.ajax({
                    dataType : 'json',
                    url: '{{ route("ventas.cliente.getcustomer")}}',
                    type:'post',
                    data : {
                        '_token' : $('input[name=_token]').val(),
                        'cliente_id': cliente_id
                    },
                    success : function(cliente){
                        $('#buscarLotes').prop("disabled", false)
                        obtenerLotesproductos(cliente.tabladetalles_id)
                    },            
                })
            }
        }

         //ERRORES DEVOLUCIONES
        @if (!empty($errores))
            $('#asegurarCierre').val(1)
            @foreach($errores as $error)
                toastr.error('La cantidad solicitada '+"{{$error->cantidad}}"+' excede al stock del producto '+"{{$error->producto}}", 'Error');
            @endforeach
        @endif


</script>

<script>
    window.onbeforeunload = function () { 
        //DEVOLVER CANTIDADES 
        if($('#asegurarCierre').val() == 1 ) {devolverCantidades()}
    
    };

</script>



@endpush