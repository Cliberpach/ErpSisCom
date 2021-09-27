@extends('layout')

@section('content')

@section('mantenimiento-active', 'active')
@section('colaboradores-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Datos del Colaborador: {{ $colaborador->persona_trabajador->persona->getApellidosYNombres() }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Datos</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-personales"> Datos Personales</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-contacto"> Datos de Contacto</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-laborales">Datos Laborales</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-adicionales">Datos Adicionales</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-personales" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Tipo de documento</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->tipo_documento }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Nro. Documento</strong></label>
                                    <p class="text-navy">{{ $colaborador->persona_trabajador->persona->documento }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Nombre(s)</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->nombres }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Apellido paterno</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->apellido_paterno }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Apellido materno</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->apellido_materno }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12" id="fecha_nacimiento">
                                    <label><strong>Fecha de nacimiento</strong></label>
                                    <p>{{ getFechaFormato($colaborador->persona_trabajador->persona->fecha_nacimiento, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sexo</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->getSexo() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Estado civil</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->getEstadoCivil() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-contacto" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Departamento</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->getDepartamento() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Provincia</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->getProvincia() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Distrito</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->getDistrito() }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Dirección Completa</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->direccion }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono móvil</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->persona->telefono_movil }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono fijo</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->persona->telefono_fijo)) ? $colaborador->persona_trabajador->persona->telefono_fijo : "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-laborales" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Área</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->area }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Profesión</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->profesion }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Cargo</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->cargo }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->moneda_sueldo }} {{ $colaborador->persona_trabajador->sueldo }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo bruto</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->moneda_sueldo }} {{ $colaborador->persona_trabajador->sueldo_bruto }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo neto</strong></label>
                                    <p>{{ $colaborador->persona_trabajador->moneda_sueldo }} {{ $colaborador->persona_trabajador->sueldo_neto }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12" id="fecha_nacimiento">
                                    <label><strong>Banco</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->getBanco())) ? $colaborador->persona_trabajador->getBanco() : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Número de Cuenta</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->numero_cuenta)) ? $colaborador->persona_trabajador->numero_cuenta : "-" }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de inicio de actividad</strong></label>
                                    <p>{{ getFechaFormato($colaborador->persona_trabajador->fecha_inicio_actividad, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de fin de actividad</strong></label>
                                    <p>{{ getFechaFormato($colaborador->persona_trabajador->fecha_fin_actividad, 'd/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de inicio de planilla</strong></label>
                                    <p>{{ getFechaFormato($colaborador->persona_trabajador->fecha_inicio_planilla, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de fin de planilla</strong></label>
                                    <p>{{ getFechaFormato($colaborador->persona_trabajador->fecha_fin_planilla, 'd/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-adicionales" class="tab-pane ">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono de referencia</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->telefono_referencia)) ? $colaborador->persona_trabajador->telefono_referencia : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Contacto de referencia</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->contacto_referencia)) ? $colaborador->persona_trabajador->contacto_referencia : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Número de hijos</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->numero_hijos)) ? $colaborador->persona_trabajador->numero_hijos : "0" }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Grupo sanguíneo</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->grupo_sanguineo)) ? $colaborador->persona_trabajador->grupo_sanguineo : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-8 col-xs-12">
                                    <label><strong>Alergias</strong></label>
                                    <p>{{ (!empty($colaborador->persona_trabajador->alergias)) ? $colaborador->persona_trabajador->alergias : "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="container m-b-xl">
                <a href="{{route('mantenimiento.colaborador.edit',$colaborador->id)}}" class="btn btn-block btn-warning btn-xs float-right"><i class='fa fa-edit'></i>EDITAR COLABORADOR</a>
            </div>
            <div class="container"  onkeyup="return mayus(this)">
                <div class="text-center">
                    @if($colaborador->persona_trabajador->ruta_imagen)
                        <img  src="{{Storage::url($colaborador->persona_trabajador->ruta_imagen)}}" class="img-fluid">
                    @else
                        <img  src="{{asset('storage/empresas/logos/default.png')}}" class="img-fluid">
                    @endif
                <div>
                <div class="text-center m-t-md">
                    @if($colaborador->persona_trabajador->ruta_imagen)
                        <a title="{{$colaborador->persona_trabajador->nombre_imagen}}" download="{{$colaborador->persona_trabajador->nombre_imagen}}" href="{{Storage::url($colaborador->persona_trabajador->ruta_imagen)}}" class="btn btn-xs btn-block btn-primary"><i class="fa fa-download"></i> Descargar Imagen</a>
                    @else
                        <a title="Imagen por defecto" download="Imagen por defecto" href="{{asset('storage/empresas/logos/default.png')}}" class="btn btn-xs btn-block btn-primary"><i class="fa fa-download"></i> Descargar Imagen</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
@endpush
