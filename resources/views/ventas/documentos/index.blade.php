@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documento-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
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
    <div class="col-lg-2 col-md-2">
        <a class="btn btn-block btn-w-m btn-primary m-t-md" href="{{route('ventas.documento.create')}}">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </a>
    </div>
</div>

<div>
    <a id="nueva_ventana" target="_blank">liga</a>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-orden table-striped table-bordered table-hover"
                        style="text-transform:uppercase">
                            <thead>
                                <tr>
                                    
                                    <th colspan="2" class="text-center"></th>
                                    <th colspan="6" class="text-center">DOCUMENTO DE VENTA</th>
                                    <th colspan="2" class="text-center">FORMAS DE PAGO</th>
                                    <th colspan="4" class="text-center"></th>

                                </tr>
                                <tr>
                                   
                                    <th style="display:none;"></th>
                                    <th class="text-center">C.O</th>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">FECHA DOC.</th>
                                    <th class="text-center">TIPO</th>
                                    <th class="text-center">CLIENTE</th>
                                    <th class="text-center">MONTO</th>
                                    <th class="text-center">TRANSF.</th>
                                    <th class="text-center">OTROS</th>
                                    <th class="text-center">EFECT.</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">SUNAT</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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

    // DataTables
    $('.dataTables-orden').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'Tablas Generales'
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
        "processing": true,
        "ajax": "{{ route('ventas.getDocument')}}",
        "columns": [
            //DOCUMENTO DE VENTA
            {
                data: 'cotizacion_venta',
                className: "text-center letrapequeña",
                visible: false
            },



            {
                data: null,
                className: "text-center letrapequeña",
                render: function(data) {
                    if (data.cotizacion_venta) {
                        return "<input type='checkbox' disabled checked>"
                    }else{
                        return "<input type='checkbox' disabled>"
                    }
                }
                
            },
            {
                data: 'id',
                className: "text-center letrapequeña",
            },
            {
                data: 'fecha_documento',
                className: "text-center letrapequeña"
            },
            {
                data: 'tipo_venta',
                className: "text-center letrapequeña",
            },
            {
                data: 'cliente',
                className: "text-left letrapequeña"
            },

            {
                data: 'total',
                className: "text-center letrapequeña"
            },
            {
                data: 'transferencia',
                className: "text-center letrapequeña"
            },

            {
                data: 'otros',
                className: "text-center letrapequeña"
            },
            {
                data: 'efectivo',
                className: "text-center letrapequeña"
            },


            {
                data: null,
                className: "text-center letrapequeña",
                render: function(data) {
                    switch (data.estado) {
                        case "PENDIENTE":
                            return "<span class='badge badge-warning' d-block>" + data.estado +
                                "</span>";
                            break;
                        case "PAGADA":
                            return "<span class='badge badge-danger' d-block>" + data.estado +
                                "</span>";
                            break;
                        case "ADELANTO":
                            return "<span class='badge badge-success' d-block>" + data.estado +
                                "</span>";
                            break;
                        default:
                            return "<span class='badge badge-success' d-block>" + data.estado +
                                "</span>";
                    }
                },
            },

            {
                data: null,
                className: "text-center letrapequeña",
                render: function(data) {
                    switch (data.sunat) {
                        case "1":
                            return "<span class='badge badge-warning' d-block>ACEPTADO</span>";
                            break;
                        case "2":
                            return "<span class='badge badge-danger' d-block>NULA</span>";
                            break;
                        default:
                            return "<span class='badge badge-success' d-block>REGISTRADO</span>";
                    }
                },
            },

            {
                data: null,
                className: "text-center letrapequeña",
                render: function(data) {
                    //Ruta Detalle
                    var url_detalle = '{{ route("ventas.documento.show", ":id")}}';
                    url_detalle = url_detalle.replace(':id', data.id);

                    return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                    
                        "<li><a class='dropdown-item' target='_blank' onclick='comprobanteElectronico(" +data.id+ ")' title='Detalle'><b><i class='fa fa-file-pdf-o'></i> Pdf</a></b></li>" +
                        "<li><a class='dropdown-item' target='_blank' onclick='comprobanteElectronicoTicket(" +data.id+ ")' title='Detalle'><b><i class='fa fa-ticket'></i> Ticket</a></b></li>" +
                        "<li><a class='dropdown-item' target='_blank' onclick='xmlElectronico(" +data.id+ ")' title='Detalle'><b><i class='fa fa-code'></i> XML</a></b></li>" +
                        "<li><a class='dropdown-item' onclick='eliminar(" + data.id + ")' title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                        "<li class='dropdown-divider'></li>" +
                        
                        "<li><a class='dropdown-item' onclick='enviarSunat(" +data.id+ ")'  title='Enviar Sunat'><b><i class='fa fa-send'></i> Enviar Sunat</a></b></li>" +
                        "<li><a class='dropdown-item' onclick='enviarSunatBaja(" +data.id+ ")'  title='Enviar Sunat Baja'><b><i class='fa fa-remove'></i> Dar de baja sunat</a></b></li>" +
                        "<li><a class='dropdown-item' onclick='guia(" +data.id+ ")'  title='Enviar Sunat'><b><i class='fa fa-file'></i> Guia Remision</a></b></li>"
                        
                    "</ul></div>"
                }
            }

        ],
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
        "order": [],
    });

    tablaDatos = $('.dataTables-enviados').DataTable();

});

//Controlar Error
$.fn.DataTable.ext.errMode = 'throw';

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
    },
    buttonsStyling: false
})


function eliminar(id) {

    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea guardar cambios?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            //Ruta Eliminar
            var url_eliminar = '{{ route("ventas.documento.destroy", ":id")}}';
            url_eliminar = url_eliminar.replace(':id', id);
            $(location).attr('href', url_eliminar);

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

function pagar(id,tipo) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: 'Opción Formas de Pago',
        text: "Elija la forma de pago",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Transferencia',
        cancelButtonText: "Otros",
    }).then((result) => {
        if (result.isConfirmed) {


            if (tipo == null || tipo == 1  ) {
                
                var url = '{{ route("ventas.documentos.transferencia.pago.index", ":id")}}';
                url = url.replace(':id', id);
                $(location).attr('href', url);

            }else{
                Swal.fire({
                        customClass: {
                            container: 'my-swal'
                        },
                        title: 'Error',
                        text: "Existe un tipo de pago, desea anular y crear un tipo de pago nuevo",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: 'Si, Confirmar',
                        cancelButtonText: "No, Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            var url = '{{ route("ventas.documento.tipo_pago.existente", ":id")}}';
                            url = url.replace(':id', id);
                            $(location).attr('href', url);
                            }else if (
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
        
        
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {


            if (tipo  == null || tipo == 0  ) {
                
                var url = '{{ route("ventas.documentos.pago.index", ":id")}}';
                url = url.replace(':id', id);
                $(location).attr('href', url);

            }else{
                
                Swal.fire({
                        customClass: {
                            container: 'my-swal'
                        },
                        title: 'Error',
                        text: "Existe un tipo de pago, desea anular y crear un tipo de pago nuevo",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: 'Si, Confirmar',
                        cancelButtonText: "No, Cancelar",
                        }).then((result) => {
                        if (result.isConfirmed) {
                            var url = '{{ route("ventas.documento.tipo_pago.existente", ":id")}}';
                            url = url.replace(':id', id);
                            $(location).attr('href', url);
                            }else if (
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
        
        }
    })

}

function modificar(cotizacion,id) {
    if (cotizacion) {
        toastr.error('El documento de venta fue generado por una cotización (Opción "Editar" en cotizaciones).', 'Error');
    }else{
        Swal.fire({
            title: 'Opción Modificar',
            text: "¿Seguro que desea modificar registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                //Ruta Modificar
                var url_editar = '{{ route("ventas.documento.edit", ":id")}}';
                url_editar = url_editar.replace(':id', id);
                $(location).attr('href', url_editar);

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
}

function comprobanteElectronico(id) {
    var url = '{{ route("ventas.documento.comprobante", ":id")}}';
    url = url.replace(':id',id+'-100');
    window.open(url, "Comprobante SISCOM", "width=900, height=600")
    /*const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Detalle",
        text: "¿Seguro que desea obtener el documento de venta?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            
            var url = '{{ route("ventas.documento.comprobante", ":id")}}';
            url = url.replace(':id',id+'-100');

            window.location.href = url

            Swal.fire({
                title: '¡Cargando!',
                type: 'info',
                text: 'Generando Detalle',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
            )
        }
    })*/

}

function comprobanteElectronicoTicket(id) {
    var url = '{{ route("ventas.documento.comprobante", ":id")}}';
    url = url.replace(':id',id+'-80');    
    window.open(url, "Comprobante SISCOM", "width=900, height=600");
    /*const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Detalle",
        text: "¿Seguro que desea obtener el documento de venta?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            
            var url = '{{ route("ventas.documento.comprobante", ":id")}}';
            url = url.replace(':id',id+'-80');

            window.location.href = url

            Swal.fire({
                title: '¡Cargando!',
                type: 'info',
                text: 'Generando Detalle',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

        } else if (
            // Read more about handling dismissals below
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
            )
        }
    });*/
}

function xmlElectronico(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    });

    Swal.fire({
        title: "Opción XML",
        text: "¿Seguro que desea obtener el documento de venta en xml?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            
            var url = '{{ route("ventas.documento.xml", ":id")}}';
            url = url.replace(':id',id);

            window.location.href = url

            // Swal.fire({
            //     title: '¡Cargando!',
            //     type: 'info',
            //     text: 'Generando XML',
            //     showConfirmButton: false,
            //     onBeforeOpen: () => {
            //         Swal.showLoading()
            //     }
            // })

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

function  guia(id) {
    Swal.fire({
        title: 'Opción Guia de Remision',
        text: "¿Seguro que desea crear una guia de remision?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            //Ruta Guia
            var url = '{{ route("ventas.guiasremision.create", ":id")}}';
            url = url.replace(':id', id);
            $(location).attr('href', url);

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

function enviarSunat(id , sunat) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Enviar a Sunat",
        text: "¿Seguro que desea enviar documento de venta a Sunat?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            
            var url = '{{ route("ventas.documento.sunat", ":id")}}';
            url = url.replace(':id',id);

            window.location.href = url

            Swal.fire({
                title: '¡Cargando!',
                type: 'info',
                text: 'Enviando documento de venta a Sunat',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

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

function enviarSunatBaja(id , sunat) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Enviar a Sunat",
        text: "¿Seguro que desea enviar documento de venta a Sunat?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            
            var url = '{{ route("ventas.documento.sunat", ":id")}}';
            url = url.replace(':id',id);

            window.location.href = url

            Swal.fire({
                title: '¡Cargando!',
                type: 'info',
                text: 'Enviando documento de venta a Sunat',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

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

@if(!empty($sunat_exito))
    Swal.fire({
        icon: 'success',
        title: '{{$id_sunat}}',
        text: '{{$descripcion_sunat}}',
        showConfirmButton: false,
        timer: 2500
    })
@endif

@if(!empty($sunat_error))
    Swal.fire({
        icon: 'error',
        title: '{{$id_sunat}}',
        text: '{{$descripcion_sunat}}',
        showConfirmButton: false,
        timer: 5500
    })
@endif

@if(Session::has('documento_id'))
    let doc = '{{ Session::get("documento_id")}}';
    let id = doc+'-100';

    console.log(id);

    var url = '{{ route("ventas.documento.comprobante", ":id")}}';
    url = url.replace(':id', id);
    // $('#nueva_ventana').attr('href',url);
    // document.getElementById('nueva_ventana').click;
    window.open(url, "Comprobante SISCOM", "width=900, height=600")
@endif
</script>
@endpush