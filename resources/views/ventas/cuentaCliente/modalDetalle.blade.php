<div class="modal inmodal" id="modal_detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">

                <span class="text-uppercase font-weight-bold"> Detalle de Cuenta Cliente</span>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="cuenta_cliente_id" id="cuenta_cliente_id">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="required">Cliente</label>
                                            <input type="text" name="cliente" id="cliente"
                                                class="form-control form-control-sm" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="required">Numero</label>
                                            <input type="text" name="numero" id="numero"
                                                class="form-control form-control-sm" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="required">Monto</label>
                                            <input type="text" name="monto" id="monto" class="form-control form-control-sm"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="required">Saldo</label>
                                            <input type="text" name="saldo" id="saldo" class="form-control form-control-sm"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="" class="required">Estado</label>
                                            <input type="text" name="estado" id="estado"
                                                class="form-control form-control-sm" disabled>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                             <a class="btn btn-danger" id="btn-detalle" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table dataTables-detalle table-striped table-bordered table-hover"
                                    style="text-transform:uppercase">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Observacion</th>
                                            <th class="text-center">Monto</th>
                                            <th class="text-center">Im&aacute;gen</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form id="frmDetalle" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="required">Pago</label>
                                        <select name="pago" id="pago" class="form-control select2_form" required>
                                            <option value="A CUENTA">A CUENTA</option>
                                            <option value="TODO">TODO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Fecha</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{$fecha_hoy}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">Cantidad</label>
                                        <input type="number" name="cantidad" id="cantidad" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="required">Observacion</label>
                                        <textarea name="observacion" id="observacion" cols="30" rows="3"
                                        class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label id="imagen_label">Imagen:</label>

                                        <div class="custom-file">
                                            <input id="imagen" type="file" name="imagen" class="custom-file-input"   accept="image/*">

                                            <label for="imagen" id="imagen_txt"
                                                class="custom-file-label selected">Seleccionar</label>

                                            <div class="invalid-feedback"><b><span id="error-imagen"></span></b></div>

                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        <div class="col-6 align-content-center">
                                            <div class="row justify-content-end">
                                                <a href="javascript:void(0);" id="limpiar_imagen">
                                                    <span class="badge badge-danger">x</span>
                                                </a>
                                            </div>
                                            <div class="row justify-content-center">
                                                <p>
                                                    <img class="imagen" src="{{asset('img/default.png')}}"
                                                        alt="">
                                                    <input id="url_imagen" name="url_imagen" type="hidden" value="">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_guardar_detalle"><i
                            class="fa fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                            class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        .imagen {
            width: 200px;
            height: 200px;
            border-radius: 10%;
        }

    </style>
@endpush
@push('scripts')
    <script>
        $("#btn_guardar_detalle").click(function(e) {
            e.preventDefault();
            var pago = $("#modal_detalle #pago").val();
            var fecha = $("#modal_detalle #fecha").val();
            var cantidad = parseFloat($("#modal_detalle #cantidad").val());
            var observacion = $("#modal_detalle #observacion").val();
            var saldo = parseFloat($("#modal_detalle #saldo").val());
            var id_cuenta_cliente = $("#modal_detalle #cuenta_cliente_id").val();

            if (pago.length == 0 || fecha.length == 0 || fecha.length == 0 || cantidad.length == 0 || observacion.length == 0) {
                toastr.error('Ingrese todo los datos');
            } else {
                if (saldo == 0) {
                    toastr.error("Ya esta cancelado");
                } else {
                    var enviar = true;
                    if (pago == "TODO") {
                        console.log(cantidad, saldo)
                        if (cantidad < saldo || cantidad == saldo) {
                            toastr.error("El monto a pagar, no cumple para el pago a varias cuentas")
                            enviar = false
                        }
                    } else {
                        if (cantidad > saldo) {
                            toastr.error('El tipo de pago se puede hacer a varios, seleccione de nuevo');
                            enviar = false;
                        }
                    }
                    if (enviar) {

                        $('#frmDetalle').submit();
                    }
                }
            }

        });

        /* Limpiar imagen */
        $('#limpiar_imagen').click(function() {
            $('.imagen').attr("src", "{{asset('img/default.png')}}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#imagen').val('')
        })

        $('#imagen').on('change', function() {
            var fileInput = document.getElementById('imagen');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".imagen");

            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('imagen');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.imagen').attr("src", "{{asset('img/default.png')}}")
            }
        });
    </script>
@endpush
