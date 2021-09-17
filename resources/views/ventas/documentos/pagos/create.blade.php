@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documentos-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO PAGO DEL DOCUMENTO DE VENTA #{{$documento->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documento.index')}}">Documentos de Venta</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documentos.pago.index',$documento->id)}}">Pagos</a>
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
                        <form action="{{route('ventas.documentos.pago.store')}}" id="enviar_pago" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <h4><b>Documento de Venta #{{$documento->id}}</b></h4>
                                <p>Datos del Documento de Venta:</p>
                                <input type="hidden" name="id_documento" value="{{$documento->id}}">
                            </div> 
                            <div class="row">
                            
                                <div class="col-md-6 b-r">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Fecha de Emisión: </strong></label>
                                            <p>{{ Carbon\Carbon::parse($documento->fecha_emision)->format('d/m/y') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label><strong>Fecha de Entrega: </strong></label>
                                            <p>{{ Carbon\Carbon::parse($documento->fecha_entrega)->format('d/m/y') }}</p>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Moneda: </strong></label>
                                            <p>SOLES</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Monto: </strong></label>
                                            <p>{{'S/. '.$monto}}</p>
                                        </div>


                                        
                                    </div>



                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Empresa: </strong></label>
                                        <p>{{$documento->empresa}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Cliente: </strong></label>
                                        <p>{{$documento->cliente}}</p>
                                    </div>
                                </div>
                            
                            </div>
                            <hr>



                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <b>Detalle del Registro de Pago</b>
                                            <input type="hidden" id="suma_monto_restante">
                                        </div>
                                        <div class="panel-body">

                                            <div class="row">

                                                <div class="col-md-6 text-left b-r">

                                                    <div class="form-group row">
                                                        <div class="col-md-12 text-left">
                                                            <h4 class="">Monto del Documento</h4>
                                                            <p class="text-navy"><b>{{'S/. '.$monto}}</b></p>
                                                        </div>
                                                        

                                                    </div>




                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <div class="row">


                                                        <div class="col-md-6">
                                                            <h4 class="">Monto del Pago</h4>
                                                            <p class="text-navy"><b><span id="simbolo_pago">{{simbolo_monedas($documento->moneda)}}</span> <span id="monto_acumulado">0.0</span></b></p>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <h4 class="">Monto Restante</h4>
                                                            <p class="text-navy"><b><span id="simbolo_restante"></span>{{simbolo_monedas($documento->moneda)}}<span id="monto_equivalente">{{$monto}}</span></b></p>
                                                        </div>

                                                    </div>
                                                    

                                                </div>


                                            </div>

                                            <hr>

                                            <p>Registro del Pago:</p>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                
                                                <label class="required">Tipo de Pago: </label>

                                                    <select
                                                        class="select2_form form-control"
                                                        style="text-transform: uppercase; width:100%" name="tipo_pago" id="tipo_pago" required>
                                                        <option></option>
                                                        @foreach (tipos_pago_caja() as $pago)
                                                        <option value="{{$pago->descripcion}}">{{$pago->descripcion}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-6">
                                                    <label>Observación:</label>
                                                    <textarea type="text" placeholder=""
                                                    class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                                    name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                                    value="{{old('observacion')}}">{{old('observacion')}}</textarea>
                                                </div>
                                            </div>




                                            <hr>

                                            <div id="otroTipo">
                                                <p>Pagos a ingresar a tabla:</p>


                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <label class="required">Caja: </label>
                                                        <select
                                                            class="select2_form form-control"style="text-transform: uppercase; width:100%" name="caja_id" id="caja_id">
                                                            <option></option>
                                                            @foreach ($cajas as $caja)
                                                            <option value="{{$caja->id}}" >{{$caja->id.' - '.$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno.' '.$caja->empleado->persona->nombres}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback"><b><span id="error-caja_id"></span></b></div>
                                                        
                                                    </div>

                                                    <div class="col-md-3">

                                                        <label class="required">Monto: </label>
                                                        <input type="text" class="form-control" name="monto_caja" id="monto_caja">
                                                        <div class="invalid-feedback"><b><span id="error-monto_caja"></span></b></div>
                                                        <input type="hidden" id="max_input" >

                                                    </div>
                                                    <div class="col-md-3">
                                                            <label class="m-t"><span></span> </label>
                                                            <a class="btn btn-block btn-warning enviar_caja" style="color:white"> <i class="fa fa-plus"></i> AGREGAR</a>
                                                    
                                                    </div>
        
                                                </div>
                                                <input type="hidden" id="pagos_tabla" name="pagos_tabla[]">
                                                
                                                <hr>


                                                <div class="table-responsive">
                                                    <table
                                                        class="table dataTables-caja table-striped table-bordered table-hover"
                                                        style="text-transform:uppercase">
                                                        <thead>

                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">ACCIONES</th>
                                                                <th class="text-center">CAJA</th>
                                                                <th class="text-center">MONTO</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3" class="text-center">TOTAL:</th>
                                                                <th class="text-center"><span id="total">0.0</span></th>

                                                            </tr>
                                                        </tfoot>
    
                                                    </table>
                                                </div>
                                            </div>

                                            <input type="hidden" name="total" id="monto">




                                           </div>

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
                                    <a href="{{route('compras.documentos.pago.index',$documento->id)}}" id="btn_cancelar"
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

@include('ventas.documentos.pagos.modal')
@stop
@push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<style>
    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        margin-left: 2px;
    }

    #table-bancos tr[data-href] ,
    #table-bancos-empresa tr[data-href]
    {
        cursor: pointer;
    }

    #table-bancos tbody .fila_entidad.selected,
    #table-bancos-empresa tbody .fila_entidad-empresa.selected
    {
        /* color: #151515 !important;*/
        font-weight: 400;
        color: white !important;
        background-color: #1ab394 !important;
        /* background-color: #CFCFCF !important; */
    }
</style>

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

//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});


$(document).ready(function() {
    // DATATABLE DIFERENTE AL DE TRANSFERENCIA
    $('.dataTables-caja').DataTable({
        "dom": 'lTfgitp',
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },

        "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {

                "targets": [1],
                className: "text-center",
                render: function(data, type, row) {
                    return "<div class='btn-group'>" +
                        "<a class='btn btn-warning btn-sm modificarDetalle' id='editar_documento' style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>" +
                        "<a class='btn btn-danger btn-sm' id='borrar_documento' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                        "</div>";
                }
            },
            {
                "targets": [2],
            },
            {
                "targets": [3],
                className: "text-center",
            }


        ],


    });

})

function limpiarErrores() {
    $('#caja_id').removeClass("is-invalid")
    $('#error-caja_id').text('')

    $('#monto_caja').removeClass("is-invalid")
    $('#error-monto_caja').text('')
}

function buscarCaja(id) {
    var existe = false;
    var t = $('.dataTables-caja').DataTable();
    t.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

//Validacion al ingresar tablas
$(".enviar_caja").click(function() {
    
    limpiarErrores()
    var enviar = false;
    if ($('#caja_id').val() == '') {
        toastr.error('Seleccione Empleado creador de la caja chica.', 'Error');
        enviar = true;
        $('#caja_id').addClass("is-invalid")
        $('#error-caja_id').text('El campo Empleado es obligatorio.')
    } else {
        var existe = buscarCaja($('#caja_id').val())
        if (existe == true) {
            toastr.error('Caja Chica ya se encuentra ingresado.', 'Error');
            enviar = true;
        }
    }

    if ($('#monto_caja').val() == '') {
        toastr.error('Ingrese el monto.', 'Error');
        enviar = true;
        $('#monto_caja').val($('#max_input').val());
        $("#monto_caja").addClass("is-invalid");
        $('#error-monto_caja').text('El campo Monto es obligatorio.')
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
            text: "¿Seguro que desea agregar Monto de Pago?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                var nombre_completo = obtenerNombreCompleto($('#caja_id').val())
                var detalle = {
                    caja_id: $('#caja_id').val(),
                    nombre_completo: nombre_completo,
                    monto: $('#monto_caja').val(),
                }
                limpiarDetalle()
                agregarTabla(detalle);
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

    }
})

//Editar Registro
$(document).on('click', '#editar_documento', function(event) {
    var table = $('.dataTables-caja').DataTable();
    var data = table.row($(this).parents('tr')).data();

    $('#indice').val(table.row($(this).parents('tr')).index());
    $('#caja_id_editar').val(data[0]).trigger('change');
    cargarCajaEditar(data[0])
 
    $('#monto_editar').val(data[3]);
    $('#modal_editar_orden').modal('show');
})

//Borrar registro 
$(document).on('click', '#borrar_documento', function(event) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea eliminar Pago?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            var table = $('.dataTables-caja').DataTable();
            table.row($(this).parents('tr')).remove().draw();
            sumaTotal()
            // calcularIgv($('#igv').val())

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

function limpiarDetalle() {
    $('#monto_caja').val('')
    $('#max_input').val('')
    $('#caja_id').val($('#caja_id option:first-child').val()).trigger('change');
}


function agregarTabla($detalle) {

    var t = $('.dataTables-caja').DataTable();
    t.row.add([
        $detalle.caja_id,
        '',
        $detalle.nombre_completo,
        $detalle.monto,
    ]).draw(false);

    cargarPagos()

}

function cargarPagos() {

    var pagos = [];
    var table = $('.dataTables-caja').DataTable();
    var data = table.rows().data();
    data.each(function(value, index) {
        let fila = {
            caja_id: value[0],
            monto: value[3],
        };

        pagos.push(fila);

    });

    $('#pagos_tabla').val(JSON.stringify(pagos));
}

function sumaTotal() {
    var t = $('.dataTables-caja').DataTable();
    var subtotal = 0;
    t.rows().data().each(function(el, index) {
        subtotal = Number(el[3]) + subtotal
    });

    $('#total').text(subtotal.toFixed(2))
    $('#monto_acumulado').text(subtotal.toFixed(2))

    //Monto Restante
    var monto_restante = Number("{{$monto}}") - Number(subtotal.toFixed(2))
    $('#monto_equivalente').text(monto_restante.toFixed(2))

}

////////////////////

//Obtener el simbolo para el pago
function simboloMoneda(moneda) {
    var simbolo = 'S/. '
    return simbolo
}

function obtenerNombreCompleto($id) {
    var nombreCompleto = ""
    @foreach($cajas as $caja)
    if ("{{$caja->id}}" == $id) {
        nombreCompleto = "{{$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno.' '.$caja->empleado->persona->nombres}}"
    }
    @endforeach
    return nombreCompleto;
}


$('#enviar_pago').submit(function(e) {
    e.preventDefault();
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
            var monto_restante = $('#monto_equivalente').text()
            var monto_acumulado = $('#monto_acumulado').text()

            if( Number(monto_acumulado) == 0){
                toastr.error("El total del pago debe ser superior a 0", 'Error');
            }else{
                if (Number(monto_restante) < 0) {
                    toastr.error("El monto pagado supera el monto del doumento de pago", 'Error');
                }else{
                    $('#monto').val($('#total').text())
                    this.submit()   
                }

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
})

//Calcular cambio soles

$('#monto_caja').keyup(function() {   
    
    var monto = $(this).val();

    if (isNaN(monto)) {
     monto = monto.replace(/[^0-9\.]/g, '');
     if (monto.split('.').length > 2)
         monto = monto.replace(/\.+$/, "");
    }
    $(this).val(monto);

    // if ( $('#max_input').val() != '') {
    //     var max = $('#max_input').val();
    //     var min = 0

    //     if(monto > Number(max) || Number(monto) < min ){           
    //         toastr.error("El monto Máximo de la caja chica es: "+max, 'Error');
    //         $('#monto_caja').val(max);
    //     } 

    // }else{
    //     toastr.error("Debe de seleccionar el empleado creador de la caja chica", 'Error');
    //     $(this).val('');
    // }

});

function limpiarCampos() {
    //Agregar montos inicial
    
    $('#moneda_orden').text(simboloMoneda("{{$documento->moneda}}"))
    

    //TIPOS DE CAMBIO DE ACUERDO A LA CUENTA
    $('#tc_dia').val('')
    $('#tc_empresa_proveedor').val('')

    //TIPO DE CAMBIO 
    $('#tipo_cambio').val('')

    //MONTO QUE SE ENVIA
    $('#monto').val('')
    
    //CAMBIO SEGUN LA MONEDA
    $('#cambio').val('')

    $('#monto_equivalente').text('')
    //MONTO EN CONVERSION A SOLES
    $('#monto_soles_tipo').val('')
    $('#tipo_cambio_soles').val('')
    $('#monto_soles').val('')
    
}

function cargarCajaEditar(caja) {
    $.get('/compras/documentos/getBox/document/'+ caja, function (data) {
        $('#max_input_editar').val('');
        $('#max_input_editar').val(data);

    });
}




</script>



@endpush