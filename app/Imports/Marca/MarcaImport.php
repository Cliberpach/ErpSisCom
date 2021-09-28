<?php

namespace App\Imports\Marca;

use App\Almacenes\Categoria;
use App\Almacenes\Marca;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class MarcaImport implements ToCollection,WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        Log::info($collection);
        foreach ($collection as  $row) {
            if($row['marca']!=null && $row['procedencia'] && Marca::where('marca',$row['marca'])->count()==0) {
                $marca=new Marca();
                $marca->marca=$row['marca'];
                $marca->procedencia=$row['procedencia'];
                $marca->save();
            }
        }
    }
}
