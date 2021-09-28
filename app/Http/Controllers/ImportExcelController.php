<?php

namespace App\Http\Controllers;

use App\Imports\Categoria\CategoriaImport;
use App\Imports\Cliente\ClienteImport;
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
}
