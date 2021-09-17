<div class="modal inmodal" id="modal_editar_orden" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiar()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Pago</h4>
                <small class="font-bold">Modificar Pago.</small>
            </div>
            <div class="modal-body">
                <form role="form" id="">
                    <input type="hidden" id="editar_id_articulo">
                    <input type="hidden" id="indice">
                    <div class="form-group">
                        <label class="required">Caja</label>
                        <select class="select2_form form-control" style="text-transform: uppercase; width:100%"
                            name="caja_id_editar" id="caja_id_editar" disabled>
                            <option></option>
                            @foreach ($cajas as $caja)
                            <option value="{{$caja->id}}" >{{$caja->id.' - '.$caja->empleado->persona->apellido_paterno.' '.$caja->empleado->persona->apellido_materno.' '.$caja->empleado->persona->nombres}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <input type="hidden" id="max_input_editar" >
                    <div class="form-group row">

                        <div class="col-md-6">
                            <label class="required">Monto</label>
                            <input type="text" id="monto_editar" name="monto_editar" class="form-control">
                            <div class="invalid-feedback"><b><span id="error-monto_editar"></span></b></div>
                        </div>



                    </div>



            </div>


            <div class="modal-footer">
                <div class="col-md-6 text-left" style="color:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary btn-sm editarRegistro" style="color:white"><i class="fa fa-save"></i>
                        Guardar</a>
                    <button type="button" onclick="limpiar()" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                            class="fa fa-times"></i>
                        Cancelar</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
//Validacion al ingresar tablas
$(".editarRegistro").click(function() {
    // limpiarErrores()
    var enviar = false;

    if ($('#monto_editar').val() == '') {
        toastr.error('Ingrese el monto.', 'Error');
        enviar = true;

        $("#monto_editar").addClass("is-invalid");
        $('#error-monto_editar').text('El campo Monto es obligatorio')
    }

    if (enviar != true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
                container: 'my-swal',
            },
            buttonsStyling: false
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Modificar',
            text: "¿Seguro que desea modficar el pago?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                actualizarTabla($('#indice').val())
                sumaTotal()
                limpiar()

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

function actualizarTabla(i) {
    var table = $('.dataTables-caja').DataTable();
    table.row(i).remove().draw();
    var nombre_completo = obtenerNombreCompleto($('#caja_id_editar').val())
    var detalle = {
        caja_id: $('#caja_id_editar').val(),
        nombre_completo: nombre_completo,
        monto: $('#monto_editar').val(),
    }
    agregarTabla(detalle);

}


function limpiar() {


    $("#monto_editar").removeClass("is-invalid");
    $('#error-monto_editar').text('')

    $('#modal_editar_orden').modal('hide');
}

$('#modal_editar_orden').on('hidden.bs.modal', function(e) {
    limpiar()
});



$('#monto_editar').keyup(function() {   
    
    var monto = $(this).val();

    if (isNaN(monto)) {
     monto = monto.replace(/[^0-9\.]/g, '');
     if (monto.split('.').length > 2)
         monto = monto.replace(/\.+$/, "");
    }
    $(this).val(monto);

    // if ( $('#max_input_editar').val() != '') {
       

    //     var max = $('#max_input_editar').val();
    //     var min = 0
    //     if(monto > Number(max) || Number(monto) < min ){           
    //         toastr.error("El monto Máximo de la caja chica es: "+max, 'Error');
    //         $('#monto_editar').val(max);
    //     } 

    // }

});
</script>
@endpush