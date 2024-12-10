<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthTrayEmbaleme extends Controller
{
    private $consumer_key;
    private $constumer_secret;
    private $code;
    private $pdo2;

    const  URL_BASE_AUTH_TRAY_EMBALEME = "https://www.embaleme.com.br/";

    function __construct($consumer_key, $constumer_secret, $code)
    {
        $this->consumer_key = $consumer_key;
        $this->constumer_secret = $constumer_secret;
        $this->code = $code;
    }

    function resource()
    {
        return $this->get('web_api/auth');
    }

    function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = self::URL_BASE_AUTH_TRAY_EMBALEME . $resource;

        $body = array(
            'consumer_key' => $this->getConsumerKey(),
            'consumer_secret' => $this->getConstumerSecret(),
            'code' => $this->getCode(),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, false);
        return $requisicao;
}

    /**
     * Get the value of consumer_key
     */
    public function getConsumerKey()
    {
        return $this->consumer_key;
    }

    /**
     * Get the value of constumer_secret
     */
    public function getConstumerSecret()
    {
        return $this->constumer_secret;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }
}
