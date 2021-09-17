@extends('layout') @section('content')

@section('compras-active', 'active')
@section('orden-compra-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO PAGO DE LA ORDEN DE COMPRA #{{$orden->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.orden.index')}}">Ordenes de Compra</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.pago.index', $orden->id)}}">Pagos</a>
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
                        <form action="{{route('compras.pago.store')}}" id="enviar_pago" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <h4><b>Orden de Compra #{{$orden->id}}</b></h4>
                                <p>Datos de la orden de compra:</p>
                            </div> 
                            <div class="row">
                            
                                <div class="col-md-6 b-r">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Fecha de Emisión: </strong></label>
                                            <p>{{ Carbon\Carbon::parse($orden->fecha_emision)->format('d/m/y') }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label><strong>Fecha de Entrega: </strong></label>
                                            <p>{{ Carbon\Carbon::parse($orden->fecha_entrega)->format('d/m/y') }}</p>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Moneda: </strong></label>
                                            <p>{{ $orden->moneda }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Monto: </strong></label>
                                            <p>{{simbolo_monedas($orden->moneda).' '.$monto}}</p>
                                        </div>


                                        
                                    </div>



                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Empresa: </strong></label>
                                        <p>{{$orden->empresa->razon_social}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Proveedor: </strong></label>
                                        <p>{{$orden->proveedor->descripcion}}</p>
                                    </div>
                                </div>
                            
                            </div>
                            <hr>
    
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">
                                            <li title="Datos del Proveedor" id="proveedor_link"><a class="nav-link active"
                                                    data-toggle="tab" href="#tab-1" ><i
                                                        class="fa fa-check-square"></i> Proveedor</a></li>
                                            <li title="Datos de la Empresa"><a class="nav-link" data-toggle="tab"
                                                    href="#tab-2" id="empresa_link"> <i class="fa fa-building"></i> Empresa</a></li>
                                            <li title="Datos de Pago"><a class="nav-link" data-toggle="tab"
                                                    href="#tab-3" id="pago_link"> <i class="fa fa-money"></i> Pago</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tab-1" class="tab-pane active">
                                                <div class="panel-body">
                                                    <h4><b>Proveedor</b></h4>
                                                    <p>Datos del proveedor:</p>

                                                    <div class="row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    @if ($orden->proveedor->ruc)
                                                                        <div class="form-group" >
                                                                            <label class="col-form-label"><b>RUC:</b></label>
                                                                            <p>{{$orden->proveedor->ruc}}</p>
                                                                        </div>

                                                                    @else
                                                                        <div class="form-group" >
                                                                            <label class="col-form-label"><b>DNI:</b></label>
                                                                            <p>{{$orden->proveedor->dni}}</p>
                                                                        </div>
                                                                    @endif
                                                                
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="col-form-label"><b>Descripción:</b></label>
                                                                    <p>{{$orden->proveedor->descripcion}}</p>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-form-label"><b>Dirección:</b></label>
                                                                <p>{{$orden->proveedor->direccion}}</p>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="col-form-label"><b>Teléfono:</b></label>
                                                                    <p>{{$orden->proveedor->telefono}}</p>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="col-form-label"><b>Correo electrónico:</b></label>
                                                                    <p>{{$orden->proveedor->correo}}</p>
                                                                </div>
                                                            </div>


                                                        
                                                        </div>
                                                    
                                                    </div>
                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4 class=""><b>Entidad Financiera</b></h4>
                                                            <p>Seleccionar entidad financiera del proveedor a pagar:</p>
                                                        </div>
                                                    </div>

                                                   

                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table dataTables-bancos table-striped table-bordered table-hover"
                                                            style="text-transform:uppercase" id="table-bancos">
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
                                                    
                                                            <input type="hidden" name="id_orden" id="id_orden" value="{{$orden->id}}">
                                                            <input type="hidden" name="id_entidad" id="id_entidad" value="{{old('id_entidad')}}">
                                                            <input type="hidden" name="moneda_proveedor_pago" id="moneda_proveedor_pago" value="{{old('moneda_proveedor_pago')}}">
                                                            <div class="col-md-3">

                                                                <label class="col-form-label">Descripción</label>
                                                                <input type="text" id="descripcion" class="form-control" disabled>
                                                                
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label class="col-form-label">Moneda</label>
                                                                <input type="text" id="moneda" class="form-control" disabled>

                                                            </div>

                                                            <div class="col-md-3">

                                                                <label class="col-form-label">N° Cuenta</label>
                                                                <input type="text" id="cuenta" class="form-control" disabled>

                                                            </div>
                                                            
                                                            <div class="col-md-3">

                                                                <label class="col-form-label">N° CCI</label>
                                                                <input type="text" id="cci" class="form-control" disabled>

                                                            </div>
                                                        
                                                        
                                                    </div>






                                                </div>
                                            </div>

                                            <div id="tab-2" class="tab-pane">
                                                <div class="panel-body">
                                                    <h4><b>Empresa</b></h4>
                                                    <p>Datos de la empresa:</p>

                                                    <div class="row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    
                                                                    <div class="form-group" >
                                                                        <label class="col-form-label"><b>RUC:</b></label>
                                                                        <p>{{$orden->empresa->ruc}}</p>
                                                                    </div>
                                                                
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                    <label class="col-form-label"><b>Razón Social:</b></label>
                                                                    <p>{{$orden->empresa->razon_social}}</p>
                                                            </div>

                                                            <div class="form-group">
                                                                    <label class="col-form-label"><b>Razón Social Abreviada:</b></label>
                                                                    <p>{{$orden->empresa->razon_social_abreviada}}</p>
                                                            </div>




                                                        </div>
                                                        <div class="col-md-6">
                                                            
                                                            <div class="form-group">
                                                                <label class="col-form-label"><b>Dirección Fiscal:</b></label>
                                                                <p>{{$orden->empresa->direccion_fiscal}}</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label"><b>Dirección de Planta:</b></label>
                                                                <p>{{$orden->empresa->direccion_llegada}}</p>
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

                                            <div id="tab-3" class="tab-pane">
                                                <div class="panel-body">

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
                                                                            <div class="col-md-6">
                                                                                <h4 class="">Monto de la Orden</h4>
                                                                                <p class="text-navy"><b>
                                                                                    @foreach ($monedas as $moneda)
                                                                                        @if ($moneda->descripcion == $orden->moneda)
                                                                                            {{$moneda->simbolo}}
                                                                                        @endif
                                                                                    @endforeach
                                                                                {{$monto}}</b></p>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <h4 class="">Tipo de Cambio (S/.)</h4>
                                                                                <p class="text-navy"><b>
                                                                                @if($orden->tipo_cambio)
                                                                                    {{$orden->tipo_cambio}}
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                                
                                                                                
                                                                                </b></p>
                                                                            </div>
                                                                            

                                                                        </div>

                                                                    
                                                                    
                                                                    
                                                                    </div>

                                                                    <div class="col-md-6 text-left">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <h4 class="">Monto Restante  (Equivalente)</h4>
                                                                                <p class="text-navy"><b><span id="simbolo_equivalente"></span> <span id="monto_equivalente"></span></b></p>
                                                                            </div>

                                                                        </div>
                                                                        

                                                                    </div>


                                                                </div>
                                                                <hr>
                                                                <div class="row">

                                                                    <div class="col-md-6 text-left b-r">
                                                                        <h4>Empresa</h4>
                                                                        <p>Cuenta origen del Pago:</p>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label class="col-form-label">Descripción</label>
                                                                                <input type="text" id="descripcion_empresa_detalle" class="form-control" disabled>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="col-form-label">Moneda</label>
                                                                                <input type="text" id="moneda_empresa_detalle" class="form-control" name="moneda_empresa" disabled>
                                                                            </div>
                                                                            
                                                                        </div>

                                                                        <div class="row">
                                                
                                                                            <div class="col-md-6">
                                                                                <label class="col-form-label">N° Cuenta</label>
                                                                                <input type="text" id="cuenta_empresa_detalle" class="form-control" disabled>

                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">

                                                                                <label class="col-form-label">N° CCI</label>
                                                                                <input type="text" id="cci_empresa_detalle" class="form-control" disabled>

                                                                            </div>
                                                                        
                                                                        
                                                                        </div>

                                                                        <hr>
                                                                        <table class="table table-bordered m-t">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="2" class="text-center">MONEDA</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><b>ORDEN DE COMPRA</b></td>
                                                                                    <td class="text-center"><span  id="moneda_orden_compra"></span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><b>CUENTA DE ORIGEN (EMPRESA)</b></td>
                                                                                    <td class="text-center" style="width:40%"><span id="moneda_cuenta_origen"></span></td>
                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                        <div class="row form-group" id="campo_tipo_cambio_dia"><label class="col-lg-7 col-form-label text-right"><b>TIPO DE CAMBIO DEL DIA (<span id="simbolo_orden"></span> - <span id="simbolo_proveedor_2"></span>):</b></label>

                                                                            <div class="col-lg-5"><input type="text" placeholder="0.00" class="form-control text-center" name="tc_dia" id="tc_dia"> 
                                                                            </div>
                                                                        </div>
                                                                                                                

                                                                    </div>
                                                                    <div class="col-md-6 text-left">
                                                                        <h4>Proveedor</h4>
                                                                        <p>Cuenta destino del Pago:</p>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label class="col-form-label">Descripción</label>
                                                                                <input type="text" id="descripcion_detalle" class="form-control" disabled>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="col-form-label">Moneda</label>
                                                                                <input type="text" id="moneda_detalle" name="moneda_proveedor" class="form-control" disabled>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">

                                                                                <label class="col-form-label">N° Cuenta</label>
                                                                                <input type="text" id="cuenta_detalle" class="form-control" disabled>

                                                                            </div>

                                                                            <div class="col-md-6">

                                                                                <label class="col-form-label">N° CCI</label>
                                                                                <input type="text" id="cci_detalle" class="form-control" disabled>

                                                                            </div>
                                                                        </div>

                                                                        <hr>
                                                                        <table class="table table-bordered m-t">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="2" class="text-center">MONEDA</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><b>CUENTA DE ORIGEN (EMPRESA)</b></td>
                                                                                    <td class="text-center"><span  id="moneda_cuenta_origen_empresa"></span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><b>CUENTA DE DESTINO (PROVEEDOR)</b></td>
                                                                                    <td class="text-center" style="width:40%"><span id="moneda_cuenta_destino"></span></td>
                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                        <div class="row form-group" id="campo_tipo_cambio_banco"><label class="col-lg-7 col-form-label text-right"><b>TIPO DE CAMBIO DEL BANCO (<span id="simbolo_empresa"></span> - <span id="simbolo_proveedor"></span>) :</b></label>

                                                                            <div class="col-lg-5"><input type="text" placeholder="0.00" class="form-control text-center" name="tc_empresa_proveedor" id="tc_empresa_proveedor"> 
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
                                                                            <label class="" id="requerido_tipo_cambio_label">Tipo de Cambio:</label>
                                                                            <input type="text" id="tipo_cambio" name="tipo_cambio" class="form-control {{ $errors->has('tipo_cambio') ? ' is-invalid' : '' }}" value="{{old('tipo_cambio')}}" disabled placeholder="0.00">                                                                            

                                                                        </div>

                                                                        
                                                                        <input type="hidden" name="moneda" value="{{$orden->moneda}}">


                                                                    </div>

                                                                    <div class="form-group row">

                                                                        <div class="col-lg-6 col-xs-12" id="">
                                                                                
                                                                                <label class="required" style="text-transform:none">Monto en 
                                                                                <span id="simbolo_monto_empresa"></span>:</label>
                                                                                <input type="text" id="monto" name="monto" class="form-control {{ $errors->has('monto') ? ' is-invalid' : '' }}" value="{{old('monto')}}" required placeholder="0.00" disabled>
                                                                                @if ($errors->has('monto'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('monto') }}</strong>
                                                                                </span>
                                                                                @endif

                                                                        </div>


                                                                       

                                                                        <div class="col-lg-6 col-xs-12" id="requerido_cambio">
                                                                                <label class="required" id="requerido_tipo_cambio_label">Cambio en <span id="tipo_cambio_destino"></span>:</label>
                                                                                <input type="text" id="cambio" name="cambio" class="form-control {{ $errors->has('tipo_cambio') ? ' is-invalid' : '' }}" value="{{old('cambio')}}"  placeholder="0.00"required disabled>
                                                                                @if ($errors->has('cambio'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('cambio') }}</strong>
                                                                                </span>
                                                                                @endif

                                                                        </div>
                                                                        

                                                                    </div>

                                                                    <div id="cambio_soles">
                                                                        <hr>
                                                                        <p>Monto desembolsado en Soles (S/.)</p>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label class="" >Monto <span id="tipo_cambio_destino"></span>:</label>
                                                                                <input type="text" id="monto_soles_tipo" name="monto_soles_tipo" class="form-control {{ $errors->has('monto_soles_tipo') ? ' is-invalid' : '' }}" value="{{old('monto_soles_tipo')}}"  placeholder="0.00"  disabled>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label class="" id="">Tipo de Cambio :</label>
                                                                                    <input type="text" id="tipo_cambio_soles" name="tipo_cambio_soles" class="form-control {{ $errors->has('tipo_cambio_soles') ? ' is-invalid' : '' }}" value="{{old('tipo_cambio_soles')}}"  placeholder="0.00">
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <label class="" id="">Monto en Soles <span id="tipo_cambio_destino"></span>:</label>
                                                                                    <input type="text" id="monto_soles" name="monto_soles" class="form-control {{ $errors->has('monto_soles') ? ' is-invalid' : '' }}" value="{{old('monto_soles')}}" disabled  placeholder="0.00">
                                                                            </div>
                                                                        
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <div class="col-md-12">
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
                                                        <a href="{{route('compras.pago.index', $orden->id)}}" id="btn_cancelar"
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

$('#cambio').keyup(function() {
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

function registrosBancos() {
    var table = $('.dataTables-bancos').DataTable();
    var registros = table.rows().data().length;
    return registros
}

function registrosBancosempresa() {
    var table = $('.dataTables-bancos-empresa').DataTable();
    var registros = table.rows().data().length;
    return registros
}


$(document).ready(function() {

    // DataTables
    $('.dataTables-bancos').DataTable({
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
            $(row).addClass('fila_entidad');
            $(row).attr('data-href', "");
        },

    });

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
    obtenerTabla()
    obtenerEmpresa()
    cambiarMonto()

    var registros = registrosBancos() 
    if (registros == '0') {
        toastr.error("Proveedor sin entidades financieras", 'Error');     
    }

    var empresas = registrosBancosempresa() 
    if (empresas == '0') {
        toastr.error("Empresa sin entidades financieras", 'Error');     
    }

    var table = $('.dataTables-bancos').DataTable();
    $('.dataTables-bancos tbody').on('click', 'tr', function() {

        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    
    });

    var table_empresa = $('.dataTables-bancos-empresa').DataTable();
    $('.dataTables-bancos-empresa tbody').on('click', 'tr', function() {

        table_empresa.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        
    });

    $('.dataTables-bancos').on('click', 'tbody td' , function() {
        //Limpia datos de pagos
        limpiarCampos()
        var data = table.row(this).data();
        $('#id_entidad').val(data[0])
        $('#descripcion').val(data[1])
        $('#moneda').val(data[2])
        $('#moneda_proveedor_pago').val(data[2])
        $('#cuenta').val(data[3])
        $('#cci').val(data[4])
        //Detalle
        $('#descripcion_detalle').val(data[1])
        $('#moneda_detalle').val(data[2])
        $('#cuenta_detalle').val(data[3])
        $('#cci_detalle').val(data[4])

        //CONVERSIONES TIPO DE CAMBIO MONEDA (EMPRESA)
        $('#moneda_cuenta_destino').text(data[2])

        //CAMBIO DE MONEDA MONSTRAR U OCULTAR INPUT TIPO DE CAMBIO (EMPRESA - PROVEEDOR)
        if ($('#moneda_cuenta_origen_empresa').text() != data[2] ) {
            $("#campo_tipo_cambio_banco").css("display", "")
            $("tc_empresa_proveedor").val('')
            
        }else{
            $("#campo_tipo_cambio_banco").css("display", "none");
            $("tc_empresa_proveedor").val('')
        }

        //CAMBIO DE MONEDA MONSTRAR U OCULTAR INPUT TIPO DE CAMBIO DIA
        if ("{{$orden->moneda}}" == data[2] ) {
            $("#campo_tipo_cambio_dia").css("display", "none")
            $("tc_dia").val('')
            $("#monto").attr('disabled', false)
        }else{
            $("#campo_tipo_cambio_dia").css("display", "");
            $("tc_dia").val('')
            $("#monto").attr('disabled', false)
        }


        //SIMBOLO DE MONEDA EN CAMPO CAMBIO MONEDA
        $('#tipo_cambio_destino').text(simboloMoneda(data[2]))

        //SIMBOLO EN EL TIPO DE CAMBIO MONEDA (EMPRESA - PROVEEDOR)
        $('#simbolo_proveedor').text(simboloMoneda(data[2]))
        $('#simbolo_proveedor_2').text(simboloMoneda(data[2]))
        $('#simbolo_monto_proveedor_soles').text(simboloMoneda(data[2]))


        //MONTO EQUIVALENTE 
        $('#simbolo_equivalente').text(simboloMoneda("{{$orden->moneda}}"))
        $('#monto_equivalente').text("{{$monto_restante}}")
        $('#suma_monto_restante').val("{{$monto_restante}}")

        //CASO EN QUE SE DEBA PONER UN TIPO DE CAMBIO SOLES
        if (($('#moneda_cuenta_origen_empresa').text() != "SOLES")  && ($('#moneda_cuenta_destino').text() != "SOLES") ) {
            $("#cambio_soles").css("display", "")
            $('#monto_soles_tipo').val("")
            $('#tipo_cambio_soles').val("")
            $('#monto_soles').val("")
        }else{
            $("#cambio_soles").css("display", "none")
            $('#monto_soles_tipo').val("")
            $('#tipo_cambio_soles').val("")
            $('#monto_soles').val("")
        }
        

        if($('#moneda_orden_compra').text() == "SOLES"){
            $('#tipo_cambio_soles').attr('disabled',true)
        }else{
            $('#tipo_cambio_soles').attr('disabled',false)
        }




    
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
        $('#moneda_orden_compra').text("{{$orden->moneda}}")
        $('#moneda_cuenta_origen_empresa').text(data[2])


        //CAMBIO DE MONEDA MONSTRAR U OCULTAR INPUT TIPO DE CAMBIO (EMPRESA - PROVEEDOR)
        if ($('#moneda_cuenta_origen_empresa').text() != $('#moneda_cuenta_destino').text() ) {
            $("#campo_tipo_cambio_banco").css("display", "")
            $("tc_empresa_proveedor").val('')

        }else{
            $("#campo_tipo_cambio_banco").css("display", "none");
            $("tc_empresa_proveedor").val('')
        }

        //CAMBIAR SIMBOLO DE MONTO
        $('#simbolo_monto_empresa').text(simboloMoneda(data[2]))

        //SIMBOLO EN EL TIPO DE CAMBIO MONEDA (ORDEN - EMPRESA)
        $('#simbolo_orden').text(simboloMoneda("{{$orden->moneda}}"))
        $('#simbolo_empresa').text(simboloMoneda(data[2]))
        

        //MOSTRAR TIPO DE CAMBIO ORDEN - EMPRESA
        if ("{{$orden->moneda}}" != $('#moneda_empresa_detalle').val() ) {
            $("#campo_tipo_cambio_dia").css("display", "")
            $("tc_dia").val('')
        }else{
            $("#campo_tipo_cambio_dia").css("display", "none")
            $("tc_dia").val('')
        }


        //CAMBIO DE MONEDA MONSTRAR U OCULTAR INPUT TIPO DE CAMBIO DIA
        if ("{{$orden->moneda}}" == $('#moneda_cuenta_destino').text() ) {
            $("#campo_tipo_cambio_dia").css("display", "none")
            $("tc_dia").val('')
            $("#monto").attr('disabled', false)
            // $("#tc_empresa_proveedor").attr('disabled', false)
        }else{
            $("#campo_tipo_cambio_dia").css("display", "");
            $("tc_dia").val('')
            $("#monto").attr('disabled', true)
            // $("#tc_empresa_proveedor").attr('disabled', true)
        }

        //MONTO EQUIVALENTE 
        $('#simbolo_equivalente').text(simboloMoneda("{{$orden->moneda}}"))
        $('#monto_equivalente').text("{{$monto_restante}}")
    

        //CASO EN QUE SE DEBA PONER UN TIPO DE CAMBIO SOLES
        if (($('#moneda_cuenta_origen_empresa').text() != "SOLES")  && ($('#moneda_cuenta_destino').text() != "SOLES") ) {
            $("#cambio_soles").css("display", "")
            $('#monto_soles_tipo').val("")
            $('#tipo_cambio_soles').val("")
            $('#monto_oles').val("")
        }else{
            $("#cambio_soles").css("display", "none")
            $('#monto_soles_tipo').val("")
            $('#tipo_cambio_soles').val("")
            $('#monto_oles').val("")
        }

        if($('#moneda_orden_compra').text() == "SOLES"){
            $('#tipo_cambio_soles').attr('disabled',true)
        }else{
            $('#tipo_cambio_soles').attr('disabled',false)
        }

    });
    //Monto restante inicial
    $('#moneda_orden').text(simboloMoneda("{{$orden->moneda}}"))
    $('#monto_restante').text("{{$monto_restante}}")
    $('#suma_monto_restante').val("{{$monto_restante}}")
})


function cambiarMonto() {
    var val = $('#tc_dia').val()
    var monto_restante = "{{$monto_restante}}"
    if ("{{$orden->moneda}}" != $('#moneda_empresa_detalle').val() ) {
        if (val > 0) {
            
            var nuevo_restante = Number(val) * Number(monto_restante) 
            $('#moneda_orden').text(simboloMoneda($('#moneda_empresa_detalle').val()))
            //Simbolo en el campo monto
            $('#simbolo_monto_empresa').text(simboloMoneda($('#moneda_empresa_detalle').val()))
            $('#monto_restante').text((nuevo_restante).toFixed(2))
        }else{
            $('#moneda_orden').text(simboloMoneda("{{$orden->moneda}}"))
            //Simbolo en el campo monto
            $('#simbolo_monto_empresa').text(simboloMoneda("{{$orden->moneda}}"))
            $('#monto_restante').text(monto_restante)
        }
    }else{
        //Simbolo en el campo monto
        // $('#simbolo_monto_empresa').text(monto_restante)
        $('#monto_restante').text(monto_restante)
    }
    // $('#suma_monto_restante').text(monto_restante)
}

//TIPO DE CAMBIO DEL DIA
$('#tc_dia').keyup(function() {

    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);



    if (val) {
        $('#monto').attr('disabled',false)
        $("#tc_empresa_proveedor").attr('disabled', false)
    }else{
        $('#monto').attr('disabled',true)
        $('#monto').val('')

        $("#tc_empresa_proveedor").attr('disabled', true)
        $('#tc_empresa_proveedor').val('')
    }


    var cambio = ''
    if ($('#moneda_orden_compra').text() == "SOLES") {
        cambio = Number("{{$monto_restante}}") / val    
    }else{
        cambio = val * Number("{{$monto_restante}}")
    }
    

    if (cambio) {
        $('#monto_equivalente').text((cambio).toFixed(2))    
    }else{
        $('#monto_equivalente').text("{{$monto_restante}}")
    }
    
    $('#simbolo_equivalente').text(simboloMoneda($('#moneda_cuenta_destino').text()))

    //AÑADIR MONTO
    $('#suma_monto_restante').val((cambio).toFixed(2))


    if($('#cambio').val()){
        var cambio = $('#cambio').val()
        //NUEVO MONTO RESTANTE
        var min = 0
        var monto_restante
        //nuevo monto restante
        if ("{{$orden->moneda}}" != $('#moneda_detalle').val() ) {

            monto_restante = Number($('#suma_monto_restante').val())    

            if(cambio > Number(monto_restante) || cambio < min   ){
                toastr.error("El monto ingresado no está en el rango permitido del monto restante.", 'Error');
                $('#monto').val('');
                $('#cambio').val('');
                $('#monto_equivalente').text((monto_restante).toFixed(2))
            }else{
                const max = (Number(monto_restante) -  Number(cambio)).toFixed(2);
                // Nuevo monto restante
                $('#monto_equivalente').text(max)
            }


        }

    }


    if($('#moneda_orden_compra').text() == "SOLES"){
        $('#tipo_cambio_soles').val(val)
    }
    

});
//TIPO DE CAMBIO
$('#tipo_cambio_soles').keyup(function() {
 
 var val = $(this).val();
 if (isNaN(val)) {
     val = val.replace(/[^0-9\.]/g, '');
     if (val.split('.').length > 2)
         val = val.replace(/\.+$/, "");
 }
 $(this).val(val);

 var monto = $('#monto_soles_tipo').val()
 
 $('#monto_soles').val((monto*val).toFixed(2))

});
////////////////////

$('#tc_empresa_proveedor').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
    $('#tipo_cambio').val(val)
});

//Obtener el simbolo para el pago
function simboloMoneda(moneda) {
    var simbolo = ''
    @foreach($monedas as $moneda)
        if("{{$moneda->descripcion}}" == moneda){
            simbolo = "{{$moneda->simbolo}}"
        }
    @endforeach
    return simbolo
}



function obtenerTabla() {
    var t = $('.dataTables-bancos').DataTable();
    @foreach($bancos_proveedor as $ban)
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
            
                $('#cambio').attr('disabled',false)
                this.submit();               

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

$('#tc_empresa_proveedor').keyup(function() {

    
    var val = $(this).val();
    
    if ("{{$orden->moneda}}" != $('#moneda_detalle').val() ) {
        if (!$('#tc_dia').val()) {
            $('#tc_empresa_proveedor').val('')     
            toastr.error("EL tipo de cambio del dia no esta definido.", 'Error');   
        }
        
    }else{
        var monto_restante = "{{$monto_restante}}"
        //Solo se convierte el pago si es diferente la cuenta de origen con la orden
        if ("{{$orden->moneda}}" != $('#moneda_detalle').val() ) {
            if (val > 0) {
                // SIMBOLO EN EL MONTO EQUIVALENTE
                $('#moneda_orden').text(simboloMoneda($('#moneda_detalle').val()))
            }else{
                $('#moneda_orden').text(simboloMoneda("{{$orden->moneda}}"))
                $('#monto_restante').text(monto_restante)
            }
        }else{
            $('#suma_monto_restante').val(monto_restante)
        }
        var monto = $('#monto').val()
        var tipo_cambio = $('#tc_empresa_proveedor').val()
        var cambio = monto*tipo_cambio
        $('#cambio').val(cambio.toFixed(2))

        //NUEVO MONTO RESTANTE
        var min = 0
        var monto_restante
        //nuevo monto restante
        if ("{{$orden->moneda}}" != $('#moneda_detalle').val() ) {

            monto_restante = Number($('#suma_monto_restante').val())    

            if(cambio > Number(monto_restante) || cambio < min   ){
                toastr.error("El monto ingresado no está en el rango permitido del monto restante.", 'Error');
                $('#monto').val('');
                $('#cambio').val('');
                $('#monto_equivalente').text((monto_restante).toFixed(2))
                //LIMPIAR MONTO ERRADO
                $('#monto_soles').val('');
            }else{
                const max = (Number(monto_restante) -  Number(cambio)).toFixed(2);
                // Nuevo monto restante
                $('#monto_equivalente').text(max)
            }


        }else{
            monto_restante = Number($('#suma_monto_restante').val())  
            if(cambio > Number(monto_restante) || cambio < min   ){
            
                toastr.error("El monto ingresado no está en el rango permitido del monto restante.", 'Error');
                $('#monto').val('');
                $('#cambio').val('');
                $('#monto_equivalente').text((monto_restante).toFixed(2))
                //LIMPIAR MONTO ERRADO
                $('#monto_soles').val('');
            }else{
                const max = (Number(monto_restante) - Number(cambio)).toFixed(2); 
                // Nuevo monto restante
                $('#monto_equivalente').text(max)
            }




        }


    }
    
})

$('#tc_empresa_proveedor').keyup(function() {
    $('#monto').prop('disabled',false)
})

$('#monto').keyup(function() {
    
    var monto = $(this).val();
    var tipo_cambio = $('#tipo_cambio').val()
    var cambio = ""
    var error = false

    if ($('#moneda_cuenta_origen_empresa').text() == $('#moneda_cuenta_destino').text() ) {
        cambio = monto*1
        tipo_cambio = 1
    }else{
        if ($('#moneda_cuenta_origen_empresa').text() != "SOLES") {
            cambio =  monto * tipo_cambio
        }else{
            cambio =  monto / tipo_cambio
        }
        
    }

    if (!tipo_cambio) {
        toastr.error("EL tipo de cambio no esta definido.", 'Error');
        $( "#tipo_cambio" ).focus();
        $('#cambio').val('');
        $('#monto').val('');
        error = true
    }else{
        error = false
        tipo_cambio = 1
        $('#cambio').val(cambio.toFixed(2))
    }

  
    var min = 0
    var monto_restante
    //nuevo monto restante

    if ("{{$orden->moneda}}" != $('#moneda_detalle').val() ) {

        monto_restante = Number($('#suma_monto_restante').val())    

        if(cambio > Number(monto_restante) || cambio < min   ){

            if (error!=true) {
                toastr.error("El monto ingresado no está en el rango permitido del monto restante.", 'Error');
                $('#monto').val('');
                $('#cambio').val('');
                $('#monto_equivalente').text((monto_restante).toFixed(2))
                //LIMPIAR MONTO ERRADO
                $('#monto_soles').val('');
                
            }

        
        }else{
            const max = (Number(monto_restante) -  Number(cambio)).toFixed(2);
            // Nuevo monto restante
            $('#monto_equivalente').text(max)
        }


    }else{
        monto_restante = Number($('#suma_monto_restante').val())  
        
        if(cambio > Number(monto_restante) || cambio < min   ){
        
            if (error!=true) {
                toastr.error("El monto ingresado no está en el rango permitido del monto restante.", 'Error');
                $('#monto').val('');
                $('#cambio').val('');
                $('#monto_equivalente').text((monto_restante).toFixed(2))

                //LIMPIAR MONTO ERRADO
                $('#monto_soles').val('');
            }
            
            
            
        }else{
            const max = (Number(monto_restante) - Number(cambio)).toFixed(2); 
            // Nuevo monto restante
            $('#monto_equivalente').text(max)
        }




    }


    if (($('#moneda_cuenta_origen_empresa').text() != "SOLES")  && ($('#moneda_cuenta_destino').text() != "SOLES") ) {
        $('#monto_soles_tipo').val(cambio)
        var tipo  = $('#tipo_cambio_soles').val()
        $('#monto_soles').val((cambio*tipo).toFixed(2))
    }








})



function limpiarCampos() {
    //Agregar montos inicial
    
    $('#moneda_orden').text(simboloMoneda("{{$orden->moneda}}"))
    $('#monto_restante').text("{{$monto_restante}}")

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

</script>



@endpush