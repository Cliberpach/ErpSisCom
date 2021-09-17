@extends('layout') @section('content')
@section('compras-active', 'active')
@section('documento-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
       <h2  style="text-transform:uppercase"><b>Detalle del pago del documento de compra # {{$pago->detalle->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.documento.index')}}">Documentos de Compra</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.documentos.pago.index', $pago->pago->documento->id)}}">Pagos</a>
                
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
                                       <h2  style="text-transform:uppercase">Pago del documento de compra # {{$pago->detalle->id}}</h2>
                                    </div>
                                    <p style="text-transform:uppercase"><strong><i class="fa fa-caret-right"></i> Información general del pago:</strong></p>

                                </div>
                            </div>

                            <div class="row"  style="text-transform:uppercase">

                                <div class="col-md-6 b-r">

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>TIPO DE PAGO: </strong></label>
                                            <p>{{$pago->pago->tipo_pago}}</p>
                                        </div>

                                    </div>

                        
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                            <label><strong>Observación: </strong></label> 
                                            @if($pago->pago->observacion != "")
                                                <p>{{$pago->pago->observacion}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                       
                                    </div>

                                </div>

                            </div>

                            <div class="row"  style="text-transform:uppercase">

                                <div class="col-md-6 b-r">

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>MONEDA: </strong></label>
                                            <p>{{$pago->pago->documento->moneda}}</p>
                                        </div>

                                    </div>


                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                            <label><strong>MONTO: </strong></label> 
                                            @if($pago->detalle->monto != "")
                                                <p>{{$tipo_moneda.' '.$pago->detalle->monto}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                    
                                    </div>

                                </div>

                            </div>

                            <hr>
                        
                            <p style="text-transform:uppercase"><strong> <i class="fa fa-caret-right"></i> CAJA CHICA :</strong></p>
                            <div class="row" style="text-transform:uppercase">

                                    <div class="col-md-6 b-r">
                                        <label><strong>EMPLEADO: </strong></label>
                                        <p>{{$pago->detalle->caja->empleado->persona->apellido_paterno.' '.$pago->detalle->caja->empleado->persona->apellido_materno.' '.$pago->detalle->caja->empleado->persona->nombres}}</p>
                                    </div>

                                    <div class="col-md-6">

                                        <label><strong>ESTADO: </strong></label>
                                        <p>{{$pago->detalle->caja->estado}}</p>


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
                    <hr>
                    <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>CREADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"><dd class="mb-1">  {{ Carbon\Carbon::parse($pago->pago->created_at)->format('d/m/y - G:i:s') }}</dd> </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>ACTUALIZADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"> <dd class="mb-1">  {{ Carbon\Carbon::parse($pago->pago->updated_at)->format('d/m/y - G:i:s') }}</dd></div>
                                    </dl>

                                </div>
                    </div>
                </div>
            </div>
        </div>
@stop
