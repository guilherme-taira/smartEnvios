<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class webhook_tray extends Controller
{
    public function webhook(Request $request){

        Log::alert($request->all());
        if (!function_exists('getallheaders')) {
            function getallheaders() {
                $headers = [];
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }
        }


        $AuthTray = new AuthTrayEmbaleme('9dec7ed695dbf7eac41b56c5a3fd122a8f4ef5ea40a733b12e54ff062f76c6eb', 'c6b66367fc609afa2968275dff7971258b0365eceaec8b380b06fe37c9968e25', '62c4367b4a7472222886403203d96edc83f7df6a9a5cdbe3011f19bd56a11bed');
        $auth = $AuthTray->resource();

        $input = file_get_contents('php://input');
        $trayOrder = new TrayWebHookController($input,$auth->access_token);
        $order = new GetPedidosComplete($trayOrder);
        $order->shipmentIntegrator();

    }
}
