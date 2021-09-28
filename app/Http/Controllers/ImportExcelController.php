<?php

namespace App\Http\Controllers;

use App\Imports\Categoria\CategoriaImport;
use App\Imports\Cliente\ClienteImport;
use App\Imports\Marca\MarcaImport;
use App\Imports\Producto\ProductoMultiImport;
use App\Imports\Producto\ProductoSheet;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function uploadcliente(Request $request)
    {
        //$data = array();
        $file = $request->file();
        $archivo = $file['files'][0];
        Excel::import(new ClienteImport, $archivo);
    }
    public function uploadcategoria(Request $request)
    {
        //$data = array();
        $file = $request->file();
        $archivo = $file['files'][0];
        Excel::import(new CategoriaImport, $archivo);
    }
    public function uploadmarca(Request $request)
    {
        //$data = array();
        $file = $request->file();
        $archivo = $file['files'][0];
        Excel::import(new MarcaImport, $archivo);
    }
    public function uploadproducto(Request $request)
    {
        //$data = array();
        $data=array();
        $file=$request->file();
        $archivo=$file['files'][0];
        $objeto=new ProductoSheet();
        Excel::import($objeto,$archivo);

        $datos= $objeto->get_data();

        // try
        // {
            Excel::import(new ProductoMultiImport,$archivo);

        // }
        // catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

        //     $failures = $e->failures();

        //     foreach ($failures as $failure) {
        //         array_push($data,array(
        //             "fila"=>$failure->row(),
        //             "atributo"=>$failure->attribute(),
        //             "error"=>$failure->errors()
        //         ));

        //     }
        //     array_push($data,array("excel"=>$datos));

        // }
        // catch (Exception $er)
        // {
        //     //Log::info($er);
        // }

        return json_encode($data);
    }

}
