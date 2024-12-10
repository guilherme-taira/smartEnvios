<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrayWebHookController extends Controller
{

    private $dataInput;
    private $token;

    public function __construct($dataInput, $token)
    {
        $this->dataInput = $dataInput;
        $this->token = $token;
    }

    public function getIdOrder(): array{

        $data = explode("&",$this->getDataInput());
        $result = explode("=",$data[1]);
        return $result;
    }

    public function getAction(): array{

        $data = explode("&",$this->getDataInput());
        $result = explode("=",$data[3]);
        return $result;
    }

    public function getActionResult(){
        return $this->getAction()[1];
    }

    public function SearchOrder(){

        if($this->getIdOrder()[0] == "scope_id"){
            return $this->getIdOrder()[1];
        }
    }



    /**
     * Get the value of dataInput
     */
    public function getDataInput(): string
    {
        return $this->dataInput;
    }

    /**
     * Get the value of token
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
