@extends('layout') @section('content')
@include('pos.caja_chica.create')
@include('pos.caja_chica.edit')
@section('caja_chica-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>LISTADO DE CAJAS</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Caja Chica</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_crear_caja" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </a>
    </div>
    
</div>


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">

            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table dataTables-cajas table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                                    
                            <th colspan="4" class="text-center">CAJA CHICA</th>
                            <th colspan="2" class="text-center">FECHA</th>
                            <th colspan="2" class="text-center">SALDO</th>
                            <th colspan="3" class="text-center"></th>

                        </tr>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center">REFERENCIA</th>
                            <th class="text-center">VENDEDOR</th>
                            <th class="text-center">APERTURA</th>
                            <th class="text-center">CIERRE</th>
                            <th class="text-center">INICIAL</th>
                            <th class="text-center">RESTANTE</th>
                            <th class="text-center">MONEDA</th>
                            <th class="text-center">ESTADO</th>
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
    .my-swal {
        z-index: 3000 !important;
    }
</style>
@endpush 

@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>

    $(document).ready(function() {


        $('.dataTables-cajas').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Tablas Generales'
                },

                {   
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    text:      '<i class="fa fa-print"></i> Imprimir',
                    customize: function (win){
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
            "processing":true,
            "serverSide":true,
            "ajax": '{{ route("getBox")}}',
            "columns": [
                //Caja chica
                {data: 'id', className:"text-center", "visible":false},
                {data: 'empleado_id', className:"text-center", "visible":false},
                {data: 'num_referencia' , className:"text-center"},
                {data: 'nombre_completo' , className:"text-left"  },
                {data: 'creado', className:"text-center"},
                {data: 'cierre', className:"text-center"},
                {data: 'saldo_inicial', className:"text-center"},
                {data: 'restante', className:"text-center"},
                {data: 'moneda', className:"text-center"},
                {
                    data: null,
                    className: "text-center",
                    render: function(data) {
                        switch (data.estado) {
                            case "APERTURADA":
                                return "<span class='badge badge-primary' d-block>" + data.estado +
                                    "</span>";
                                break;
                            case "CERRADA":
                                return "<span class='badge badge-warning' d-block>" + data.estado +
                                    "</span>";
                                break;
                            default:
                                return "<span class='badge badge-danger' d-block>" + data.estado +
                                    "</span>";
                        }
                    },
                },
                
                {
                    data: null,
                    className: "text-center",
                    name:'cajas.saldo_inicial',
                    render: function(data) {

                        if (data.estado != "CERRADA") {   

                            if (data.uso == '1') {
                                
                                return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +

                                        "<li><a class='dropdown-item' onclick='obtenerData("+data.id+")' title='Modificar' ><b><i class='fa fa-edit'></i> Modificar</a></b></li>" +
                                        "<li><a class='dropdown-item' onclick='cerrarCaja("+data.id+")' title='Cerrar Caja'><b><i class='fa fa-minus-square'></i> Cerrar Caja</a></b></li>" +
                                        "</ul></div>"
                            }else{
                                return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +

                                    "<li><a class='dropdown-item' onclick='obtenerData("+data.id+")' title='Modificar' ><b><i class='fa fa-edit'></i> Modificar</a></b></li>" +
                                    "<li><a class='dropdown-item' onclick='eliminar("+data.id+")' title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                                    "<li class='dropdown-divider'></li>" +
                                    "<li><a class='dropdown-item' onclick='cerrarCaja("+data.id+")' title='Eliminar'><b><i class='fa fa-minus-square'></i> Cerrar Caja</a></b></li>" +
                                    "</ul></div>"
                            }


                        
                        
                        }else{
                            return '-'
                        }
                    }
            }

            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [[ 0, "desc" ]],

           

        });

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


    function obtenerData($id) {
        var table = $('.dataTables-cajas').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                $('#caja_id_editar').val(value.id);
                $('#empleado_id_2_editar').val(value.empleado_id);
                $('#saldo_inicial_editar').val(value.saldo_inicial);
                $('#num_referencia_editar').val(value.num_referencia);
            }  
        });

        var id = $('#empleado_id_2_editar').val();
        $.get("{{route('pos.caja.getEmployee')}}", function (data) {
            
            if(data.length > 0){
                
                var select = '<option value="" selected disabled >SELECCIONAR</option>'
                for (var i = 0; i < data.length; i++)
                    if (data[i].id == id) {
                        select += '<option value="' + data[i].id + '" selected >' + data[i].apellido_paterno+' '+data[i].apellido_materno+' '+data[i].nombres + '</option>';
                    }else{
                        select += '<option value="' + data[i].id + '">' + data[i].apellido_paterno+' '+data[i].apellido_materno+' '+data[i].nombres + '</option>';
                    }
    

            }else{
                toastr.error('Empleados no registrados.','Error');
            }

            $("#empleado_id_editar").html(select);
            $("#empleado_id_editar").val(id).trigger("change");

        });

        $('#modal_editar_caja').modal('show');

        
    }

    //Old Modal Editar
    @if ($errors->has('empleado_id_editar')  ||  $errors->has('saldo_inicial_editar') )
        $('#modal_editar_caja').modal({ show: true });
    @endif

    function limpiarError() {
        $('#num_referencia_editar').removeClass( "is-invalid" )
        $('#error-num_referencia-editar').text('')

        $('#saldo_inicial_editar').removeClass( "is-invalid" )
        $('#error-saldo_inicial-editar').text('')
    }

    $('#modal_editar_caja').on('hidden.bs.modal', function(e) { 
        limpiarError() 
    });


    function guardarError() {
        $('#num_referencia').removeClass( "is-invalid" )
        $('#error-num_referencia-guardar').text('')

        $('#saldo_inicial').removeClass( "is-invalid" )
        $('#error-saldo_inicial-guardar').text('')
    }

    $('#modal_crear_caja').on('hidden.bs.modal', function(e) { 
        guardarError()
        $('#num_referencia').val('')
        $('#saldo_inicial').val('')

    });

    function eliminar(id) {
        
        Swal.fire({
            title: 'Opción Eliminar',
            text: "¿Seguro que desea eliminar registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                //Ruta Eliminar
                var url_eliminar = '{{ route("pos.caja.destroy", ":id")}}';
                url_eliminar = url_eliminar.replace(':id',id);
                $(location).attr('href',url_eliminar);

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

    function cerrarCaja(id) {
        
        Swal.fire({
            title: 'Opción Cerrar Caja',
            text: "¿Seguro que desea Cerrar caja?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                //Ruta Eliminar
                var url_eliminar = '{{ route("pos.caja.cerrar", ":id")}}';
                url_eliminar = url_eliminar.replace(':id',id);
                $(location).attr('href',url_eliminar);

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

    $('#editar_caja').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
            
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Modificar',
            text: "¿Seguro que desea modificar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                    this.submit();
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
    })

    $('#crear_caja_chica').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Guardar',
            text: "¿Seguro que desea guardar cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                    this.submit();
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
    })



</script>
@endpush