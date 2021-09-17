<div class="modal inmodal" id="modal_editar_caja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Caja Chica</h4>
                <small class="font-bold">Modificar Caja Chica.</small>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('pos.caja.update')}}" method="POST" id="editar_caja">
                    {{ csrf_field() }} {{method_field('PUT')}}

                   <input type="hidden" name="caja_id" id="caja_id_editar" value="{{old('caja_id')}}">
                   <input type="hidden" name="empleado_id_2_editar" id="empleado_id_2_editar" value="{{old('empleado_id_2_editar')}}">
                   
                   <div class="form-group">
                        <label class="required">Colaborador:</label> 
                        <select class="form-control  {{ $errors->has('empleado_id_editar') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('empleado_id_editar')}}" name="empleado_id_editar" id="empleado_id_editar"  required>
                            <option></option>
                        </select>

                        @if ($errors->has('empleado_id_editar'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('empleado_id_editar') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label class="required">Saldo Inicial :</label>
                            <input type="text" class="form-control {{ $errors->has('saldo_inicial_editar') ? ' is-invalid' : '' }}" id="saldo_inicial_editar" name="saldo_inicial_editar" value="{{old('saldo_inicial_editar')}}" onkeyup="return mayus(this)" required>
                            
                            @if ($errors->has('saldo_inicial_editar'))
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-saldo_inicial-guardar">{{ $errors->first('saldo_inicial_editar') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="">N° Referencia:</label>
                            <input type="text" class="form-control {{ $errors->has('num_referencia_editar') ? ' is-invalid' : '' }}" id="num_referencia_editar" name="num_referencia_editar" value="{{old('num_referencia_editar')}}" onkeyup="return mayus(this)">
                            
                            @if ($errors->has('num_referencia_editar'))
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-num_referencia-guardar">{{ $errors->first('num_referencia_editar') }}</strong>
                            </span>
                            @endif
                        </div>
                        
 
                    </div>
            </div>
                
                    <div class="modal-footer">
                        <div class="col-md-6 text-left" style="color:#fcbc6c">
                            <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        </div>
                    </div>
                
                </form>
        </div>
    </div>
</div>

@push('styles')
<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
@endpush 
@push('scripts')
<!-- Select2 -->
<script src="{{asset('Inspinia/js/plugins/select2/select2.full.min.js')}}"></script>

<script>

    //Select2
    $(".select2_form").select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: '200px',
        width: '100%',
    });
    $("#empleado_id_editar").select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: '200px',
        width: '100%',
    });



    //Input decimal
    $('#saldo_inicial_editar').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
            val = val.replace(/[^0-9\.]/g,'');
            if(val.split('.').length>2) 
                val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });

</script>

@endpush