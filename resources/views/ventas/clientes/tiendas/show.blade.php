@extends('layout') @section('content')
@section('ventas-active', 'active')
@section('clientes-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
       <h2  style="text-transform:uppercase"><b>Detalle de la tienda: {{$tienda->nombre}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('ventas.cliente.index')}}">Clientes</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('clientes.tienda.index',$tienda->cliente->id)}}">Tiendas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row" style="text-transform:uppercase">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                        <a href="{{route('clientes.tienda.edit',$tienda->cliente_id)}}" class="btn btn-warning btn-xs float-right"><i class='fa fa-edit'></i>Editar Tienda</a>
                                       <h2  style="text-transform:uppercase">{{$tienda->nombre}}</h2>
                                    </div>
                                    <p  onkeyup="return mayus(this)"><strong><i class="fa fa-caret-right"></i> Información general de la tienda:</strong></p>

                                </div>
                            </div>

                            <div class="row"  onkeyup="return mayus(this)">

                                <div class="col-md-6 b-r">

                                    <div class="form-group">
                                        <label><strong>Nombre: </strong></label>
                                        <p class="">{{$tienda->nombre}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Tipo de Tienda: </strong></label>
                                        <p >{{$tienda->tipo_tienda}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Tipo de Negocio: </strong></label>
                                        <p >{{$tienda->tipo_negocio}}</p>
                                    </div>

    
                        
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong>Telefono: </strong></label> 
                                            @if($tienda->telefono != "")
                                                <p>{{$tienda->telefono}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Celular: </strong></label> 
                                            @if($tienda->celular != "")
                                                <p>{{$tienda->celular}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Dirección: </strong></label>
                                        <p >{{$tienda->direccion}}</p>
                                    </div>


                                </div>


       
                                
                            </div>

                            <hr>

                            <div class="form-group">
                                <p  style="text-transform:uppercase"><strong><i class="fa fa-caret-right"></i> Informacion del Envio:</strong></p>
                            </div>

                            
                                @if($tienda->condicion_reparto == 6)
                                <p>CONDICION DE REPARTO : OFICINA</p>
                                <div class="row">
                                    <div class="col-md-6 b-r">

                                        <div class="form-group">
                                            <label><strong>Nombre del Transporte: </strong></label>
                                            @if($tienda->nombre_transporte_oficina != "")
                                                <p>{{$tienda->nombre_transporte_oficina}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Dirección del Transporte: </strong></label>

                                            @if($tienda->direccion_transporte_oficina != "")
                                                <p>{{$tienda->direccion_transporte_oficina}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Nombre del Responsable (Pago de Flete): </strong></label>
                                        
                                            @if($tienda->responsable_pago_flete != "")
                                                <p>{{$tienda->direccion_transporte_oficina}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Dni del responsable de recoger envio: </strong></label>
                                            @if($tienda->dni_responsable_recoger != "")
                                                <p>{{$tienda->dni_responsable_recoger}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Nombre del responsable de recoger envio: </strong></label>

                                            @if($tienda->nombre_responsable_recoger != "")
                                                <p>{{$tienda->nombre_responsable_recoger}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Telefono del responsable: </strong></label>

                                            @if($tienda->telefono_responsable_recoger != "")
                                                <p>{{$tienda->telefono_responsable_recoger}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label><strong>Observación del envio: </strong></label>
                                        
                                        @if($tienda->observacion_envio != "")
                                            <p>{{$tienda->observacion_envio}}</p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>

                                </div>

                                @else
                                <p>CONDICION DE REPARTO : DOMICILIO</p>
                                <div class="row">
                                   
                                    <div class="col-md-6 b-r">

                                        <div class="form-group">
                                            <label><strong>Nombre del Transporte: </strong></label>
                                            @if($tienda->nombre_transporte_domicilio != "")
                                                <p>{{$tienda->nombre_transporte_domicilio}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Dirección del Domicilio: </strong></label>

                                            @if($tienda->direccion_domicilio != "")
                                                <p>{{$tienda->direccion_domicilio}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Nombre del Contacto (recoger envio): </strong></label>
                                        
                                            @if($tienda->nombre_contacto_recoger != "")
                                                <p>{{$tienda->nombre_contacto_recoger}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Telefono del Contacto (recoger envio): </strong></label>
                                            @if($tienda->telefono_contacto_recoger != "")
                                                <p>{{$tienda->telefono_contacto_recoger}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>



                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <label><strong>Observación del envio: </strong></label>
                                    
                                    @if($tienda->observacion_domicilio != "")
                                        <p>{{$tienda->observacion_domicilio}}</p>
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>

                                
                                
                                @endif
                           



                            <hr>
                            <div class="form-group">
                                <p  style="text-transform:uppercase"><strong> Informacion de los contactos:</strong></p>
                            </div>
                          
                            <p  onkeyup="return mayus(this)"><strong> <i class="fa fa-caret-right"></i> Contacto Administrador:</strong></p>
                            <div class="row"  onkeyup="return mayus(this)">

                                    <div class="col-md-6 b-r">

                                    
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><strong>DNI: </strong></label>
                                                @if($tienda->dni_contacto_admin != "")
                                                    <p class="text-navy">{{$tienda->dni_contacto_admin}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>ESTADO: </strong></label>
                                                @if($tienda->estado_dni_contacto_admin != "")
                                                    <p class="">{{$tienda->estado_dni_contacto_admin}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <label><strong>Nombre: </strong></label>
                                            @if($tienda->contacto_admin_nombre != "")
                                                <p>{{$tienda->contacto_admin_nombre}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Cargo: </strong></label>
                                
                                            @if($tienda->contacto_admin_cargo != "")
                                                <p>{{$tienda->contacto_admin_cargo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Fecha de Nacimiento: </strong></label>
                                          
                                            @if($tienda->contacto_admin_fecha_nacimiento != "")
                                                <p>{{ Carbon\Carbon::parse($tienda->contacto_admin_fecha_nacimiento)->format('d/m/y') }}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>




                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Correo Electrónico: </strong></label>
                                            
                                            @if($tienda->contacto_admin_correo != "")
                                                <p>{{$tienda->contacto_admin_correo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-6">
                                                <label><strong>Celular: </strong></label>
                                                
                                                @if($tienda->contacto_admin_celular != "")
                                                    <p>{{$tienda->contacto_admin_celular}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif

                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>Teléfono: </strong></label>
                                               
                                                @if($tienda->contacto_admin_telefono != "")
                                                    <p>{{$tienda->contacto_admin_telefono}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>


                                        </div>

                                    </div>

                            </div>
                            <hr>
                            <p  onkeyup="return mayus(this)"><strong> <i class="fa fa-caret-right"></i> Contacto Crédito & Cobranza:</strong></p>
                            <div class="row"  onkeyup="return mayus(this)">

                                    <div class="col-md-6 b-r">

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><strong>DNI: </strong></label>
                                                @if($tienda->dni_contacto_credito != "")
                                                    <p class="text-navy">{{$tienda->dni_contacto_credito}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>ESTADO: </strong></label>
                                                @if($tienda->estado_dni_contacto_credito != "")
                                                    <p class="">{{$tienda->estado_dni_contacto_credito}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <label><strong>Nombre: </strong></label>
                                            @if($tienda->contacto_credito_nombre != "")
                                                <p>{{$tienda->contacto_credito_nombre}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Cargo: </strong></label>
                                
                                            @if($tienda->contacto_credito_cargo != "")
                                                <p>{{$tienda->contacto_credito_cargo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Fecha de Nacimiento: </strong></label>
                                          
                                            @if($tienda->contacto_credito_fecha_nacimiento != "")
                                                <p>{{ Carbon\Carbon::parse($tienda->contacto_credito_fecha_nacimiento)->format('d/m/y') }}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>




                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Correo Electrónico: </strong></label>
                                            
                                            @if($tienda->contacto_credito_correo != "")
                                                <p>{{$tienda->contacto_credito_correo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-6">
                                                <label><strong>Celular: </strong></label>
                                                
                                                @if($tienda->contacto_credito_celular != "")
                                                    <p>{{$tienda->contacto_credito_celular}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif

                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>Teléfono: </strong></label>
                                               
                                                @if($tienda->contacto_credito_telefono != "")
                                                    <p>{{$tienda->contacto_credito_telefono}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>


                                        </div>

                                    </div>

                            </div>
                            <hr>

                            <p  onkeyup="return mayus(this)"><strong> <i class="fa fa-caret-right"></i> Contacto Vendedor:</strong></p>
                            <div class="row"  onkeyup="return mayus(this)">

                                    <div class="col-md-6 b-r">

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><strong>DNI: </strong></label>
                                                @if($tienda->dni_contacto_vendedor != "")
                                                    <p class="text-navy">{{$tienda->dni_contacto_vendedor}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>ESTADO: </strong></label>
                                                @if($tienda->estado_dni_contacto_vendedor != "")
                                                    <p class="">{{$tienda->estado_dni_contacto_vendedor}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <label><strong>Nombre: </strong></label>
                                            @if($tienda->contacto_vendedor_nombre != "")
                                                <p>{{$tienda->contacto_vendedor_nombre}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Cargo: </strong></label>
                                
                                            @if($tienda->contacto_vendedor_cargo != "")
                                                <p>{{$tienda->contacto_vendedor_cargo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Fecha de Nacimiento: </strong></label>
                                          
                                            @if($tienda->contacto_vendedor_fecha_nacimiento != "")
                                                <p>{{ Carbon\Carbon::parse($tienda->contacto_vendedor_fecha_nacimiento)->format('d/m/y') }}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>




                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><strong>Correo Electrónico: </strong></label>
                                            
                                            @if($tienda->contacto_vendedor_correo != "")
                                                <p>{{$tienda->contacto_vendedor_correo}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-6">
                                                <label><strong>Celular: </strong></label>
                                                
                                                @if($tienda->contacto_vendedor_celular != "")
                                                    <p>{{$tienda->contacto_vendedor_celular}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif

                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>Teléfono: </strong></label>
                                               
                                                @if($tienda->contacto_vendedor_telefono != "")
                                                    <p>{{$tienda->contacto_vendedor_telefono}}</p>
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
                <div class="wrapper wrapper-content project-manager"  onkeyup="return mayus(this)">
                    <h4><b>Cliente</b></h4>

                    <div class="form-group">

                        
                            <label><strong>Nombre: </strong></label>
                            <p>{{$tienda->cliente->nombre}}</p>
                        

                    </div>

                    <div class="form-group">

                   
                            <label><strong>Tipo Documento: </strong></label>
                            <p>{{$tienda->cliente->tipo_documento}}</p>
                       

                    </div>

                    <div class="form-group">

                        
                            <label><strong>Tipo Documento: </strong></label>
                            <p>{{$tienda->cliente->documento}}</p>
                        

                    </div>
                    <hr>

                    <p><b>Información adicional sobre el registro de la tienda:</b><p>

                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left"><dt>CREADO:</dt> </div>
                                <div class="col-sm-8 text-sm-right"><dd class="mb-1">  {{ Carbon\Carbon::parse($tienda->created_at)->format('d/m/y - G:i:s') }}</dd> </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left"><dt>ACTUALIZADO:</dt> </div>
                                <div class="col-sm-8 text-sm-right"> <dd class="mb-1">  {{ Carbon\Carbon::parse($tienda->updated_at)->format('d/m/y - G:i:s') }}</dd></div>
                            </dl>

                        </div>
                    </div>


                </div>
            </div>
        </div>
@stop

