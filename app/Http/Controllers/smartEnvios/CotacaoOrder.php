<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CotacaoOrder extends Controller
{
    const URL_BASE = "https://api.smartenvios.com/v1/";

        private $createOrder;
        private $token;

        public function __construct(CadastrarNewOrder $createOrder, $token)
        {
            $this->createOrder = $createOrder;
            $this->token = $token;
        }

        public function get($resource)
        {
            $result = [
                "total_price" => floatval($this->getCreateOrder()->getTotal()),
                "volumes" => json_decode($this->getCreateOrder()->getProdutos(), true),
                "zip_code_start" => "13610-230",
                "zip_code_end" => $this->getCreateOrder()->getCep()
            ];

            $tipoData = "Content-Type: application/json";
            $token = "token: {$this->getToken()}";

            // URL PARA REQUISICAO ENDPOINT
            $endpoint = self::URL_BASE . $resource;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($result));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [$tipoData, $token]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $requisicao = json_decode($response, false);
            print_r($requisicao);
            $cotacao = [];
            if ($httpCode == 200) {
                foreach ($requisicao->result as $key => $value) {
                    array_push($cotacao, [$value->id => $value->service]);
                }

                foreach ($cotacao as $value) {
                    print_r($value);
                    $data = array_search($this->getFirstWordFrete($this->getCreateOrder()->getShipment()), $value);
                    // print_r($data);
                    if($data){
                        return $data;
                    }
                }
            }
        }

        public function resource()
        {
            return $this->get("quote/freight");
        }

        /**
         * Get the value of createOrder
         */
        public function getCreateOrder()
        {
            return $this->createOrder;
        }

        /**
         * Get the value of token
         */
        public function getToken()
        {
            return $this->token;
        }

        public function getFirstWord()
        {
            $word = explode(' ', $this->getCreateOrder()->getShipment());
            return $word[0];
        }

        public function getFirstWordFrete($valor)
        {
            $string = str_replace("via SE", "", $valor);
            return trim($string); // Output: "I have an "
        }
}
