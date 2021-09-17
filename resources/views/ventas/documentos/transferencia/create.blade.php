@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documento-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO TRANSFERENCIA DEL DOCUMENTO DE VENTA #{{$documento->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.documento.index')}}">Documentos de Compra</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documentos.transferencia.pago.index', $documento->id)}}">Pagos</a>
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
                        <form action="{{route('ventas.documentos.transferencia.pago.store')}}" id="enviar_pago" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <h4><b>Documento de Venta #{{$documento->id}}</b></h4>
                                <p>Datos del documento de venta:</p>
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
                                            <label><strong>Monto: </strong></label>
                                            <p>{{'S/. '.$documento->total}}</p>
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
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">

                                            <li title="Datos de la Empresa"><a class="nav-link active" data-toggle="tab"
                                                    href="#tab-1" id="empresa_link"> <i class="fa fa-building"></i> Empresa</a></li>
                                            <li title="Datos de Pago"><a class="nav-link" data-toggle="tab"
                                                    href="#tab-2" id="pago_link"> <i class="fa fa-money"></i> Pago</a></li>
                                        </ul>
                                        <div class="tab-content">

                                            <div id="tab-1" class="tab-pane active">
                                                <div class="panel-body">
                                                    <h4><b>Empresa</b></h4>
                                                    <p>Datos de la empresa:</p>

                                                    <div class="row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    
                                                                    <div class="form-group" >
                                                                        <label class="col-form-label"><b>RUC:</b></label>
                                                                        <p>{{$documento->ruc_empresa}}</p>
                                                                    </div>
                                                                
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                    <label class="col-form-label"><b>Razón Social:</b></label>
                                                                    <p>{{$documento->empresa}}</p>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label"><b>Dirección Fiscal:</b></label>
                                                                <p>{{$documento->empresa_direccion}}</p>
                                                            </div>


                                                        
                                                        </div>
                                                    
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4 class=""><b>Entidad Financiera</b></h4>
                                                            <p>Seleccionar entidad financiera de la empresa:</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table dataTables-bancos-empresa table-striped table-bordered table-hover"
                                                            style="text-transform:uppercase" id="table-bancos-empresa">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th class="text-center">DESCRIPCION</th>
                                                                        <th class="text-center">MONEDA</th>
                                                                        <th class="text-center">CUENTA</th>
                                                                        <th class="text-center">CCI</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>

                                                    <hr>
                                                    <h4><b>Datos Seleccionados</b></h4>
                                                    <p>Datos seleccionados de la entidad financiera:</p>
                                                    <div class="form-group row">
                                                    
                                                           
                                                            <input type="hidden" name="id_entidad_empresa" id="id_entidad_empresa" value="{{old('id_entidad_empresa')}}">
                                                            <input type="hidden" name="moneda_empresa_pago" id="moneda_empresa_pago" value="{{old('moneda_empresa_pago')}}">
                                                            <div class="col-md-3">

                                                                <label class="col-form-label">Descripción</label>
                                                                <input type="text" id="descripcion_empresa" class="form-control" disabled>
                                                                
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label class="col-form-label">Moneda</label>
                                                                <input type="text" id="moneda_empresa" class="form-control" disabled>

                                                            </div>

                                                            <div class="col-md-3">

                                                                <label class="col-form-label">N° Cuenta</label>
                                                                <input type="text" id="cuenta_empresa" class="form-control" disabled>

                                                            </div>
                                                            
                                                            <div class="col-md-3">

                                                                <label class="col-form-label">N° CCI</label>
                                                                <input type="text" id="cci_empresa" class="form-control" disabled>

                                                            </div>
                                                        
                                                        
                                                    </div>




                                                </div>
                                            </div>

                                            <div id="tab-2" class="tab-pane">
                                                <div class="panel-body">

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <b>Detalle del Registro de Pago</b>
                                                                <input type="hidden" id="suma_monto_restante">
                                                                <input type="hidden" id="id_documento" name="id_documento" value="{{$documento->id}}">
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">

                                                                    <div class="col-md-6 text-left b-r">

                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <h4 class="">Monto del Documento</h4>
                                                                                <p class="text-navy"><b>
                                                                                    <span id="simbolo_restante"></span>
                                                                                    <span id="restante"></span>
                                                                                </b></p>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <h4 class="">Monto A cuenta</h4>
                                                                                <p class="text-navy"><b>
                                                                                    <span id="monto_acuenta"></span>
                                                                                </b></p>
                                                                            </div>
                                                                            

                                                                        </div>

                                                                    
                                                                    
                                                                    
                                                                    </div>

                                                                    <div class="col-md-6 text-left">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <h4 class="">Monto Restante</h4>
                                                                                <p class="text-navy"><b>
                                                                                    <span id="simbolo_equivalente"></span> 
                                                                                    <span id="equivalente"></span>
                                                                                </b></p>
                                                                            </div>

                                                                        </div>
                                                                        

                                                                    </div>


                                                                </div>
                                                                <hr>

                                                                <div class="row">
                                                                <div class="col-md-6 b-r">
                                                                    <p>Registrar datos del nuevo pago:</p>
                                                                    
                                                                    <div class="form-group row">

                                                                        <div class="col-lg-6 col-xs-12" id="fecha_pago">
                                                                            <label class="required">Fecha de Pago</label>
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </span>
                                                                                <input type="text" id="fecha_pago_campo" name="fecha_pago"
                                                                                    class="form-control {{ $errors->has('fecha_pago') ? ' is-invalid' : '' }}"
                                                                                    value="{{old('fecha_pago',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
                                                                                    autocomplete="off" required readonly>

                                                                                    @if ($errors->has('fecha_pago'))
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $errors->first('fecha_pago') }}</strong>
                                                                                    </span>
                                                                                    @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-xs-12" id="">
                                                                                
                                                                                <label class="required" style="text-transform:none">Monto en 
                                                                                <span id="simbolo_monto_orden"></span>:</label>
                                                                                <input type="text" id="monto" name="monto" class="form-control {{ $errors->has('monto') ? ' is-invalid' : '' }}" value="{{old('monto')}}" placeholder="0.00" required>
                                                                                @if ($errors->has('monto'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('monto') }}</strong>
                                                                                </span>
                                                                                @endif

                                                                        </div>



                                                                
                                                                    </div>

                                                                    <div class="form-group row">

                                                                        <div class="col-lg-12 col-xs-12">
                                                                            <label class="required">Archivo:</label>

                                                                            <div class="custom-file">
                                                                                <input id="archivo" type="file" name="archivo" id="archivo"
                                                                                    class="custom-file-input {{ $errors->has('archivo') ? ' is-invalid' : '' }}"
                                                                                    accept="pdf , image/*" required>

                                                                                <label for="archivo" id="archivo_txt"
                                                                                    class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">Seleccionar</label>

                                                                                @if ($errors->has('archivo'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('archivo') }}</strong>
                                                                                </span>
                                                                                @endif

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">

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


                                                                </div>
                                                                </div>

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
                                                        <a href="{{route('compras.documentos.transferencia.pago.index', $documento->id)}}" id="btn_cancelar"
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
                            </div>
                    </div>
                </div>
            </div>
    </div>

</div>


@stop
@push('styles')
<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
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
@endpush
@push('scripts')
<!-- Select2 -->
<script src="{{asset('Inspinia/js/plugins/select2/select2.full.min.js')}}"></script>
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

<script>

//VALIDACION EN TABS 
$('.tabs-container .nav-tabs #empresa_link').click(function() {

  if ($('#id_entidad').val()!='') {
    return true;
  } else {
    toastr.error("Seleccionar entidad financiera del proveedor.", 'Error');
    return false;
  }

})

$('.tabs-container .nav-tabs #pago_link').click(function() {

    if ($('#id_entidad').val()!='') {
        if ($('#id_entidad_empresa').val() != '') {
            return true;        
        }else{
            toastr.error("Seleccionar entidad financiera de la empresa.", 'Error');
            return false;
        }
    } else {
    toastr.error("Seleccionar entidad financiera del proveedor.", 'Error');
    return false;
    }
})

//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});

$('#fecha_pago .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    startDate: "today"
})

$('#tipo_cambio').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});



$('#monto').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});


// Error entidad bancaria
@if ($errors->has('id_entidad'))
    toastr.error("{{ $errors->first('id_entidad') }}", 'Error');    
@endif

// Error entidad bancaria Empresa
@if ($errors->has('id_entidad_empresa'))
    toastr.error("{{ $errors->first('id_entidad_empresa') }}", 'Error');    
@endif


function registrosBancosempresa() {
    var table = $('.dataTables-bancos-empresa').DataTable();
    var registros = table.rows().data().length;
    return registros
}


$(document).ready(function() {


    $('.dataTables-bancos-empresa').DataTable({
        "dom": 'Tftp',
        "bPaginate": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },

        "columnDefs": [{
                "targets": [0],
                visible: false
            },
            {
                "targets": [1],
                className: "text-center",
            },
            {
                "targets": [2],
                className: "text-center",
            },
            {
                "targets": [3],
                className: "text-center",
            },
            {
                "targets": [4],
                className: "text-center",
            },

        ],
        createdRow: function(row, data, dataIndex, cells) {
            $(row).addClass('fila_entidad-empresa');
            $(row).attr('data-href', "");
        },

    });
    obtenerEmpresa()
    // cambiarMonto()


    var empresas = registrosBancosempresa() 
    if (empresas == '0') {
        toastr.error("Empresa sin entidades financieras", 'Error');     
    }

    var table_empresa = $('.dataTables-bancos-empresa').DataTable();
    $('.dataTables-bancos-empresa tbody').on('click', 'tr', function() {

        table_empresa.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        
    });


    $('.dataTables-bancos-empresa').on('click', 'tbody td' , function() {
        //Limpia datos de pagos
        limpiarCampos()
        var data = table_empresa.row(this).data();
        $('#id_entidad_empresa').val(data[0])
        $('#descripcion_empresa').val(data[1])
        $('#moneda_empresa').val(data[2])
        $('#moneda_empresa_pago').val(data[2])
        $('#cuenta_empresa').val(data[3])
        $('#cci_empresa').val(data[4])
        //Detalle
        $('#descripcion_empresa_detalle').val(data[1])
        $('#moneda_empresa_detalle').val(data[2])
        $('#cuenta_empresa_detalle').val(data[3])
        $('#cci_empresa_detalle').val(data[4])

        //CONVERSIONES TIPO DE CAMBIO MONEDA (EMPRESA)
        $('#moneda_cuenta_origen').text(data[2])
        $('#moneda_cuenta_origen_empresa').text(data[2])

    });

    // SIMBOLO DE LA ORDEN EN MONTO
    $('#simbolo_monto_orden').text('S/.')
    //INICIANDO MONTO A CUENTA
    $('#monto_acuenta').text('S/. 0.00')
    //INICIALIZAMOS MONTO
    $('#simbolo_restante').text('S/. ')
    $('#restante').text("{{$monto}}")
    //INICIALIZAMOS MONTO RESTANTE
    $('#simbolo_equivalente').text('S/. ')
    $('#equivalente').text(' 0.00')
})


$('#monto').keyup(function() {
    
    var monto = $(this).val()
    $('#monto_acuenta').text('S/. '+Number(monto).toFixed(2))
    // CALCULAR EL MONTO RESTANTE 
    var restante = $('#restante').text()
    var resto = Number(restante) - Number(monto)
    $('#equivalente').text(Number(resto).toFixed(2))

})    



function obtenerEmpresa() {
    var t = $('.dataTables-bancos-empresa').DataTable();
    @foreach($bancos_empresa as $ban)
        @if($ban['estado'] == 'ACTIVO' )
            t.row.add([
                "{{$ban['id']}}",
                "{{$ban['descripcion']}}",
                "{{$ban['tipo_moneda']}}",
                "{{$ban['num_cuenta']}}",
                "{{$ban['cci']}}",
            ]).draw(false);
        @endif

    @endforeach
}

$('.custom-file-input').on('change', function() {
    var fileInput = document.getElementById('archivo');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.pdf)$/i;

    if (allowedExtensions.exec(filePath)) {
        var userFile = document.getElementById('archivo');
        userFile.src = URL.createObjectURL(event.target.files[0]);
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    } else {
        toastr.error('Extensión inválida, formatos admitidos (.pdf .jpg . jpeg . png)', 'Error');
    }
});


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
                
                var monto_correcto =  montoCorrecto()
                if (monto_correcto == true) {
                    $('#cambio').attr('disabled',false)
                    this.submit();
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

function montoCorrecto() {
    var correcto = true
    var monto = $('#equivalente').text()
    if (Number(monto) < 0) {
        toastr.error("El monto restante es un valor incorrecto.", 'Error'); 
        correcto = false
    }
    return correcto
}


function limpiarCampos() {
    //Agregar montos inicial
    
    $('#moneda_orden').text('S/. ')

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


</script>



@endpush