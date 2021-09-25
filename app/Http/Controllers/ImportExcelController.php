<?php

namespace App\Http\Controllers;

use App\Imports\Cliente\ClienteImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function uploadcliente(Request $request)
    {
        $data = array();
        $file = $request->file();
        $archivo = $file['files'][0];
        // $objeto = new DataExcel();
        // Excel::import($objeto, $archivo);

        // $datos = $objeto->data;

        // try {
            Excel::import(new ClienteImport, $archivo);
        // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

        //     $failures = $e->failures();

        //     foreach ($failures as $failure) {
        //         array_push($data, array(
        //             "fila" => $failure->row(),
        //             "atributo" => $failure->attribute(),
        //             "error" => $failure->errors()
        //         ));
        //     }
        //     array_push($data, array("excel" => $datos));
        // } catch (Exception $er) {
        //     Log::info($er);
        // }

        // return json_encode($data);
    }
}
