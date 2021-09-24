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
                                <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="" class="required">Estado</label>
                                            <input type="text" name="estado" id="estado"
                                                class="form-control form-control-sm" disabled>
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
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                                    <input type="date" name="fecha" id="fecha" class="form-control">
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
                        </div>
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
@push('scripts')
    <script>
        $("#btn_guardar_detalle").click(function(e) {
            e.preventDefault();
            var pago = $("#modal_detalle #pago").val();
            var fecha = $("#modal_detalle #fecha").val();
            var cantidad = parseFloat($("#modal_detalle #cantidad").val());
            var observacion = $("#modal_detalle #observacion").val();
            var saldo = parseFloat($("#modal_detalle #saldo").val());
            var id_cuenta_cliente = $("#modal_detalle #cuenta_cliente_id").val()
            if (pago.length == 0 || fecha.length == 0 || fecha.length == 0 || cantidad.length == 0 || observacion
                .length == 0) {
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
                            toastr.error('El tipo de pago se puede hacer a varios, seleccione de nuevo')
                            enviar = false
                        }
                    }
                    if (enviar) {
                        axios.get("{{ route('cuentaCliente.detallePago') }}", {
                            params: {
                                id: id_cuenta_cliente,
                                pago: pago,
                                fecha: fecha,
                                cantidad: cantidad,
                                observacion: observacion,

                            }
                        }).then((value) => {
                            window.location.href="{{ route('cuentaCliente.index') }}"
                        }).catch((value) => {

                        })
                    }
                }
            }

        });
    </script>
@endpush