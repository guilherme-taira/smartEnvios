<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

interface smartEnviosRequest {
    public function get($resource);
    public function resource();
}
const URL_BASE_SMART_ENVIOS = "https://api.smartenvios.com/v1/";

class createOrder implements smartEnviosRequest
{
    private $BandoPdo;
    private $id_order;
    private $token;
    private $preference_by;
    private $external_order_id;
    private $observation;
    private $destiny_document;
    private $destiny_name;
    private $destiny_zipcode;
    private $destiny_street;
    private $destiny_phone;
    private $destiny_number;
    private $destiny_neighborhood;
    private $destiny_complement;
    private $destiny_email;
    private $adjusted_volume_quantity;
    private $item;

    public function __construct(Banco $BandoPdo,$id_order,$token,$preference_by,$external_order_id,$observation,$destiny_document,$destiny_name,$destiny_zipcode,
    $destiny_street,$destiny_phone,$destiny_number,$destiny_neighborhood,$destiny_complement,$destiny_email,$adjusted_volume_quantity,$item)
    {
        $this->BandoPdo = $BandoPdo;
        $this->id_order = $id_order;
        $this->token = $token;
        $this->preference_by = $preference_by;
        $this->external_order_id = $external_order_id;
        $this->observation = $observation;
        $this->destiny_document = $destiny_document;
        $this->destiny_name = $destiny_name;
        $this->destiny_zipcode = $destiny_zipcode;
        $this->destiny_street = $destiny_street;
        $this->destiny_phone = $destiny_phone;
        $this->destiny_number = $destiny_number;
        $this->destiny_neighborhood = $destiny_neighborhood;
        $this->destiny_complement = $destiny_complement;
        $this->destiny_email = $destiny_email;
        $this->adjusted_volume_quantity = $adjusted_volume_quantity;
        $this->item = $item;
    }

    public function resource(){
        return $this->get('dc-create?quote_service_id='.$this->getPreferenceBy());
    }

    public function get($resource){

        $tipoData = "Content-Type: application/json";
        $token = "token: {$this->getToken()}";

        $data = [
            "preference_by" => "QUOTE_VALUE",
            "freightContentStatement" => [
                  "observation" => $this->getObservation(),
                  "destiny_document" => $this->getDestinyDocument(),
                  "destiny_name" => $this->getDestinyName(),
                  "destiny_zipcode" => $this->getDestinyZipcode(),
                  "destiny_street" => $this->getDestinyStreet(),
                  "destiny_phone" => $this->getDestinyPhone(),
                  "destiny_number" => $this->getDestinyNumber(),
                  "destiny_neighborhood" => $this->getDestinyNeighborhood(),
                  "destiny_complement" => $this->getDestinyComplement() != null ? $this->getDestinyComplement():"casa",
                  "destiny_email" => $this->getDestinyEmail(),
                  "adjusted_volume_quantity" => 1,
                  "items" => $this->getItem()
               ]
         ];

         print_r($data);

        // URL PARA REQUISICAO ENDPOINT
        $endpoint = URL_BASE_SMART_ENVIOS.$resource;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$tipoData,$token]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, false);
         print_r($requisicao);
        if($httpCode == "200"){
            $dataObject = new handleDb($this->getBandoPdo(),$requisicao,$this->getIdOrder());
            $dataObject->updateOrder();
        }

    }



    /**
     * Get the value of preference_by
     */
    public function getPreferenceBy()
    {
        return $this->preference_by;
    }

    /**
     * Get the value of external_order_id
     */
    public function getExternalOrderId()
    {
        return $this->external_order_id;
    }

    /**
     * Get the value of observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Get the value of destiny_document
     */
    public function getDestinyDocument()
    {
        return $this->destiny_document;
    }

    /**
     * Get the value of destiny_zipcode
     */
    public function getDestinyZipcode()
    {
        return $this->destiny_zipcode;
    }

    /**
     * Get the value of destiny_name
     */
    public function getDestinyName()
    {
        return $this->destiny_name;
    }

    /**
     * Get the value of destiny_street
     */
    public function getDestinyStreet()
    {
        return $this->destiny_street;
    }

    /**
     * Get the value of destiny_phone
     */
    public function getDestinyPhone()
    {
        return $this->destiny_phone;
    }

    /**
     * Get the value of destiny_number
     */
    public function getDestinyNumber()
    {
        return $this->destiny_number;
    }

    /**
     * Get the value of destiny_neighborhood
     */
    public function getDestinyNeighborhood()
    {
        return $this->destiny_neighborhood;
    }

    /**
     * Get the value of destiny_complement
     */
    public function getDestinyComplement()
    {
        return $this->destiny_complement;
    }

    /**
     * Get the value of destiny_email
     */
    public function getDestinyEmail()
    {
        return $this->destiny_email;
    }

    /**
     * Get the value of adjusted_volume_quantity
     */
    public function getAdjustedVolumeQuantity()
    {
        return $this->adjusted_volume_quantity;
    }

    /**
     * Get the value of item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the value of id_order
     */
    public function getIdOrder()
    {
        return $this->id_order;
    }



    /**
     * Get the value of BandoPdo
     */
    public function getBandoPdo(): Banco
    {
        return $this->BandoPdo;
    }
}
