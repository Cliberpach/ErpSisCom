@extends('layout') @section('content')

@section('ventas-active', 'active')
@section('documentos-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
       <h2  style="text-transform:uppercase"><b>Detalle del pago del documento de venta # {{$pago->pago->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documento.index')}}">Documentos de Venta</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.documentos.pago.index', $pago->pago->documento_id)}}">Pagos</a>
                
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
                                       <h2  style="text-transform:uppercase">Pago del documento de venta # {{$pago->pago->id}}</h2>
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


                                <div class="col-md-6">

                                    <div class="form-group">
                                            <label><strong>MONTO: </strong></label> 
                                            @if($pago->pago->total != "")
                                                <p>{{'S/. '.$pago->pago->total}}</p>
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
                                        <p>{{$pago->caja->caja->empleado->persona->apellido_paterno.' '.$pago->caja->caja->empleado->persona->apellido_materno.' '.$pago->caja->caja->empleado->persona->nombres}}</p>
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
