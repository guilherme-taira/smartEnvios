<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class TrayOrderComplete extends Controller
{

    private $dados;

    public function __construct(CadastrarNewOrder $dados)
    {
        $this->dados = $dados;
    }

    public function saveOrder(){
        try {

            $this->dados->getPdo()->beginTransaction();

            foreach ($this->dados->getProdutosNormal() as $pedido) {

                $sql = "INSERT INTO pedidos (n_pedido,cod_prod,descricao,quantidade,peso,EAN,dataSaida,frete,cpf,codigoRastreamento,tranportadora,qtdprodutos1,qtdprodutos2,qtdprodutos3,imagem)";
                $sql_values = " VALUES (:n_pedido, :cod_prod, :descricao, :quantidade, :peso, :EAN, :datasaida, :frete, :cpf, :codigoRastreamento,:tranportadora,:qtdprodutos1,:qtdprodutos2,:qtdprodutos3,:imagem)";

                $statement = $this->dados->getPdo()->prepare($sql .= $sql_values);
                $statement->bindValue('n_pedido', (string) $pedido->ProductsSold->order_id, PDO::PARAM_INT);
                $statement->bindValue('cod_prod', (int) $pedido->ProductsSold->reference, PDO::PARAM_INT);
                $statement->bindValue('descricao', (string) $pedido->ProductsSold->original_name, PDO::PARAM_STR);
                $statement->bindValue('quantidade', (int) $pedido->ProductsSold->quantity, PDO::PARAM_INT);
                $statement->bindValue('peso',$pedido->ProductsSold->weight, PDO::PARAM_STR);
                $statement->bindValue('EAN', $pedido->ProductsSold->ean, PDO::PARAM_STR);
                $statement->bindValue('datasaida', $this->dados->getDate(), PDO::PARAM_STR);
                $statement->bindValue('frete', (float) $this->dados->getShipment_value(), PDO::PARAM_STR);
                $statement->bindValue('cpf', (string) $this->dados->getCpf(), PDO::PARAM_STR);
                $statement->bindValue('codigoRastreamento', (string) $this->dados->getPoint_sale(), PDO::PARAM_STR);
                $statement->bindValue('tranportadora', (string) $this->dados->getShipment(), PDO::PARAM_STR);
                $statement->bindValue('imagem', (string) $pedido->ProductsSold->ProductSoldImage[0]->http, PDO::PARAM_STR);
                $this->setNumberProduct(count(json_decode($this->dados->getProdutosPainel(),false)),$statement);
                $statement->execute();
            }
            $this->dados->getPdo()->commit();
        } catch (\PDOException $th) {
            echo $th->getMessage();
        }
    }

    public function setNumberProduct($quantidade,$statement){
        switch ($quantidade) {
            case $quantidade >= 1 && $quantidade <= 3:

                $statement->bindValue('qtdprodutos1', "X", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos2', "", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos3', "", PDO::PARAM_STR);
                break;
            case $quantidade >= 4 && $quantidade <= 7:

                $statement->bindValue('qtdprodutos1', "", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos2', "X", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos3', "", PDO::PARAM_STR);
                break;
            case $quantidade >= 8 && $quantidade <= 30:

                $statement->bindValue('qtdprodutos1', "", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos2', "", PDO::PARAM_STR);
                $statement->bindValue('qtdprodutos3', "X", PDO::PARAM_STR);
                break;

            default:
                # code...
                break;
        }
    }


    function verificarOrdemExistente(string $ordem)
    {
        // $this->dados->getPdo()->beginTransaction();
        // $statement = $$this->getPdo()->prepare("SELECT * from pedidos WHERE n_pedido = :numeropedido");
        // $statement->bindParam(':numeropedido', $this->toObjs()->n_pedido, PDO::PARAM_INT);
        // $statement->execute();
        // $count = $statement->fetchAll();
        // if (count($count) > 0) {
        //     $this->saveOrder();
        // }
        // $this->dados->getPdo()->commit();
    }

    /**
     * Get the value of dados
     */
    public function getDados(): CadastrarNewOrder
    {
            return $this->dados;
    }
}
