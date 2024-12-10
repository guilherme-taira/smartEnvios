<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDOException;

class handleDb extends Controller
{

    private $pdo;
    private $data;
    private $id;

    public function __construct(Banco $pdo, $data, $id)
    {
        $this->pdo = $pdo;
        $this->data = $data;
        $this->id = $id;
    }

    public function updateOrder()
    {
        try {

            if (isset($this->getData()->result)) {
                $this->getPdoBanco()->getPdo()->beginTransaction();
                $statement2 = $this->getPdoBanco()->getPdo()->query("UPDATE UelloPedidos SET
                    freight_order_id = '{$this->getData()->result->freight_order_id}',
                    freight_order_number = '{$this->getData()->result->freight_order_number}',
                    freight_order_tracking_code = '{$this->getData()->result->freight_order_tracking_code}',
                    customer_id_smart = '{$this->getData()->result->customer_id}',
                    nfe_id = '{$this->getData()->result->nfe_id}'
                    WHERE orderid = '{$this->getId()}'");
                    $statement2->execute();
                $this->getPdoBanco()->getPdo()->commit();
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
            $this->getPdoBanco()->getPdo()->rollBack();
        }
    }

    /**
     * Get the value of pdo
     */
    public function getPdoBanco(): Banco
    {
        return $this->pdo;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}
