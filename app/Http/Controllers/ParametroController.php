<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParametroController extends Controller
{
    public function apiRuc($ruc)
    {
        // $parametro = consultaRuc();
        // $http = $parametro->http.$ruc.$parametro->token;
        // $request = Http::get($http);
        // $resp = $request->json();

        $url = "https://apiperu.dev/api/ruc/".$ruc;
        $client = new \GuzzleHttp\Client();
        $token = '4b297f3cf07f893870d7d3db9b22e10ea47a8340e2bef32a3b8ca94153ae5a1c';
        $response = $client->get($url, [
            'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$token}"
                    ]
        ]); 
        $estado = $response->getStatusCode();
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function apiDni($dni)
    {
        // $parametro = consultaDni();
        // $http = $parametro->http.$dni.$parametro->token;
        // $request = Http::get($http);
        // $resp = $request->json();
        // return $resp;

        $url = "https://apiperu.dev/api/dni/".$dni;
            $client = new \GuzzleHttp\Client();
            $token = '4b297f3cf07f893870d7d3db9b22e10ea47a8340e2bef32a3b8ca94153ae5a1c';
            $response = $client->get($url, [
                'headers' => [
                            'Content-Type' => 'application/json', 
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer {$token}"
                        ]
            ]);
        $estado = $response->getStatusCode();
        $data = $response->getBody()->getContents();

        return $data;
    }
}
