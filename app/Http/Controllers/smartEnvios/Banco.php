<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class Banco extends Controller
{
    private $pdo;

    public function __construct()
    {

        /**
         * DADOS DE PRODUCAO
         */
        $servidor = "162.240.30.73";
        $usuario = "guilherme_Taira";
        $senha = "Leme2022#";
        $banco = "guilherme_ecommerce";

        $porta = 3306;
        $dsn =  "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8";


        $option = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        return $this->pdo = new PDO($dsn, $usuario, $senha, $option);
        //$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo():PDO
    {
        return $this->pdo;
    }
}
