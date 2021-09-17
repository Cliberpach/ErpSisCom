<?php

use App\Almacenes\Almacen;
use App\Compras\Articulo;
use App\Compras\Categoria;
use App\Almacenes\Familia;
use App\Almacenes\Producto;
use App\Produccion\ProductoDetalle;
use App\Produccion\SubFamilia;
use Illuminate\Database\Seeder;

class DatosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familia = new Familia();
        $familia->familia = 'familia1';
        $familia->estado = 'ACTIVO';
        $familia->save();

        $familia = new Familia();
        $familia->familia = 'familia2';
        $familia->estado = 'ACTIVO';
        $familia->save();

        $familia = new Familia();
        $familia->familia = 'familia3';
        $familia->estado = 'ACTIVO';
        $familia->save();

        $subfamilia = new SubFamilia();
        $subfamilia->descripcion = 'subfamilia1';
        $subfamilia->familia_id = 1;
        $subfamilia->estado = 'ACTIVO';
        $subfamilia->save();

        $subfamilia = new SubFamilia();
        $subfamilia->descripcion = 'subfamilia2';
        $subfamilia->familia_id = 2;
        $subfamilia->estado = 'ACTIVO';
        $subfamilia->save();

        $subfamilia = new SubFamilia();
        $subfamilia->descripcion = 'subfamilia3';
        $subfamilia->familia_id = 3;
        $subfamilia->estado = 'ACTIVO';
        $subfamilia->save();

        $categoria = new Categoria();
        $categoria->descripcion = 'categoria1';
        $categoria->estado = 'ACTIVO';
        $categoria->save();

        $categoria = new Categoria();
        $categoria->descripcion = 'categoria2';
        $categoria->estado = 'ACTIVO';
        $categoria->save();

        $categoria = new Categoria();
        $categoria->descripcion = 'categoria3';
        $categoria->estado = 'ACTIVO';
        $categoria->save();

        $almacen = new Almacen();
        $almacen->descripcion = 'almacen1';
        $almacen->ubicacion = 'ubicacion almacen1';
        $almacen->estado = 'ACTIVO';
        $almacen->save();

        $almacen = new Almacen();
        $almacen->descripcion = 'almacen2';
        $almacen->ubicacion = 'ubicacion almacen2';
        $almacen->estado = 'ACTIVO';
        $almacen->save();

        $almacen = new Almacen();
        $almacen->descripcion = 'almacen3';
        $almacen->ubicacion = 'ubicacion almacen3';
        $almacen->estado = 'ACTIVO';
        $almacen->save();

        $articulo = new Articulo();
        $articulo->descripcion = 'articulo1';
        $articulo->codigo_fabrica = 'codigofabrica1';
        $articulo->stock_min = 15;
        $articulo->precio_compra = 5;
        $articulo->presentacion = 'KILOGRAMO';
        $articulo->categoria_id = 1;
        $articulo->almacen_id = 1;
        $articulo->estado = 'ACTIVO';
        $articulo->save();

        $articulo = new Articulo();
        $articulo->descripcion = 'articulo2';
        $articulo->codigo_fabrica = 'codigofabrica2';
        $articulo->stock_min = 20;
        $articulo->precio_compra = 8;
        $articulo->presentacion = 'KILOGRAMO';
        $articulo->categoria_id = 1;
        $articulo->almacen_id = 1;
        $articulo->estado = 'ACTIVO';
        $articulo->save();

        $articulo = new Articulo();
        $articulo->descripcion = 'articulo3';
        $articulo->codigo_fabrica = 'codigofabrica3';
        $articulo->stock_min = 25;
        $articulo->precio_compra = 10;
        $articulo->presentacion = 'KILOGRAMO';
        $articulo->categoria_id = 1;
        $articulo->almacen_id = 1;
        $articulo->estado = 'ACTIVO';
        $articulo->save();

        $producto = new Producto();
        $producto->codigo = 'COD_ISO1';
        $producto->nombre = 'Producto1';
        $producto->familia_id = 1;
        $producto->sub_familia_id = 1;
        $producto->presentacion = 'KG';
        $producto->stock = 250;
        $producto->stock_minimo = 40;
        $producto->precio_venta_minimo = 25;
        $producto->precio_venta_maximo = 36;
        $producto->igv = 1;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new Producto();
        $producto->codigo = 'COD_ISO2';
        $producto->nombre = 'Producto2';
        $producto->familia_id = 3;
        $producto->sub_familia_id = 3;
        $producto->presentacion = 'KG';
        $producto->stock = 200;
        $producto->stock_minimo = 30;
        $producto->precio_venta_minimo = 18;
        $producto->precio_venta_maximo = 29;
        $producto->igv = 1;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new Producto();
        $producto->codigo = 'COD_ISO3';
        $producto->nombre = 'Producto3';
        $producto->familia_id = 2;
        $producto->sub_familia_id = 2;
        $producto->presentacion = 'KG';
        $producto->stock = 350;
        $producto->stock_minimo = 50;
        $producto->precio_venta_minimo = 34;
        $producto->precio_venta_maximo = 46;
        $producto->igv = 1;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 1;
        $producto->articulo_id = 3;
        $producto->cantidad = 1;
        $producto->peso = 5;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 1;
        $producto->articulo_id = 2;
        $producto->cantidad = 3;
        $producto->peso = 15;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 3;
        $producto->articulo_id = 1;
        $producto->cantidad = 2;
        $producto->peso = 10;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 3;
        $producto->articulo_id = 2;
        $producto->cantidad = 5;
        $producto->peso = 25;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 2;
        $producto->articulo_id = 1;
        $producto->cantidad = 4;
        $producto->peso = 20;
        $producto->estado = 'ACTIVO';
        $producto->save();

        $producto = new ProductoDetalle();
        $producto->producto_id = 2;
        $producto->articulo_id = 3;
        $producto->cantidad = 7;
        $producto->peso = 35;
        $producto->estado = 'ACTIVO';
        $producto->save();
    }
}
