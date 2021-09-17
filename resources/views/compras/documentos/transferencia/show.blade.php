@extends('layout') @section('content')
@section('compras-active', 'active')
@section('documento-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
       <h2  style="text-transform:uppercase"><b>Detalle de la transferencia del documento de compra # {{$documento->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.documento.index')}}">Documentos de Compra</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.documentos.transferencia.pago.index', $documento->id)}}">Pagos</a>
                
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                       <h2  style="text-transform:uppercase">Pago del documento de compra # {{$documento->id}}</h2>
                                    </div>
                                    <p style="text-transform:uppercase"><strong><i class="fa fa-caret-right"></i> Información general del pago:</strong></p>

                                </div>
                            </div>

                            <div class="row"  style="text-transform:uppercase">

                                <div class="col-md-6 b-r">

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Fecha de Pago: </strong></label>
                                            <p class="text-navy">{{ Carbon\Carbon::parse($pago[0]->fecha_pago)->format('d/m/y') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Monto: </strong></label>
                                            @if($pago[0]->tipo_moneda == "SOLES" && $pago[0]->moneda_empresa == "SOLES" &&  $pago[0]->moneda == "SOLES")
                                                <p>{{simbolo_monedas($pago[0]->tipo_moneda).' '.$pago[0]->monto}}</p>
                                            @else
                                                @if($pago[0]->moneda_empresa == "SOLES" )
                                                    <p>S/. {{($pago[0]->monto)}}</p>
                                                @else
                                                    <p>{{simbolo_monedas($pago[0]->moneda_empresa).' '.($pago[0]->monto)}}</p>
                                                @endif
                                            @endif
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Moneda: </strong></label> 
                                            @if($pago[0]->moneda != "")
                                                <p>{{$pago[0]->moneda}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>

                        
                                </div>

                                <div class="col-md-6">

                                    
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Tipo de Cambio del dia: </strong></label> 
                                            @if($pago[0]->tc_dia != "")
                                                <p>{{$pago[0]->tc_dia}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Tipo de Cambio del banco: </strong></label> 
                                            @if($pago[0]->tc_banco != "")
                                                <p>{{$pago[0]->tc_banco}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <label><strong>Observación: </strong></label> 
                                            @if($pago[0]->observacion != "")
                                                <p>{{$pago[0]->observacion}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                       
                                    </div>

                                </div>


       
                                
                            </div>

                            <hr>

                           
                            <div class="row" style="text-transform:uppercase">

                                    <div class="col-md-6 b-r">
                                        <p style="text-transform:uppercase"><strong> <i class="fa fa-caret-right"></i> Entidad Financiera del Proveedor :</strong></p>
                                        <div class="form-group">
                                            <label><strong>Descripcion: </strong></label>
                                            <p >{{$pago[0]->descripcion}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Moneda: </strong></label>
                                            <p >{{$pago[0]->tipo_moneda}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>N° Cuenta: </strong></label>
                                            <p >{{$pago[0]->num_cuenta}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>N° CCI: </strong></label>
                                            <p >{{$pago[0]->cci}}</p>
                                            
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                    <p style="text-transform:uppercase"><strong> <i class="fa fa-caret-right"></i> Entidad Financiera de la Empresa :</strong></p>
                                        <div class="form-group">
                                            <label><strong>Descripcion: </strong></label>
                                            <p >{{$pago[0]->descripcion_empresa}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Moneda: </strong></label>
                                            <p >{{$pago[0]->moneda_empresa}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>N° Cuenta: </strong></label>
                                            <p >{{$pago[0]->cuenta_empresa}}</p>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><strong>N° CCI: </strong></label>
                                            <p >{{$pago[0]->cci_empresa}}</p>
                                            
                                        </div>

                                    </div>

                            </div>
                            <hr>
                        
                            <p style="text-transform:uppercase"><strong> <i class="fa fa-caret-right"></i> Proveedor :</strong></p>
                            <div class="row" style="text-transform:uppercase">

                                    <div class="col-md-6 b-r">

                                        @if($documento->proveedor->ruc)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><strong>Ruc: </strong></label>
                                                <p class="text-navy">{{$documento->proveedor->ruc}}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label><strong>Tipo: </strong></label>
                                                <p class="">{{$documento->proveedor->tipo_persona}}</p>
                                            </div>

                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><strong>Dni: </strong></label>
                                                <p class="text-navy">{{$documento->proveedor->dni}}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label><strong>Tipo: </strong></label>
                                                <p class="">{{$documento->proveedor->tipo_persona}}</p>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label><strong>Proveedor: </strong></label>
                                            <p >{{$documento->proveedor->descripcion}}</p>
                                            
                                        </div>


                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><strong>Telefono: </strong></label>
                                                @if($documento->proveedor->telefono != "")
                                                    <p>{{$documento->proveedor->telefono}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>Celular: </strong></label>
                                                @if($documento->proveedor->celular != "")
                                                    <p>{{$documento->proveedor->celular}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>
                                            
                                            
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Direccion: </strong></label>
                                            <p>{{$documento->proveedor->direccion}}</p>
                                            
                                        </div>


                                    </div>

                            </div>
                            <hr>
                            <p style="text-transform:uppercase"><strong> <i class="fa fa-caret-right"></i> Empresa :</strong></p>
                            <div class="row" style="text-transform:uppercase">

                                    <div class="col-md-6 b-r">

                                        
                                        <div class="form-group">
                                            <label><strong>Ruc: </strong></label>
                                            <p class="text-navy">{{$documento->empresa->ruc}}</p>
                                        </div>


                                        <div class="form-group">
                                            <label><strong>Empresa: </strong></label>
                                            <p >{{$documento->empresa->razon_social}}</p>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Empresa: </strong></label>
                                            <p >{{$documento->empresa->razon_social_abreviada}}</p>
                                            
                                        </div>


                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Dirección Fiscal: </strong></label>
                                            <p >{{$documento->empresa->direccion_fiscal}}</p>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Direccion: </strong></label>
                                            <p>{{$documento->empresa->direccion_llegada}}</p>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><strong>Telefono: </strong></label>
                                                @if($documento->empresa->telefono != "")
                                                    <p>{{$documento->empresa->telefono}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>Celular: </strong></label>
                                                @if($documento->empresa->celular != "")
                                                    <p>{{$documento->empresa->celular}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>
                                            
                                            
                                        </div>




                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager"  style="text-transform:uppercase">
                    <h4>Pago</h4>
                    <p><b>Información adicional:</b><p>
                    <div class="text-center">
                        <i class="fa fa-money big-icon"></i>


                    <div>
                    <div class="text-center m-t-md">
                        @if($pago[0]->ruta_archivo)
                            <a title="{{$pago[0]->nombre_archivo}}" download="{{$pago[0]->nombre_archivo}}" href="{{Storage::url($pago[0]->ruta_archivo)}}" class="btn btn-xs btn-block btn-primary"><i class="fa fa-download"></i> Descargar Archivo</a>
                        @endif

                    
                    </div>
                    <hr>
                    <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>CREADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"><dd class="mb-1">  {{ Carbon\Carbon::parse($pago[0]->created_at)->format('d/m/y - G:i:s') }}</dd> </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>ACTUALIZADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"> <dd class="mb-1">  {{ Carbon\Carbon::parse($pago[0]->updated_at)->format('d/m/y - G:i:s') }}</dd></div>
                                    </dl>

                                </div>
                    </div>
                </div>
            </div>
        </div>
@stop
