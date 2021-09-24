<?php

namespace App\Http\Controllers;

use App\Exports\Cliente\ClienteExport;
use App\Exports\Cliente\ClienteMultiExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ModeloExcelController extends Controller
{
    public function cliente()
    {
        ob_end_clean(); // this
        ob_start();
        return  Excel::download(new ClienteMultiExport(), 'modelo_cliente.xlsx');
    }
}
