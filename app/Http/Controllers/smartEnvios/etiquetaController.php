<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use App\Models\UelloPedidos;
use Illuminate\Http\Request;

class etiquetaController extends Controller
{

    private requestSmartEnviosController $data;

    public function __construct(requestSmartEnviosController $data)
    {
        $this->data = $data;
    }

    public function resource()
    {
        return $this->get('ticket-pdf');
    }

    public function get($resource)
    {

        $tipoData = "Content-Type: application/json";
        $token = "token: jsVC2QAsoHijI0ULb7hkyku9kq8117nw";

        $postData = [
            'order_ids' => [$this->getData()->getFreightOrderId()],
        ];



        // URL PARA REQUISICAO ENDPOINT
        $endpoint = URL_BASE . $resource;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$tipoData, $token]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, true);

        if ($httpCode == 200) {
            if ($requisicao["body-json"]["url"]) {
                UelloPedidos::where('freight_order_id', $this->getData()->getFreightOrderId())->update(['etiqueta' => $requisicao["body-json"]["url"]]);
            }
        } else {
            return $requisicao;
        }
    }

    /**
     * Get the value of data
     */
    public function getData(): requestSmartEnviosController
    {
        return $this->data;
    }
}
