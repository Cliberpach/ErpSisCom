@extends('layout') @section('content')
@section('ventas-active', 'active')
@section('clientes-active', 'active')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2 style="text-transform:uppercase"><b>REGISTRAR NUEVA TIENDA DEL CLIENTE : {{ $cliente->nombre }} </b></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Panel de Control</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ventas.cliente.index') }}">Clientes</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('clientes.tienda.index', $cliente->id) }}">Tiendas</a>
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
                        <form action="{{ route('clientes.tienda.store') }}" method="POST" id="enviar_empresa" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">
                                            <li title="Datos de la Tienda">
                                                <a class="nav-link active" id="datos_tienda" data-toggle="tab" href="#tab-1"
                                                    id="tiendas"><i class="fa fa-shopping-cart"></i> Tienda</a>
                                            </li>
                                            <li title="Datos de Envio">
                                                <a class="nav-link" data-toggle="tab" href="#tab-2" id="envios"> <i
                                                        class="fa fa-send"></i> Envio</a>
                                            </li>
                                            <li title="Datos de los Contactos">
                                                <a class="nav-link" data-toggle="tab" href="#tab-3" id="contactos"> <i
                                                        class="fa fa-user"></i> Contactos</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tab-1" class="tab-pane active">
                                                <div class="panel-body">
                                                    <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                                                    <div class="row">
                                                        <div class="col-md-6 b-r">
                                                            <h4><b>Tienda</b></h4>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p>Registrar datos de la nueva tienda:</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label class="required">Tipo:</label>
                                                                    <select
                                                                        class="select2_form form-control {{ $errors->has('tipo_tienda') ? ' is-invalid' : '' }}"
                                                                        style="text-transform: uppercase; width:100%"
                                                                        value="{{ old('tipo_tienda') }}"
                                                                        name="tipo_tienda" id="tipo_tienda" required>
                                                                        <option></option>
                                                                        @foreach (tipos_tienda() as $tienda)
                                                                            <option value="{{ $tienda->descripcion }}" @if (old('tipo_tienda') == $tienda->descripcion) {{ 'selected' }} @endif>
                                                                                {{ $tienda->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                        @if ($errors->has('tipo_tienda'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('tipo_tienda') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </select>
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-tipo"></span></b></div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="required">Negocio:</label>
                                                                    <select
                                                                        class="select2_form form-control {{ $errors->has('tipo_negocio') ? ' is-invalid' : '' }}"
                                                                        style="text-transform: uppercase; width:100%"
                                                                        value="{{ old('tipo_negocio') }}"
                                                                        name="tipo_negocio" id="tipo_negocio" required>
                                                                        <option></option>
                                                                        @foreach (tipos_negocio() as $negocio)
                                                                            <option value="{{ $negocio->descripcion }}"
                                                                                @if (old('tipo_negocio') == $tienda->descripcion) {{ 'selected' }} @endif>
                                                                                {{ $negocio->descripcion }}</option>
                                                                        @endforeach
                                                                        @if ($errors->has('tipo_negocio'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('tipo_negocio') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </select>
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-negocio"></span></b></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="required">Nombre: </label>
                                                                <input type="text"
                                                                    class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                                                    name="nombre" value="{{ old('nombre') }}" id="nombre"
                                                                    onkeyup="return mayus(this)" required>
                                                                @if ($errors->has('nombre'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('nombre') }}</strong>
                                                                    </span>
                                                                @endif
                                                                <div class="invalid-feedback"><b><span
                                                                            id="error-nombre"></span></b></div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <label class="required">Dirección:</label>
                                                                    <textarea type="text" id="direccion" name="direccion"
                                                                        required
                                                                        class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                                                        value="{{ old('direccion') }}"
                                                                        onkeyup="return mayus(this)">{{ old('direccion') }}</textarea>
                                                                    @if ($errors->has('direccion'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('direccion') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-direccion"></span></b></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-4 col-xs-12">
                                                                    <label id="ubigeo_texto">Ubigeo: </label>
                                                                    <input type="text" id="ubigeo"
                                                                        class="form-control {{ $errors->has('ubigeo') ? ' is-invalid' : '' }}"
                                                                        name="ubigeo" value="{{ old('ubigeo') }}">
                                                                </div>
                                                                <div class="col-lg-8 col-xs-12">
                                                                    <label class="">Correo: </label>
                                                                    <input type="email"
                                                                        class="form-control {{ $errors->has('correo') ? ' is-invalid' : '' }}"
                                                                        name="correo" value="{{ old('correo') }}"
                                                                        id="correo" onkeyup="return mayus(this)">
                                                                    @if ($errors->has('correo'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('correo') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Teléfono:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                                                        name="telefono" id="telefono"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('telefono') }}">
                                                                    @if ($errors->has('telefono'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Celular:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('celular') ? ' is-invalid' : '' }}"
                                                                        name="celular" id="celular"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('celular') }}">
                                                                    @if ($errors->has('celular'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('celular') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <label id="logo_label">Imagen:</label>
                                                                    <div class="custom-file">
                                                                        <input id="logo" type="file" name="logo"
                                                                            onchange="seleccionarimagen()"
                                                                            class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                                                            accept="image/*"
                                                                            {{ $cliente->ruta_logo ? 'src=' . Storage::url($cliente->ruta_logo) . '' : '' }}>
                                                                        <label for="logo" id="logo_txt" name="logo_txt"
                                                                            class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">{{ $cliente->nombre_logo ? $cliente->nombre_logo : 'Seleccionar' }}</label>
                                                                        @if ($errors->has('logo'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('logo') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        <div class="invalid-feedback"><b><span
                                                                                    id="error-logo_mensaje"></span></b>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row" style="margin-top:10px;">
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-4"><a href="javascript:void(0);"
                                                                                id="limpiar_logo" onclick="limpiar()">
                                                                                <span class="badge badge-danger">x</span>
                                                                            </a></div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-4">
                                                                            @if ($cliente->ruta_logo)
                                                                                <img class="logo"
                                                                                    src="{{ Storage::url($cliente->ruta_logo) }}"
                                                                                    alt="">
                                                                                <input id="url_logo" name="url_logo"
                                                                                    type="hidden"
                                                                                    value="{{ $cliente->ruta_logo }}">
                                                                            @else
                                                                                <img class="logo"
                                                                                    src="{{ asset('storage/Clientes/img/default.png') }}"
                                                                                    alt="">
                                                                                <input id="url_logo" name="url_logo"
                                                                                    type="hidden" value="">
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p>Horario de Atención:</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Horario Inicio:</label>
                                                                    <input type="time" name="hora_inicio"
                                                                        class="form-control" value="00:00:00" max="24:00:00"
                                                                        min="00:00:00" step="1">
                                                                    @if ($errors->has('horario_inicio'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('horario_inicio') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Horario Termino:</label>
                                                                    <input type="time" name="hora_termino"
                                                                        class="form-control" value="00:00:00" max="24:00:00"
                                                                        min="00:00:00" step="1">
                                                                    @if ($errors->has('horario_termino'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('horario_termino') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group">
                                                                <h4><b>Datos de las Redes Sociales</b></h4>
                                                                <p>Registrar datos de las redes sociales de la tienda:</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Facebook:</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-facebook"></i>
                                                                    </span>
                                                                    <input type="text" id="facebook" name="facebook"
                                                                        class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('facebook') }}">
                                                                    @if ($errors->has('facebook'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('facebook') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Instagram:</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-instagram"></i>
                                                                    </span>
                                                                    <input type="text" id="instagram" name="instagram"
                                                                        class="form-control {{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('instagram') }}">
                                                                    @if ($errors->has('instagram'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('instagram') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Web:</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-globe"></i>
                                                                    </span>
                                                                    <input type="text" id="web" name="web"
                                                                        class="form-control {{ $errors->has('web') ? ' is-invalid' : '' }}"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('web') }}">
                                                                    @if ($errors->has('web'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('web') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Localizacion de la tienda:</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="urlgps"
                                                                        id="urlgps">
                                                                    <span class="input-group-append"><a style="color:white"
                                                                            onclick="consultarUrl()"
                                                                            class="btn btn-primary"><i
                                                                                class="fa fa-search"></i>Consultar</a></span>
                                                                </div>
                                                                <br>
                                                                <input id="pac-input" type="text" placeholder="Buscar"
                                                                class="form-control"
                                                                style="width:250px!important;border-radius:5px;margin-top:10px;" />
                                                                <div id="map" style="width:100%;height:300px;"></div>
                                                                <input type="hidden" name="lat" id="lat">
                                                                <input type="hidden" name="lng" id="lng">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab-2" class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="form-group">
                                                                <h4><b>Datos de Envio</b></h4>
                                                                <p>Registrar datos de envio:</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="required">Condicion de Reparto</label>
                                                                <select id="condicion_reparto" name="condicion_reparto"
                                                                    class="select2_form form-control {{ $errors->has('condicion_reparto') ? ' is-invalid' : '' }}">
                                                                    <option></option>
                                                                    @foreach (condicion_reparto() as $condicion_reparto)
                                                                        <option value="{{ $condicion_reparto->id }}" @if (old('condicion_reparto') == $condicion_reparto->descripcion) {{ 'selected' }} @endif>{{ $condicion_reparto->descripcion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('condicion_reparto'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('condicion_reparto') }}</strong>
                                                                    </span>
                                                                @endif
                                                                <div class="invalid-feedback"><b><span
                                                                            id="error-condicion_reparto"></span></b></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <p class="text-center">
                                                                    <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div id="reparto_oficina">
                                                                <div class="form-group">
                                                                    <h4><b>Datos según la condición de Reparto "Oficina"</b>
                                                                    </h4>
                                                                    <p>Registrar Transporte :</p>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-7">
                                                                        <label class="required">Ruc</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('ruc_transporte_oficina') ? ' is-invalid' : '' }}"
                                                                                name="ruc_transporte_oficina" maxlength="11"
                                                                                value="{{ old('ruc_transporte_oficina') }}"
                                                                                id="ruc_transporte_oficina"
                                                                                onkeyup="return mayus(this)" disabled>
                                                                            <span class="input-group-append"><a
                                                                                    style="color:white"
                                                                                    onclick="consultarRucoficina()"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-search"></i>
                                                                                    Sunat</a></span>
                                                                            @if ($errors->has('ruc_transporte_oficina'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('ruc_transporte_oficina') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                            <div class="invalid-feedback"><b><span
                                                                                        id="error-ruc_transporte_oficina"></span></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="">Estado</label>
                                                                        <input type="text"
                                                                            class="form-control  text-center {{ $errors->has('estado_transporte_oficina') ? ' is-invalid' : '' }}"
                                                                            name="estado_transporte_oficina"
                                                                            value="{{ old('estado_transporte_oficina', 'SIN VERIFICAR') }}"
                                                                            id="estado_transporte_oficina"
                                                                            onkeyup="return mayus(this)" readonly>
                                                                        @if ($errors->has('estado_transporte_oficina'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('estado_transporte_oficina') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        <div class="invalid-feedback"><b><span
                                                                                    id="error-estado_transporte_oficina"></span></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Nombre </label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('nombre_transporte_oficina') ? ' is-invalid' : '' }}"
                                                                        name="nombre_transporte_oficina"
                                                                        value="{{ old('nombre_transporte_oficina') }}"
                                                                        id="nombre_transporte_oficina"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('nombre_transporte_oficina'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('nombre_transporte_oficina') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-nombre_transporte_oficina"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Dirección </label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('direccion_transporte_oficina') ? ' is-invalid' : '' }}"
                                                                        name="direccion_transporte_oficina"
                                                                        value="{{ old('direccion_transporte_oficina') }}"
                                                                        id="direccion_transporte_oficina"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('direccion_transporte_oficina'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('direccion_transporte_oficina') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-direccion_transporte_oficina"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Modo</label>
                                                                    <select id="responsable_pago" name="responsable_pago"
                                                                        class="select2_form form-control {{ $errors->has('responsable_pago') ? ' is-invalid' : '' }}"
                                                                        disabled value="{{ old('responsable_pago') }}">
                                                                        <option></option>
                                                                        @foreach (modo_responsables() as $responsable)
                                                                            <option value="{{ $responsable->id }}"
                                                                                {{ old('responsable_pago') == $responsable->id ? 'selected' : '' }}>
                                                                                {{ $responsable->descripcion }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('responsable_pago'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('responsable_pago') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-responsable_pago"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <p>Registrar Responsable (Recoger el envio) :</p>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-7">
                                                                        <label class="required">Dni</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('dni_responsable_recoger') ? ' is-invalid' : '' }}"
                                                                                name="dni_responsable_recoger" maxlength="8"
                                                                                value="{{ old('dni_responsable_recoger') }}"
                                                                                id="dni_responsable_recoger"
                                                                                onkeyup="return mayus(this)" disabled>
                                                                            <span class="input-group-append"><a
                                                                                    style="color:white"
                                                                                    onclick="consultarDni()"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-search"></i>
                                                                                    Reniec</a></span>
                                                                            @if ($errors->has('dni_responsable_recoger'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('dni_responsable_recoger') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                            <div class="invalid-feedback"><b><span
                                                                                        id="error-dni_responsable_recoger"></span></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="">Estado</label>
                                                                        <input type="text"
                                                                            class="form-control  text-center {{ $errors->has('estado_responsable_recoger') ? ' is-invalid' : '' }}"
                                                                            name="estado_responsable_recoger"
                                                                            value="{{ old('estado_responsable_recoger', 'SIN VERIFICAR') }}"
                                                                            id="estado_responsable_recoger"
                                                                            onkeyup="return mayus(this)" disabled>
                                                                        @if ($errors->has('estado_responsable_recoger'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('estado_responsable_recoger') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        <div class="invalid-feedback"><b><span
                                                                                    id="error-estado_responsable_recoger"></span></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Nombre</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('nombre_responsable_recoger') ? ' is-invalid' : '' }}"
                                                                        name="nombre_responsable_recoger"
                                                                        value="{{ old('nombre_responsable_recoger') }}"
                                                                        id="nombre_responsable_recoger"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('nombre_responsable_recoger'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('nombre_responsable_recoger') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-nombre_responsable_recoger"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="">Telefono</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('telefono_responsable_recoger') ? ' is-invalid' : '' }}"
                                                                        name="telefono_responsable_recoger"
                                                                        value="{{ old('telefono_responsable_recoger') }}"
                                                                        id="telefono_responsable_recoger"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('telefono_responsable_recoger'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono_responsable_recoger') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-telefono_responsable_recoger"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Observación:</label>
                                                                    <textarea type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('observacion_envio') ? ' is-invalid' : '' }}"
                                                                        name="observacion_envio" id="observacion_envio"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('observacion_envio') }}"
                                                                        disabled>{{ old('observacion_envio') }}</textarea>
                                                                    @if ($errors->has('observacion_envio'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('observacion_envio') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div id="reparto_domicilio" style="display:none;">
                                                                <div class="form-group">
                                                                    <h4><b>Datos según la condición de Reparto
                                                                            "Domicilio"</b></h4>
                                                                    <p>Registrar Transporte :</p>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-7">
                                                                        <label class="required">Ruc</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('ruc_transporte_domicilio') ? ' is-invalid' : '' }}"
                                                                                name="ruc_transporte_domicilio"
                                                                                maxlength="11"
                                                                                value="{{ old('ruc_transporte_domicilio') }}"
                                                                                id="ruc_transporte_domicilio"
                                                                                onkeyup="return mayus(this)" disabled>
                                                                            <span class="input-group-append"><a
                                                                                    style="color:white"
                                                                                    onclick="consultarRuc()"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-search"></i>
                                                                                    Sunat</a></span>
                                                                            @if ($errors->has('ruc_transporte_domicilio'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('ruc_transporte_domicilio') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                            <div class="invalid-feedback"><b><span
                                                                                        id="error-ruc_transporte_domicilio"></span></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="">Estado</label>
                                                                        <input type="text"
                                                                            class="form-control  text-center {{ $errors->has('estado_transporte_domicilio') ? ' is-invalid' : '' }}"
                                                                            name="estado_transporte_domicilio"
                                                                            value="{{ old('estado_transporte_domicilio', 'SIN VERIFICAR') }}"
                                                                            id="estado_transporte_domicilio"
                                                                            onkeyup="return mayus(this)" readonly>
                                                                        @if ($errors->has('estado_transporte_domicilio'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('estado_transporte_domicilio') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        <div class="invalid-feedback"><b><span
                                                                                    id="error-estado_transporte_domicilio"></span></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Nombre </label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('nombre_transporte_domicilio') ? ' is-invalid' : '' }}"
                                                                        name="nombre_transporte_domicilio"
                                                                        value="{{ old('nombre_transporte_domicilio') }}"
                                                                        id="nombre_transporte_domicilio"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('nombre_transporte_domicilio'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('nombre_transporte_domicilio') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-nombre_transporte_domicilio"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Dirección del domicilio </label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('direccion_domicilio') ? ' is-invalid' : '' }}"
                                                                        name="direccion_domicilio"
                                                                        value="{{ old('direccion_domicilio') }}"
                                                                        id="direccion_domicilio"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('direccion_domicilio'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('direccion_domicilio') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-direccion_domicilio"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Modo</label>
                                                                    <select id="responsable_pago_domicilio" name="responsable_pago_domicilio" class="select2_form form-control {{ $errors->has('responsable_pago') ? ' is-invalid' : '' }}"  value="{{old('responsable_pago',$tienda->responsable_pago)}}" >
                                                                        <option></option>
                                                                        @foreach(modo_responsables() as $responsable)
                                                                            <option value="{{ $responsable->id }}" {{ (old('responsable_pago',$tienda->responsable_pago) == $responsable->id ? "selected" : "") }} >{{ $responsable->descripcion }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('responsable_pago'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('responsable_pago') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span id="error-responsable_pago"></span></b></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <p>Registrar Contacto de recoger el envio:</p>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-7">
                                                                        <label class="">Dni</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control {{ $errors->has('dni_contacto_recoger') ? ' is-invalid' : '' }}"
                                                                                name="dni_contacto_recoger" maxlength="8"
                                                                                value="{{ old('dni_contacto_recoger') }}"
                                                                                id="dni_contacto_recoger"
                                                                                onkeyup="return mayus(this)" disabled>
                                                                            <span class="input-group-append"><a
                                                                                    style="color:white"
                                                                                    onclick="consultarReniecContacto()"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-search"></i>
                                                                                    Reniec</a></span>
                                                                            @if ($errors->has('dni_contacto_recoger'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('dni_contacto_recoger') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                            <div class="invalid-feedback"><b><span
                                                                                        id="error-dni_contacto_recoger"></span></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="">Estado</label>
                                                                        <input type="text"
                                                                            class="form-control  text-center {{ $errors->has('estado_dni_contacto_recoger') ? ' is-invalid' : '' }}"
                                                                            name="estado_dni_contacto_recoger"
                                                                            value="{{ old('estado_dni_contacto_recoger', 'SIN VERIFICAR') }}"
                                                                            id="estado_dni_contacto_recoger"
                                                                            onkeyup="return mayus(this)" readonly>
                                                                        @if ($errors->has('estado_dni_contacto_recoger'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('estado_dni_contacto_recoger') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        <div class="invalid-feedback"><b><span
                                                                                    id="error-estado_dni_contacto_recoger"></span></b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="">Nombre</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('nombre_contacto_recoger') ? ' is-invalid' : '' }}"
                                                                        name="nombre_contacto_recoger"
                                                                        value="{{ old('nombre_contacto_recoger') }}"
                                                                        id="nombre_contacto_recoger"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('nombre_contacto_recoger'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('nombre_contacto_recoger') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-nombre_contacto_recoger"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="">Telefono</label>
                                                                    <input type="text"
                                                                        class="form-control {{ $errors->has('telefono_contacto_recoger') ? ' is-invalid' : '' }}"
                                                                        name="telefono_contacto_recoger"
                                                                        value="{{ old('telefono_contacto_recoger') }}"
                                                                        id="telefono_contacto_recoger"
                                                                        onkeyup="return mayus(this)" disabled>
                                                                    @if ($errors->has('telefono_contacto_recoger'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono_contacto_recoger') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                    <div class="invalid-feedback"><b><span
                                                                                id="error-telefono_contacto_recoger"></span></b>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Observación:</label>
                                                                    <textarea type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('observacion_domicilio') ? ' is-invalid' : '' }}"
                                                                        name="observacion_domicilio"
                                                                        id="observacion_domicilio"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('observacion_domicilio') }}"
                                                                        disabled>{{ old('observacion_domicilio') }}</textarea>
                                                                    @if ($errors->has('observacion_domicilio'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('observacion_domicilio') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab-3" class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="form-group">
                                                                <h4><b>Contacto: "Administrador"</b></h4>
                                                                <p>Registrar datos del contacto Administrador:</p>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-7">
                                                                    <label class="">Dni</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control {{ $errors->has('dni_contacto_admin') ? ' is-invalid' : '' }}"
                                                                            name="dni_contacto_admin" maxlength="8"
                                                                            value="{{ old('dni_contacto_admin') }}"
                                                                            id="dni_contacto_admin"
                                                                            onkeyup="return mayus(this)">
                                                                        <span class="input-group-append"><a
                                                                                style="color:white"
                                                                                onclick="consultarDniAdmin()"
                                                                                class="btn btn-primary"><i
                                                                                    class="fa fa-search"></i>
                                                                                Reniec</a></span>
                                                                        @if ($errors->has('dni_contacto_admin'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('dni_contacto_admin') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="">Estado</label>
                                                                    <input type="text"
                                                                        class="form-control  text-center {{ $errors->has('estado_dni_contacto_admin') ? ' is-invalid' : '' }}"
                                                                        name="estado_dni_contacto_admin"
                                                                        value="{{ old('estado_dni_contacto_admin', 'SIN VERIFICAR') }}"
                                                                        id="estado_dni_contacto_admin"
                                                                        onkeyup="return mayus(this)" readonly>
                                                                    @if ($errors->has('estado_dni_contacto_admin'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('estado_dni_contacto_admin') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Nombre</label>
                                                                <input type="text" id="nombre_administrador"
                                                                    name="nombre_administrador"
                                                                    class="form-control {{ $errors->has('nombre_administrador') ? ' is-invalid' : '' }}"
                                                                    value="{{ old('nombre_administrador') }}"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('nombre_administrador'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('nombre_administrador') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6 col-xs-12"
                                                                    id="fecha_nacimiento_administrador_campo">
                                                                    <label class="">Fecha de Nacimiento</label>
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text"
                                                                            id="fecha_nacimiento_administrador"
                                                                            name="fecha_nacimiento_administrador"
                                                                            class="form-control {{ $errors->has('fecha_nacimiento_administrador') ? ' is-invalid' : '' }}"
                                                                            value="{{ old('fecha_nacimiento_administrador', getFechaFormato($fecha_hoy, 'd/m/Y')) }}"
                                                                            autocomplete="off" readonly>
                                                                        @if ($errors->has('fecha_nacimiento_administrador'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('fecha_nacimiento_administrador') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-xs-12">
                                                                    <label class="">Cargo</label>
                                                                    <select
                                                                        class="select2_form form-control {{ $errors->has('cargo_administrador') ? ' is-invalid' : '' }}"
                                                                        style="text-transform: uppercase; width:100%"
                                                                        value="{{ old('cargo_administrador') }}"
                                                                        name="cargo_administrador" id="cargo_administrador">
                                                                        <option></option>
                                                                        @foreach (cargos() as $cargo)
                                                                            <option value="{{ $cargo->descripcion }}"
                                                                                @if (old('cargo_administrador')) {{ 'selected' }} @endif>
                                                                                {{ $cargo->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                        @if ($errors->has('cargo_administrador'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('cargo_administrador') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="">Correo Electrónico</label>
                                                                <input type="email" id="correo_administrador"
                                                                    name="correo_administrador"
                                                                    class="form-control {{ $errors->has('correo_administrador') ? ' is-invalid' : '' }}"
                                                                    value="{{ old('correo_administrador') }}"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('correo_administrador'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('correo_administrador') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Teléfono:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('telefono_administrador') ? ' is-invalid' : '' }}"
                                                                        name="telefono_administrador"
                                                                        id="telefono_administrador"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('telefono_administrador') }}">
                                                                    @if ($errors->has('telefono_administrador'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono_administrador') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Celular:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('celular_administrador') ? ' is-invalid' : '' }}"
                                                                        name="celular_administrador"
                                                                        id="celular_administrador"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('celular_administrador') }}">
                                                                    @if ($errors->has('celular_administrador'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('celular_administrador') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="form-group">
                                                                <h4><b>Contacto: "Crédito & Cobranza"</b></h4>
                                                                <p>Registrar datos del contacto Crédito & Cobranza:</p>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-7">
                                                                    <label class="">Dni</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control {{ $errors->has('dni_contacto_credito') ? ' is-invalid' : '' }}"
                                                                            name="dni_contacto_credito" maxlength="8"
                                                                            value="{{ old('dni_contacto_credito') }}"
                                                                            id="dni_contacto_credito"
                                                                            onkeyup="return mayus(this)">
                                                                        <span class="input-group-append"><a
                                                                                style="color:white"
                                                                                onclick="consultarDniCredito()"
                                                                                class="btn btn-primary"><i
                                                                                    class="fa fa-search"></i>
                                                                                Reniec</a></span>
                                                                        @if ($errors->has('dni_contacto_credito'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('dni_contacto_credito') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="">Estado</label>
                                                                    <input type="text"
                                                                        class="form-control  text-center {{ $errors->has('estado_dni_contacto_credito') ? ' is-invalid' : '' }}"
                                                                        name="estado_dni_contacto_credito"
                                                                        value="{{ old('estado_dni_contacto_credito', 'SIN VERIFICAR') }}"
                                                                        id="estado_dni_contacto_credito"
                                                                        onkeyup="return mayus(this)" readonly>
                                                                    @if ($errors->has('estado_dni_contacto_credito'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('estado_dni_contacto_credito') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Nombre</label>
                                                                <input type="text" id="nombre_credito" name="nombre_credito"
                                                                    class="form-control {{ $errors->has('nombre_credito') ? ' is-invalid' : '' }}"
                                                                    value="{{ old('nombre_credito') }}"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('nombre_credito'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('nombre_credito') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6 col-xs-12"
                                                                    id="fecha_nacimiento_credito_campo">
                                                                    <label class="">Fecha de Nacimiento</label>
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" id="fecha_nacimiento_credito"
                                                                            name="fecha_nacimiento_credito"
                                                                            class="form-control {{ $errors->has('fecha_nacimiento_credito') ? ' is-invalid' : '' }}"
                                                                            value="{{ old('fecha_nacimiento_credito', getFechaFormato($fecha_hoy, 'd/m/Y')) }}"
                                                                            autocomplete="off" readonly>
                                                                        @if ($errors->has('fecha_nacimiento_credito'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('fecha_nacimiento_credito') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-xs-12">
                                                                    <label class="">Cargo</label>
                                                                    <select
                                                                        class="select2_form form-control {{ $errors->has('cargo_credito') ? ' is-invalid' : '' }}"
                                                                        style="text-transform: uppercase; width:100%"
                                                                        value="{{ old('cargo_credito') }}"
                                                                        name="cargo_credito" id="cargo_credito">
                                                                        <option></option>
                                                                        @foreach (cargos() as $cargo)
                                                                            <option value="{{ $cargo->descripcion }}"
                                                                                @if (old('cargo_credito')) {{ 'selected' }} @endif>
                                                                                {{ $cargo->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                        @if ($errors->has('cargo_credito'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('cargo_credito') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="">Correo Electrónico</label>
                                                                <input type="email" id="correo_credito"
                                                                    name="correo_credito"
                                                                    class="form-control {{ $errors->has('correo_credito') ? ' is-invalid' : '' }}"
                                                                    value="{{ old('correo_credito') }}"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('correo_credito'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('correo_credito') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Teléfono:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('telefono_credito') ? ' is-invalid' : '' }}"
                                                                        name="telefono_credito" id="telefono_credito"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('telefono_credito') }}">
                                                                    @if ($errors->has('telefono_credito'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono_credito') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Celular:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('celular_credito') ? ' is-invalid' : '' }}"
                                                                        name="celular_credito" id="celular_credito"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('celular_credito') }}">
                                                                    @if ($errors->has('celular_credito'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('celular_credito') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <div class="col-md-6 b-r">
                                                            <div class="form-group">
                                                                <h4><b>Contacto: "Vendedor"</b></h4>
                                                                <p>Registrar datos del contacto Vendedor:</p>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-7">
                                                                    <label class="">Dni</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control {{ $errors->has('dni_contacto_vendedor') ? ' is-invalid' : '' }}"
                                                                            name="dni_contacto_vendedor" maxlength="8"
                                                                            value="{{ old('dni_contacto_vendedor') }}"
                                                                            id="dni_contacto_vendedor"
                                                                            onkeyup="return mayus(this)">
                                                                        <span class="input-group-append"><a
                                                                                style="color:white"
                                                                                onclick="consultarDniVendedor()"
                                                                                class="btn btn-primary"><i
                                                                                    class="fa fa-search"></i>
                                                                                Reniec</a></span>
                                                                        @if ($errors->has('dni_contacto_vendedor'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('dni_contacto_vendedor') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="">Estado</label>
                                                                    <input type="text"
                                                                        class="form-control  text-center {{ $errors->has('estado_dni_contacto_vendedor') ? ' is-invalid' : '' }}"
                                                                        name="estado_dni_contacto_vendedor"
                                                                        value="{{ old('estado_dni_contacto_vendedor', 'SIN VERIFICAR') }}"
                                                                        id="estado_dni_contacto_vendedor"
                                                                        onkeyup="return mayus(this)" readonly>
                                                                    @if ($errors->has('estado_dni_contacto_vendedor'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('estado_dni_contacto_vendedor') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Nombre</label>
                                                                <input type="text" id="nombre_vendedor"
                                                                    name="nombre_vendedor"
                                                                    class="form-control {{ $errors->has('nombre_vendedor') ? ' is-invalid' : '' }}"
                                                                    value="{{ old('nombre_vendedor') }}"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('nombre_vendedor'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('nombre_vendedor') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6 col-xs-12"
                                                                    id="fecha_nacimiento_vendedor_campo">
                                                                    <label class="">Fecha de Nacimiento</label>
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" id="fecha_nacimiento_vendedor"
                                                                            name="fecha_nacimiento_vendedor"
                                                                            class="form-control {{ $errors->has('fecha_nacimiento_vendedor') ? ' is-invalid' : '' }}"
                                                                            value="{{ old('fecha_nacimiento_vendedor', getFechaFormato($fecha_hoy, 'd/m/Y')) }}"
                                                                            autocomplete="off" readonly>
                                                                        @if ($errors->has('fecha_nacimiento_vendedor'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('fecha_nacimiento_vendedor') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-xs-12">
                                                                    <label class="">Cargo</label>
                                                                    <select
                                                                        class="select2_form form-control {{ $errors->has('cargo_vendedor') ? ' is-invalid' : '' }}"
                                                                        style="text-transform: uppercase; width:100%"
                                                                        value="{{ old('cargo_vendedor') }}"
                                                                        name="cargo_vendedor" id="cargo_vendedor">
                                                                        <option></option>
                                                                        @foreach (cargos() as $cargo)
                                                                            <option value="{{ $cargo->descripcion }}"
                                                                                @if (old('cargo_vendedor')) {{ 'selected' }} @endif>
                                                                                {{ $cargo->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                        @if ($errors->has('cargo_vendedor'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('cargo_vendedor') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="">Correo: </label>
                                                                <input type="email"
                                                                    class="form-control {{ $errors->has('correo_vendedor') ? ' is-invalid' : '' }}"
                                                                    name="correo_vendedor"
                                                                    value="{{ old('correo_vendedor') }}" id="correo"
                                                                    onkeyup="return mayus(this)">
                                                                @if ($errors->has('correo_vendedor'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('correo_vendedor') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Teléfono:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('telefono_vendedor') ? ' is-invalid' : '' }}"
                                                                        name="telefono_vendedor" id="telefono_vendedor"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('telefono_vendedor') }}">
                                                                    @if ($errors->has('telefono_vendedor'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('telefono_vendedor') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Celular:</label>
                                                                    <input type="text" placeholder=""
                                                                        class="form-control {{ $errors->has('celular_vendedor') ? ' is-invalid' : '' }}"
                                                                        name="celular_vendedor" id="celular_vendedor"
                                                                        onkeyup="return mayus(this)"
                                                                        value="{{ old('celular_vendedor') }}">
                                                                    @if ($errors->has('celular_vendedor'))
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $errors->first('celular_vendedor') }}</strong>
                                                                        </span>
                                                                    @endif
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
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-md-6 text-left" style="color:#fcbc6c">
                                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                        (<label class="required"></label>) son obligatorios.</small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('clientes.tienda.index', $cliente->id) }}" id="btn_cancelar"
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
@stop
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <!-- DataTable -->
    <link href="{{ asset('Inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <style>
        .logo {
            width: 200px;
            height: 200px;
            border-radius: 10%;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            margin-left: 2px;
        }

    </style>
@endpush
@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{ asset('Inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
    <!-- Date range picker -->
    <script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&libraries=geometry&libraries=places">
    </script>
    <script>
        var map;
        var onemarker = 0;
        var markers=[];
        $('#fecha_nacimiento_administrador_campo .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            language: 'es',
            format: "dd/mm/yyyy",
        })
        $('#fecha_nacimiento_credito_campo .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            language: 'es',
            format: "dd/mm/yyyy",
        })
        $('#fecha_nacimiento_vendedor_campo .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            language: 'es',
            format: "dd/mm/yyyy",
        })
        //Añadir Entidad Financiera
        function agregarEntidad() {
            $('#modal_agregar_entidad').modal('show');
        }
        $.fn.select2.defaults.set('language', 'es');
        //Select2
        $(".select2_form").select2({
            placeholder: "SELECCIONAR",
            allowClear: true,
            height: '200px',
            width: '100%',
        });
        // Solo campos numericos
        $('#ubigeo').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $("#nombre_responsable_recoger").keyup(function() {
            if ($('#estado_responsable_recoger').val('ACTIVO')) {
                $('#estado_responsable_recoger').val('SIN VERIFICAR');
            }
        })
        $("#nombre_transporte_domicilio").keyup(function() {
            if ($('#estado_transporte_domicilio').val('ACTIVO')) {
                $('#estado_transporte_domicilio').val('SIN VERIFICAR');
            }
        })
        $("#nombre_contacto_recoger").keyup(function() {
            if ($('#estado_dni_contacto_recoger').val('ACTIVO')) {
                $('#estado_dni_contacto_recoger').val('SIN VERIFICAR');
            }
        })
        // Solo campos numericos
        $('#ruc').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#dni_contacto_recoger').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#ruc_transporte_domicilio').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#ruc_transporte_oficina').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#dni_representante').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#telefono').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#celular').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#telefono_administrador').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#celular_administrador').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#telefono_credito').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#celular_credito').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#telefono_vendedor').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#celular_vendedor').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function validarCampos() {
            var campos = true
            if ($('#tipo_tienda').val() == '') {
                campos = false
                $('#tiendas').click()
            }
            if ($('#tipo_negocio').val() == '') {
                campos = false
                $('#tiendas').click()
            }
            if ($('#nombre').val() == '') {
                campos = false
                $('#tiendas').click()
            }
            if ($('#direccion').val() == '') {
                campos = false
                $('#tiendas').click()
            }
            if ($("#condicion_reparto").val() == '6') {
                if ($('#ruc_transporte_oficina').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#nombre_transporte_oficina').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#direccion_transporte_oficina').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#responsable_pago_flete').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#dni_responsable_recoger').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#nombre_responsable_recoger').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#responsable_pago').val() == '') {
                    campos = false
                    $('#envios').click()
                }
            } else {
                if ($('#ruc_transporte_domicilio').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#nombre_transporte_domicilio').val() == '') {
                    campos = false
                    $('#envios').click()
                }
                if ($('#direccion_domicilio').val() == '') {
                    campos = false
                    $('#envios').click()
                }
            }
            return campos
        }
        $('#enviar_empresa').submit(function(e) {
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
                    var campos = validarCampos()
                    if (campos == true) {
                        $('#estado_responsable_recoger').prop('disabled', false)
                        this.submit();
                    } else {
                        toastr.error('Hay campos obligatorios sin ingresar', 'Error');
                    }
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
        $('.tabs-container .nav-tabs #envios').click(function() {
            limpiarErrores()
            var enviar = true;
            if ($('#tipo_tienda').val() == '') {
                enviar = false
                $('#tipo_tienda').addClass("is-invalid")
                toastr.error("Seleccione un tipo de tienda antes de ingresar un contacto.", 'Error');
                $('#error-tipo').text("El campo Tipo es obligatorio.")
            }
            if ($('#tipo_negocio').val() == '') {
                enviar = false
                $('#tipo_negocio').addClass("is-invalid")
                toastr.error("Seleccione un tipo de negocio antes de ingresar un contacto.", 'Error');
                $('#error-negocio').text("El campo Negocio es obligatorio.")
            }
            if ($('#nombre').val() == '') {
                enviar = false
                $('#nombre').addClass("is-invalid")
                toastr.error("Ingrese el nombre de la tienda antes de ingresar un contacto.", 'Error');
                $('#error-nombre').text("El campo Nombre es obligatorio.")
            }
            if ($('#direccion').val() == '') {
                enviar = false
                $('#direccion').addClass("is-invalid")
                toastr.error("Ingrese la dirección de la tienda antes de ingresar un contacto.", 'Error');
                $('#error-direccion').text("El campo Dirección es obligatorio.")
            }
            return enviar
        })
        $('.tabs-container .nav-tabs #contactos').click(function() {
            limpiarErrores()
            var enviar = true;
            if ($('#tipo_tienda').val() == '') {
                enviar = false
                $('#tipo_tienda').addClass("is-invalid")
                toastr.error("Seleccione un tipo de tienda antes de ingresar un contacto.", 'Error');
                $('#error-tipo').text("El campo Tipo es obligatorio.")
            }
            if ($('#tipo_negocio').val() == '') {
                enviar = false
                $('#tipo_negocio').addClass("is-invalid")
                toastr.error("Seleccione un tipo de negocio antes de ingresar un contacto.", 'Error');
                $('#error-negocio').text("El campo Negocio es obligatorio.")
            }
            if ($('#nombre').val() == '') {
                enviar = false
                $('#nombre').addClass("is-invalid")
                toastr.error("Ingrese el nombre de la tienda antes de ingresar un contacto.", 'Error');
                $('#error-nombre').text("El campo Nombre es obligatorio.")
            }
            if ($('#direccion').val() == '') {
                enviar = false
                $('#direccion').addClass("is-invalid")
                toastr.error("Ingrese la dirección de la tienda antes de ingresar un contacto.", 'Error');
                $('#error-direccion').text("El campo Dirección es obligatorio.")
            }
            switch ($("#condicion_reparto").val()) {
                case "6":
                    if ($('#ruc_transporte_oficina').val() == '') {
                        enviar = false
                        $('#ruc_transporte_oficina').addClass("is-invalid")
                        toastr.error("Ingrese Ruc del Transportista.", 'Error');
                        $('#error-ruc_transporte_oficina').text("El campo Ruc del Transporte es obligatorio.")
                    }
                    if ($('#nombre_transporte_oficina').val() == '') {
                        enviar = false
                        $('#nombre_transporte_oficina').addClass("is-invalid")
                        toastr.error("Ingrese el Nombre del Transporte.", 'Error');
                        $('#error-nombre_transporte_oficina').text("El campo Nombre del transporte es obligatorio.")
                    }
                    if ($('#direccion_transporte_oficina').val() == '') {
                        enviar = false
                        $('#direccion_transporte_oficina').addClass("is-invalid")
                        toastr.error("Ingrese la dirección del Transporte.", 'Error');
                        $('#error-direccion_transporte_oficina').text(
                            "El campo Dirección del transporte es obligatorio.")
                    }
                    if ($('#responsable_pago_flete').val() == '') {
                        enviar = false
                        $('#responsable_pago_flete').addClass("is-invalid")
                        toastr.error("Ingrese el Nombre del Responsable (Pago de Flete).", 'Error');
                        $('#error-responsable_pago_flete').text("El campo Nombre del Responsable es obligatorio.")
                    }
                    if ($('#dni_responsable_recoger').val() == '') {
                        enviar = false
                        $('#dni_responsable_recoger').addClass("is-invalid")
                        toastr.error("Ingrese el Dni del responsable.", 'Error');
                        $('#error-dni_responsable_recoger').text("El campo Dni del responsable es obligatorio.")
                    }
                    if ($('#nombre_responsable_recoger').val() == '') {
                        enviar = false
                        $('#nombre_responsable_recoger').addClass("is-invalid")
                        toastr.error("Ingrese el Nombre del responsable.", 'Error');
                        $('#error-nombre_responsable_recoger').text(
                            "El campo Nombre del responsable es obligatorio.")
                    }
                    if ($('#responsable_pago').val() == '') {
                        enviar = false
                        $('#responsable_pago').addClass("is-invalid")
                        toastr.error("Ingrese el Modo de cancelación.", 'Error');
                        $('#error-responsable_pago').text("El campo Modo es obligatorio.")
                    }
                    break;
                case "7":
                    if ($('#nombre_transporte_domicilio').val() == '') {
                        enviar = false
                        $('#nombre_transporte_domicilio').addClass("is-invalid")
                        toastr.error("Ingrese el Nombre del transporte.", 'Error');
                        $('#error-nombre_transporte_domicilio').text(
                            "El campo Nombre del Transporte es obligatorio.")
                    }
                    if ($('#ruc_transporte_domicilio').val() == '') {
                        enviar = false
                        $('#ruc_transporte_domicilio').addClass("is-invalid")
                        toastr.error("Ingrese Ruc del Transportista.", 'Error');
                        $('#error-ruc_transporte_domicilio').text("El campo Ruc del Transporte es obligatorio.")
                    }
                    if ($('#direccion_domicilio').val() == '') {
                        enviar = false
                        $('#direccion_domicilio').addClass("is-invalid")
                        toastr.error("Ingrese la dirección del domicilio.", 'Error');
                        $('#error-direccion_domicilio').text("El campo Dirección del domicilio es obligatorio.")
                    }
                    break;
                default:
                    if ($('#condicion_reparto').val() == '') {
                        enviar = false
                        $('#condicion_reparto').addClass("is-invalid")
                        toastr.error("Ingrese la condición de Reparto.", 'Error');
                        $('#error-condicion_reparto').text("El campo Condición Reparto es obligatorio.")
                    }
            }
            return enviar
        })

        function limpiarErrores() {
            $('#tipo_tienda').removeClass("is-invalid")
            $('#error-tipo').text("")
            $('#tipo_negocio').removeClass("is-invalid")
            $('#error-negocio').text("")
            $('#nombre').removeClass("is-invalid")
            $('#error-nombre').text("")
            $('#direccion').removeClass("is-invalid")
            $('#error-direccion').text("")
            //CONDICION DE ENVIO
            $('#ruc_transporte_oficina').removeClass("is-invalid")
            $('#error-ruc_transporte_oficina').text("")
            $('#nombre_transporte_oficina').removeClass("is-invalid")
            $('#error-nombre_transporte_oficina').text("")
            $('#direccion_transporte_oficina').removeClass("is-invalid")
            $('#error-direccion_transporte_oficina').text("")
            $('#responsable_pago_flete').removeClass("is-invalid")
            $('#error-responsable_pago_flete').text("")
            $('#dni_responsable_recoger').removeClass("is-invalid")
            $('#error-dni_responsable_recoger').text("")
            $('#nombre_responsable_recoger').removeClass("is-invalid")
            $('#error-nombre_responsable_recoger').text("")
            $('#nombre_responsable_pago').removeClass("is-invalid")
            $('#error-responsable_pago').text("")
            $('#ruc_transporte_domicilio').removeClass("is-invalid")
            $('#error-ruc_transporte_domicilio').text("")
            $('#nombre_transporte_domicilio').removeClass("is-invalid")
            $('#error-nombre_transporte_domicilio').text("")
            $('#direccion_domicilio').removeClass("is-invalid")
            $('#error-direccion_domicilio').text("")
            $('#condicion_reparto').removeClass("is-invalid")
            $('#error-condicion_reparto').text("")
            $('#estado_responsable_recoger').val('SIN VERIFICAR')
        }
        // IMAGEN
        function limpiar() {
            $('.logo').attr("src", "{{ asset('storage/Clientes/img/default.png') }}")
            var fileName = "Seleccionar"
            $('.custom-file-label').addClass("selected").html(fileName);
            $('#logo').val('')
        }

        function limpiarmarcadores() {
            markers.forEach((value, index, array) => {
                value.setMap(null);
            })
            markers = [];
        }

        function consultarUrl() {
            var url = $("#urlgps").val();
            var cadena = url.substring(url.search("/@") + 2, url.length - 1);
            var lat = cadena.substring(0, cadena.search(","));
            var cadena = cadena.substring(cadena.search(",") + 1, cadena.length - 1);
            var lng = cadena.substring(0, cadena.search(","));
            limpiarmarcadores()
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(lat),
                        lng: parseFloat(lng)
                    },
                    map: map,
                    draggable: true
                });
                markers.push(marker)
                google.maps.event.addListener(marker, "dragend", function(event) {
                    $("#lat").val(this.getPosition().lat());
                    $("#lng").val(this.getPosition().lng());
                    map.setCenter(this.getPosition())
                    map.setZoom(18);
                });
                map.setCenter({
                    lat: parseFloat(lat),
                    lng: parseFloat(lng)
                });
        }

        function seleccionarimagen() {
            var fileInput = document.getElementById('logo');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            $imagenPrevisualizacion = document.querySelector(".logo");
            if (allowedExtensions.exec(filePath)) {
                var userFile = document.getElementById('logo');
                userFile.src = URL.createObjectURL(event.target.files[0]);
                var data = userFile.src;
                $imagenPrevisualizacion.src = data
                let fileName = $('#logo').val().split('\\').pop();
                $('#logo').next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
                $('.logo').attr("src", "{{ asset('storage/Clientes/img/default.png') }}")
            }
        }
        //
        //ENVIOS TAB
        $(document).ready(function() {
            //Mapa
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: {
                    lat: -8.1092027,
                    lng: -79.0244529
                },
                gestureHandling: "greedy",
                zoomControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: true,
            });
            const input = document.getElementById("pac-input");
            //
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            const cajadetexto = new google.maps.places.SearchBox(input);
            map.addListener("bounds_changed", () => {
                cajadetexto.setBounds(map.getBounds());
            });
            cajadetexto.addListener("places_changed", () => {
                const places = cajadetexto.getPlaces();

                if (places.length == 0) {
                    return;
                }
                console.log(places.length)
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                if (places.length == 1) {
                    limpiarmarcadores()
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        // Create a marker for each place.
                        var marker=  new google.maps.Marker({
                                map,
                                position: place.geometry.location,

                    draggable: true
                            });
                        markers.push(
                          marker
                        );
                        $("#lat").val(marker.getPosition().lat());
                        $("#lng").val(marker.getPosition().lng());
                        google.maps.event.addListener(marker, "dragend", function(event) {
                            $("#lat").val(this.getPosition().lat());
                            $("#lng").val(this.getPosition().lng());
                            map.setCenter(this.getPosition())
                    map.setZoom(18);
                        });

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                }
                map.fitBounds(bounds);
            });
            //
            google.maps.event.addListener(map, "click", function(event) {
                limpiarmarcadores()
                    var marker = new google.maps.Marker({
                        position: event.latLng,
                        map: map,
                        draggable: true
                    });
                    map.setCenter(event.latLng)
                    map.setZoom(18);
                    markers.push(marker);
                    $("#lat").val(marker.getPosition().lat());
                    $("#lng").val(marker.getPosition().lng());
                    google.maps.event.addListener(marker, "dragend", function(event) {
                        $("#lat").val(this.getPosition().lat());
                        $("#lng").val(this.getPosition().lng());
                        map.setCenter(this.getPosition())
                    map.setZoom(18);
                    });

            });
            switch ($('#condicion_reparto').val()) {
                case "6":
                    $('#reparto_domicilio').css("display", "none")
                    $('#reparto_oficina').css("display", "")
                    $('#ruc_transporte_oficina').prop('disabled', false)
                    $('#nombre_transporte_oficina').prop('disabled', false)
                    $('#direccion_transporte_oficina').prop('disabled', false)
                    $('#responsable_pago_flete').prop('disabled', false)
                    $('#dni_responsable_recoger').prop('disabled', false)
                    $('#nombre_responsable_recoger').prop('disabled', false)
                    $('#responsable_pago_flete').prop('disabled', false)
                    $('#telefono_responsable_recoger').prop('disabled', false)
                    $('#observacion_envio').prop('disabled', false)
                    $('#responsable_pago').prop('disabled', false)
                    $('#responsable_pago').val($('#responsable_pago option:first-child').val()).trigger('change');
                    break;
                case "7":
                    $('#reparto_domicilio').css("display", "")
                    $('#reparto_oficina').css("display", "none")
                    $('#ruc_transporte_domicilio').prop('disabled', false)
                    $('#nombre_transporte_domicilio').prop('disabled', false)
                    $('#direccion_domicilio').prop('disabled', false)
                    $('#dni_contacto_recoger').prop('disabled', false)
                    $('#nombre_contacto_recoger').prop('disabled', false)
                    $('#telefono_contacto_recoger').prop('disabled', false)
                    $('#observacion_domicilio').prop('disabled', false)
                    break;
                default:
                    $('#ruc_transporte_oficina').prop('disabled', true)
                    $('#nombre_transporte_oficina').prop('disabled', true)
                    $('#direccion_transporte_oficina').prop('disabled', true)
                    $('#responsable_pago_flete').prop('disabled', true)
                    $('#responsable_pago').prop('disabled', true)
                    $('#responsable_pago').val($('#responsable_pago option:first-child').val()).trigger('change');
                    $('#dni_responsable_recoger').prop('disabled', true)
                    $('#nombre_responsable_recoger').prop('disabled', true)
                    $('#responsable_pago_flete').prop('disabled', true)
                    $('#telefono_responsable_recoger').prop('disabled', true)
                    $('#observacion_envio').prop('disabled', true)
                    $('#ruc_transporte_domicilio').prop('disabled', true)
                    $('#nombre_transporte_domicilio').prop('disabled', true)
                    $('#direccion_domicilio').prop('disabled', true)
                    $('#dni_contacto_recoger').prop('disabled', true)
                    $('#nombre_contacto_recoger').prop('disabled', true)
                    $('#telefono_contacto_recoger').prop('disabled', true)
                    $('#observacion_domicilio').prop('disabled', true)
            }
        })

        function limpiarDomicilio() {
            $('#ruc_transporte_domicilio').val('')
            $('#estado_transporte_domicilio').val('SIN VERIFICAR')
            $('#estado_dni_contacto_recoger').val('SIN VERIFICAR')
            $('#nombre_transporte_domicilio').val('')
            $('#direccion_domicilio').val('')
            $('#dni_contacto_recoger').val('')
            $('#nombre_contacto_recoger').val('')
            $('#telefono_contacto_recoger').val('')
            $('#observacion_domicilio').val('')
        }

        function limpiarOficina() {
            $('#ruc_transporte_oficina').val('')
            $('#estado_transporte_oficina').val('SIN VERIFICAR')
            $('#nombre_transporte_oficina').val('')
            $('#direccion_transporte_oficina').val('')
            $('#responsable_pago_flete').val('')
            $('#dni_responsable_recoger').val('')
            $('#nombre_responsable_recoger').val('')
            $('#responsable_pago_flete').val('')
            $('#responsable_pago').val($('#responsable_pago option:first-child').val()).trigger('change');
            $('#telefono_responsable_recoger').val('')
            $('#observacion_envio').val('')
        }
        $("#dni_responsable_recoger").keyup(function() {
            if ($('#estado_responsable_recoger').val('ACTIVO')) {
                $('#estado_responsable_recoger').val('SIN VERIFICAR')
            }
        })
        $("#nombre_responsable_recoger").keyup(function() {
            if ($('#estado_responsable_recoger').val('ACTIVO')) {
                $('#estado_responsable_recoger').val('SIN VERIFICAR')
            }
        })
        $("#dni_contacto_recoger").keyup(function() {
            if ($('#estado_dni_contacto_recoger').val('ACTIVO')) {
                $('#estado_dni_contacto_recoger').val('SIN VERIFICAR')
            }
        })
        $("#dni_responsable_recoger").keyup(function() {
            if ($('#estado_responsable_recoger').val('ACTIVO')) {
                $('#estado_responsable_recoger').val('SIN VERIFICAR')
            }
        })
        $("#ruc_transporte_domicilio").keyup(function() {
            if ($('#estado_transporte_domicilio').val('ACTIVO')) {
                $('#estado_transporte_domicilio').val('SIN VERIFICAR')
            }
        })
        $("#condicion_reparto").on('change', function(e) {
            limpiarErrores()
            $('#estado_responsable_recoger').val('SIN VERIFICAR')
            switch ($(this).val()) {
                case "6":
                    $('#reparto_domicilio').css("display", "none")
                    $('#reparto_oficina').css("display", "")
                    $('#estado_transporte_domicilio').val("SIN VERIFICAR")
                    $('#ruc_transporte_oficina').prop('disabled', false)
                    $('#nombre_transporte_oficina').prop('disabled', false)
                    $('#direccion_transporte_oficina').prop('disabled', false)
                    $('#responsable_pago_flete').prop('disabled', false)
                    $('#responsable_pago').prop('disabled', false)
                    $('#dni_responsable_recoger').prop('disabled', false)
                    $('#nombre_responsable_recoger').prop('disabled', false)
                    $('#responsable_pago_flete').prop('disabled', false)
                    $('#telefono_responsable_recoger').prop('disabled', false)
                    $('#observacion_envio').prop('disabled', false)
                    limpiarDomicilio()
                    break;
                case "7":
                    $('#reparto_domicilio').css("display", "")
                    $('#reparto_oficina').css("display", "none")
                    $('#estado_transporte_domicilio').val("SIN VERIFICAR")
                    $('#ruc_transporte_domicilio').prop('disabled', false)
                    $('#nombre_transporte_domicilio').prop('disabled', false)
                    $('#direccion_domicilio').prop('disabled', false)
                    $('#nombre_contacto_recoger').prop('disabled', false)
                    $('#dni_contacto_recoger').prop('disabled', false)
                    $('#estado_dni_contacto_recoger').val("SIN VERIFICAR")
                    $('#telefono_contacto_recoger').prop('disabled', false)
                    $('#observacion_domicilio').prop('disabled', false)
                    limpiarOficina()
                    break;
                default:
                    $('#ruc_transporte_oficina').prop('disabled', true)
                    $('#nombre_transporte_oficina').prop('disabled', true)
                    $('#direccion_transporte_oficina').prop('disabled', true)
                    $('#responsable_pago_flete').prop('disabled', true)
                    $('#dni_responsable_recoger').prop('disabled', true)
                    $('#nombre_responsable_recoger').prop('disabled', true)
                    $('#responsable_pago_flete').prop('disabled', true)
                    $('#telefono_responsable_recoger').prop('disabled', true)
                    $('#observacion_envio').prop('disabled', true)
                    $('#ruc_transporte_domicilio').prop('disabled', true)
                    $('#nombre_transporte_domicilio').prop('disabled', true)
                    $('#direccion_domicilio').prop('disabled', true)
                    $('#nombre_contacto_recoger').prop('disabled', true)
                    $('#dni_contacto_recoger').prop('disabled', true)
                    $('#telefono_contacto_recoger').prop('disabled', true)
                    $('#observacion_domicilio').prop('disabled', true)
                    limpiarOficina()
                    limpiarDomicilio()
            }
        })
        // Consulta Dni
        function consultarDni() {
            var dni = $('#dni_responsable_recoger').val()
            if (dni.length == 8) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Dni a Reniec?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApidni', ':dni') }}';
                        url = url.replace(':dni', dni);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_responsable_recoger').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Dni Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    camposDni(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Dni debe de contar con 8 dígitos', 'Error');
            }
        }

        function camposDni(objeto) {
            var nombres = objeto.value.nombres;
            var apellidopa = objeto.value.apellidoPaterno;
            var apellidoma = objeto.value.apellidoMaterno;
            var nombre_completo = []
            if (nombres != "-" && nombres != null) {
                nombre_completo.push(nombres)
            }
            if (apellidopa != "-" && apellidopa != null) {
                nombre_completo.push(apellidopa)
            }
            if (apellidoma != "-" && apellidoma != null) {
                nombre_completo.push(apellidoma)
            }
            $('#nombre_responsable_recoger').val(nombre_completo.join(' '))
            $('#estado_responsable_recoger').val('ACTIVO')
        }
        // Consulta Dni
        function consultarReniecContacto() {
            var dni = $('#dni_contacto_recoger').val()
            if (dni.length == 8) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Dni a Reniec?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApidni', ':dni') }}';
                        url = url.replace(':dni', dni);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_dni_contacto_recoger').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Dni Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    camposDnicontacto(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Dni debe de contar con 8 dígitos', 'Error');
            }
        }

        function camposDnicontacto(objeto) {
            var nombres = objeto.value.nombres;
            var apellidopa = objeto.value.apellidoPaterno;
            var apellidoma = objeto.value.apellidoMaterno;
            var nombre_completo = []
            if (nombres != "-" && nombres != null) {
                nombre_completo.push(nombres)
            }
            if (apellidopa != "-" && apellidopa != null) {
                nombre_completo.push(apellidopa)
            }
            if (apellidoma != "-" && apellidoma != null) {
                nombre_completo.push(apellidoma)
            }
            $('#nombre_contacto_recoger').val(nombre_completo.join(' '))
            $('#estado_dni_contacto_recoger').val('ACTIVO')
        }

        function consultarRuc() {
            // limpiarErrores()
            var ruc = $('#ruc_transporte_domicilio').val()
            if (ruc.length == 11) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Ruc a Sunat?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApiruc', ':ruc') }}';
                        url = url.replace(':ruc', ruc);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_transporte_domicilio').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Ruc Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                    camposRuc(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Ruc debe de contar con 11 dígitos', 'Error');
            }
        }

        function camposRuc(objeto) {
            var razonsocial = objeto.value.razonSocial;
            var direccion = objeto.value.direccion;
            var departamento = objeto.value.departamento;
            var provincia = objeto.value.provincia;
            var distrito = objeto.value.distrito;
            var estado = objeto.value.estado;
            if (razonsocial != '-' && razonsocial != "NULL") {
                $('#nombre_transporte_domicilio').val(razonsocial)
            }
            if (estado == "ACTIVO") {
                $('#estado_transporte_domicilio').val(estado)
            } else {
                $('#estado_transporte_domicilio').val('INACTIVO')
            }
            if (direccion != '-' && direccion != "NULL") {
                $('#direccion_domicilio').val(direccion + " - " + departamento + " - " + provincia + " - " + distrito)
            }
        }

        function consultarRucoficina() {
            // limpiarErrores()
            var ruc = $('#ruc_transporte_oficina').val()
            if (ruc.length == 11) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Ruc a Sunat?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApiruc', ':ruc') }}';
                        url = url.replace(':ruc', ruc);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_transporte_oficina').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Ruc Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                    camposRucoficina(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Ruc debe de contar con 11 dígitos', 'Error');
            }
        }

        function camposRucoficina(objeto) {
            var razonsocial = objeto.value.razonSocial;
            var direccion = objeto.value.direccion;
            var departamento = objeto.value.departamento;
            var provincia = objeto.value.provincia;
            var distrito = objeto.value.distrito;
            var estado = objeto.value.estado;
            if (razonsocial != '-' && razonsocial != "NULL") {
                $('#nombre_transporte_oficina').val(razonsocial)
            }
            if (estado == "ACTIVO") {
                $('#estado_transporte_oficina').val(estado)
            } else {
                $('#estado_transporte_oficina').val('INACTIVO')
            }
            if (direccion != '-' && direccion != "NULL") {
                $('#direccion_transporte_oficina').val(direccion + " - " + departamento + " - " + provincia + " - " +
                    distrito)
            }
        }
        // Consultar Administrativo
        function consultarDniAdmin() {
            var dni = $('#dni_contacto_admin').val()
            if (dni.length == 8) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Dni a Reniec?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApidni', ':dni') }}';
                        url = url.replace(':dni', dni);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_dni_contacto_admin').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Dni Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    camposDnicontactoAdmin(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Dni debe de contar con 8 dígitos', 'Error');
            }
        }

        function camposDnicontactoAdmin(objeto) {
            var nombres = objeto.value.nombres;
            var apellidopa = objeto.value.apellidoPaterno;
            var apellidoma = objeto.value.apellidoMaterno;
            var nombre_completo = []
            if (nombres != "-" && nombres != null) {
                nombre_completo.push(nombres)
            }
            if (apellidopa != "-" && apellidopa != null) {
                nombre_completo.push(apellidopa)
            }
            if (apellidoma != "-" && apellidoma != null) {
                nombre_completo.push(apellidoma)
            }
            $('#nombre_administrador').val(nombre_completo.join(' '))
            $('#estado_dni_contacto_admin').val('ACTIVO')
        }
        $("#dni_contacto_admin").keyup(function() {
            if ($('#estado_dni_contacto_admin').val('ACTIVO')) {
                $('#estado_dni_contacto_admin').val('SIN VERIFICAR')
            }
        })
        $("#nombre_administrador").keyup(function() {
            if ($('#estado_dni_contacto_admin').val('ACTIVO')) {
                $('#estado_dni_contacto_admin').val('SIN VERIFICAR')
            }
        })
        //Contacto Credito
        function consultarDniCredito() {
            var dni = $('#dni_contacto_credito').val()
            if (dni.length == 8) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Dni a Reniec?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApidni', ':dni') }}';
                        url = url.replace(':dni', dni);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_dni_contacto_credito').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Dni Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    camposDnicontactoCredito(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Dni debe de contar con 8 dígitos', 'Error');
            }
        }

        function camposDnicontactoCredito(objeto) {
            var nombres = objeto.value.nombres;
            var apellidopa = objeto.value.apellidoPaterno;
            var apellidoma = objeto.value.apellidoMaterno;
            var nombre_completo = []
            if (nombres != "-" && nombres != null) {
                nombre_completo.push(nombres)
            }
            if (apellidopa != "-" && apellidopa != null) {
                nombre_completo.push(apellidopa)
            }
            if (apellidoma != "-" && apellidoma != null) {
                nombre_completo.push(apellidoma)
            }
            $('#nombre_credito').val(nombre_completo.join(' '))
            $('#estado_dni_contacto_credito').val('ACTIVO')
        }
        $("#dni_contacto_credito").keyup(function() {
            if ($('#estado_dni_contacto_credito').val('ACTIVO')) {
                $('#estado_dni_contacto_credito').val('SIN VERIFICAR')
            }
        })
        $("#nombre_credito").keyup(function() {
            if ($('#estado_dni_contacto_credito').val('ACTIVO')) {
                $('#estado_dni_contacto_credito').val('SIN VERIFICAR')
            }
        })
        //Contacto Vendedor
        function consultarDniVendedor() {
            var dni = $('#dni_contacto_vendedor').val()
            if (dni.length == 8) {
                Swal.fire({
                    title: 'Consultar',
                    text: "¿Desea consultar Dni a Reniec?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        var url = '{{ route('getApidni', ':dni') }}';
                        url = url.replace(':dni', dni);
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                console.log(error)
                                $('#estado_dni_contacto_vendedor').val('SIN VERIFICAR')
                                Swal.showValidationMessage(
                                    `Dni Inválido`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    camposDnicontactoVendedor(result)
                    consultaExitosa()
                })
            } else {
                toastr.error('El campo Dni debe de contar con 8 dígitos', 'Error');
            }
        }

        function camposDnicontactoVendedor(objeto) {
            var nombres = objeto.value.nombres;
            var apellidopa = objeto.value.apellidoPaterno;
            var apellidoma = objeto.value.apellidoMaterno;
            var nombre_completo = []
            if (nombres != "-" && nombres != null) {
                nombre_completo.push(nombres)
            }
            if (apellidopa != "-" && apellidopa != null) {
                nombre_completo.push(apellidopa)
            }
            if (apellidoma != "-" && apellidoma != null) {
                nombre_completo.push(apellidoma)
            }
            $('#nombre_vendedor').val(nombre_completo.join(' '))
            $('#estado_dni_contacto_vendedor').val('ACTIVO')
        }
        $("#dni_contacto_vendedor").keyup(function() {
            if ($('#estado_dni_contacto_vendedor').val('ACTIVO')) {
                $('#estado_dni_contacto_vendedor').val('SIN VERIFICAR')
            }
        })
        $("#nombre_vendedor").keyup(function() {
            if ($('#estado_dni_contacto_vendedor').val('ACTIVO')) {
                $('#estado_dni_contacto_vendedor').val('SIN VERIFICAR')
            }
        })

    </script>
@endpush
