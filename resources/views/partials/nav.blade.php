<li class="nav-header">
    <div class="dropdown profile-element">

        @if (auth()->user()->ruta_imagen)
            <img alt="image" alt="{{ auth()->user()->name }}" class="rounded-circle" height="48" width="48"
                src="{{ Storage::url(auth()->user()->ruta_imagen) }}" />
        @else
            <img alt="{{ auth()->user()->name }}" alt="{{ auth()->user()->name }}" class="rounded-circle"
                height="48" width="48" src="{{ asset('img/default.jpg') }}" />

        @endif


        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
            <span class="text-muted text-xs block">Administrador <b class="caret"></b></span>
        </a>
        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a class="dropdown-item" href="login.html">Cerrar Sesión</a></li>
        </ul>
    </div>
    <div class="logo-element">
        <img src="{{ asset('img/ecologo.jpeg') }}" height="30" width="45">
    </div>
</li>



<li>
    <a href="{{ route('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Panel de control</span></a>
</li>

<li class="@yield('caja_chica-active')">
    <a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Caja Chica</span></a>
</li>

<li class="@yield('compras-active')">
    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Compras</span><span
            class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('proveedor-active')"><a href="{{route('compras.proveedor.index')}}">Proveedores</a></li>
        <li class="@yield('orden-compra-active')"><a href="{{route('compras.orden.index')}}">Orden Compra</a></li>          
        <li class="@yield('documento-active')"><a href="{{route('compras.documento.index')}}">Doc. Compra</a>
        </li>
    </ul>
</li>

<li class="@yield('ventas-active')">
    <a href="#"><i class="fa fa-signal"></i> <span class="nav-label">Ventas</span><span
            class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('clientes-active')"><a href="{{ route('ventas.cliente.index') }}">Clientes</a></li>
        <li class="@yield('cotizaciones-active')"><a href="{{ route('ventas.cotizacion.index') }}">Cotizaciones</a></li>
        <li class="@yield('documento-active')"><a href="{{ route('ventas.documento.index') }}">Doc. Venta</a></li>
        <li class="@yield('guias-remision-active')"><a href="{{ route('ventas.guiasremision.index') }}">Guias de Remision</a></li>
    </ul>
</li>

<li class="@yield('almacenes-active')">
    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Almacén</span><span
            class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('almacen-active')"><a href="{{ route('almacenes.almacen.index') }}">Almacén</a></li>
        <li class="@yield('categoria-active')"><a href="{{ route('almacenes.categorias.index') }}">Categoria</a></li>
        <li class="@yield('marca-active')"><a href="{{ route('almacenes.marcas.index') }}">Marca</a></li>
        <li class="@yield('producto-active')"><a href="{{ route('almacenes.producto.index') }}">Producto</a></li>
        <li class="@yield('nota_ingreso-active')"><a href="{{ route('almacenes.nota_ingreso.index') }}">Nota Ingreso</a></li>
        <li class="@yield('nota_salidad-active')"><a href="{{route('almacenes.nota_salidad.index')}}">Nota Salida</a></li>
    </ul>
</li>

<li class="@yield('cuentas-active')">
    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Cuentas </span><span
            class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('proveedor_cuentas-active')"><a href="#">Proveedor</a></li>
        <li class="@yield('clientes_cuentas-active')"><a href="#">Clientes</a></li>
    </ul>
</li>

<li class="@yield('consulta-active')">
    <a href="#"><i class="fa fa-question-circle"></i> <span class="nav-label">Consulta </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li>
            <a href="#">Ventas <span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="#">Cotización</a></li>
                <li><a href="#">Doc. Venta</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Compras <span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="#">Orden de Compra</a></li>
                <li><a href="#">Doc. Compras</a></li>
            </ul>
        </li>        
        <li class="@yield('cuenta_proveedor-active')"><a href="#">Cuenta Proveedor</a></li>
        <li class="@yield('cuenta_cliente-active')"><a href="#">Cuenta Cliente</a></li>
        <li class="@yield('nota_salida_consulta-active')"><a href="#">Nota Salida</a></li>
        <li class="@yield('nota_ingreso_consulta-active')"><a href="#">Nota Ingreso</a></li>
        <li class="@yield('utilidad_bruta-active')"><a href="#">Utilidad Bruta</a></li>
    </ul>
</li>

<li class="@yield('reporte-active')">
    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Reporte </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('caja_diaria-active')"><a href="#">Caja Diaria</a></li>
        <li class="@yield('ventas_reporte-active')"><a href="#">Ventas</a></li>
        <li class="@yield('compras_reporte-active')"><a href="#">Compras</a></li>
        <li class="@yield('nota_salida_reporte-active')"><a href="#">Nota Salida</a></li>
        <li class="@yield('nota_ingreso_reporte-active')"><a href="#">Nota Ingreso</a></li>
        <li class="@yield('cuentas_x_cobrar_reporte-active')"><a href="#">Cuentas por Cobrar</a></li>
        <li class="@yield('cuentas_x_pagar_reporte-active')"><a href="#">Cuentas por Pagar</a></li>
        <li class="@yield('stock_valorizado_reporte-active')"><a href="#">Stock Valorizado</a></li>
    </ul>
</li>

<li class="@yield('kardex-active')">
    <a href="#"><i class="fa fa-exclamation"></i> <span class="nav-label">Kardex</span><span
            class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('proveedor_kardex-active')"><a href="#">Proveedor</a></li>
        <li class="@yield('cliente_kardex-active')"><a href="#">Cliente</a></li>
        <li class="@yield('producto_kardex-active')"><a href="#">Producto</a></li>
    </ul>
</li>


<li class="@yield('mantenimiento-active')">
    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Mantenimento</span><span
        class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="@yield('colaboradores-active')"><a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a></li>
        <li class="@yield('vendedores-active')"><a href="{{ route('mantenimiento.vendedor.index') }}">Vendedores</a></li>
        <li class="@yield('empresas-active')"><a href="{{ route('mantenimiento.empresas.index') }}">Empresas</a></li>
        <li class="@yield('tablas-active')"><a href="{{ route('mantenimiento.tabla.general.index') }}">Tablas Generales</a></li>
    </ul>
</li>

<li class="@yield('seguridad-active')">
    <a href="#"><i class="fa fa-key"></i> <span class="nav-label">Seguridad</span></a>
</li>
