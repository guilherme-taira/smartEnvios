<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use App\Models\UelloPedidos;
use Illuminate\Http\Request;

const URL_BASE = "https://api.smartenvios.com/v1/";

class requestSmartEnviosController extends Controller
{
    private $baseId;
    private $freight_order_id;
    private $file;
    private $token;


    public function __construct($baseId, $freight_order_id, $file,$token)
    {
        $this->baseId = $baseId;
        $this->freight_order_id = $freight_order_id;
        $this->file = $file;
        $this->token = $token;
    }


    public function resource()
    {
        return $this->get('nfe-upload?base_id='. $this->getBaseId().'&freight_order_id='.$this->getFreightOrderId());
    }

    public function get($resource)
    {

        $tipoData = "Content-Type: multipart/form-data";
        $token = "token: {$this->getToken()}";

        $cFile = new \CURLFile($this->getFile()->getRealPath(), $this->getFile()->getClientMimeType(), $this->getFile()->getClientOriginalName());

        $postData = [
            'file' => $cFile,
        ];

        // URL PARA REQUISICAO ENDPOINT
        $endpoint = URL_BASE . $resource;
        echo $endpoint . "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$tipoData, $token]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, true);

        if($httpCode == 200){
            UelloPedidos::where('freight_order_id',$this->getFreightOrderId())->update(["NFenviada" => 1]);
            return $httpCode;
        }else{
            return $requisicao;
        }

    }

    /**
     * Get the value of baseId
     */
    public function getBaseId()
    {
        return $this->baseId;
    }

    /**
     * Get the value of freight_order_id
     */
    public function getFreightOrderId()
    {
        return $this->freight_order_id;
    }

    /**
     * Get the value of file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }
}
