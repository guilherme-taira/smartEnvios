<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class GetPedidosComplete extends Controller
{
    private $data;

    function __construct(TrayWebHookController $data)
    {
        $this->data = $data;
    }

    function resource()
    {
        return $this->get('/orders/' . $this->getData()->SearchOrder() . '/complete/?access_token=' . $this->getData()->getToken());
    }

    function get($resource)
    {

        // ENDPOINT PARA REQUISCAO
        $endpoint = "https://www.embaleme.com.br/web_api" . $resource;
        //echo $endpoint . "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, false);

        if ($httpCode == "200") {
            return $requisicao;
        }
    }

    public function shipmentIntegrator()
    {
        // GET DATA OF REQUEST
        $dados = $this->resource();

        $produtos = [];
        $produtosPainel = [];
        $produtosVenda = [];

        if (trim($dados->Order->shipment_integrator) === "FRENET" && trim($this->getData()->getActionResult()) === "insert") {

            echo "ENTROU";
            if(count($dados->Order->Customer->CustomerAddresses) > 1){
                $rua = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->address;
                $numero = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->number;
                $complemento = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->complement ? $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->complement : "N/D" ;
                $bairro = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->neighborhood;
                $cidade = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->city;
                $state = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->state;
                $zipcode = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->zip_code;
            }else{
                $rua = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->address;
                $numero = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->number;
                $complemento = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->complement ? $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->complement : "N/D" ;
                $bairro = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->neighborhood;
                $cidade = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->city;
                $state = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->state;
                $zipcode = $dados->Order->Customer->CustomerAddresses[0]->CustomerAddress->zip_code;
            }


            $peso = 0;
            foreach ($dados->Order->ProductsSold as $ProdutoUnid) {
              $peso += $ProdutoUnid->ProductsSold->weight * $ProdutoUnid->ProductsSold->quantity;

            $product = [
                //"description" => $ProdutoUnid->ProductsSold->name,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height) / 100,
                "length" => floatval($ProdutoUnid->ProductsSold->length) / 100,
                "width" => floatval($ProdutoUnid->ProductsSold->width) / 100,
                "price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "quantity" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                //"unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
            ];

            $productOrder = [
                "description" => $ProdutoUnid->ProductsSold->name,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height),
                "length" => floatval($ProdutoUnid->ProductsSold->length),
                "width" => floatval($ProdutoUnid->ProductsSold->width),
                "total_price" =>  floatval($ProdutoUnid->ProductsSold->price) * floatval($ProdutoUnid->ProductsSold->quantity),
                "amount" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                "unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
            ];

            $productPainel = [
                "description" => $ProdutoUnid->ProductsSold->name,
                "amount" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                "unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "total_price" =>  floatval($ProdutoUnid->ProductsSold->price *  $ProdutoUnid->ProductsSold->quantity),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height),
                "width" => floatval($ProdutoUnid->ProductsSold->width),
                "length" => floatval($ProdutoUnid->ProductsSold->length) ,
                "pictures" => $ProdutoUnid->ProductsSold->ProductSoldImage
            ];

              array_push($produtos,$product);
              array_push($produtosPainel,$productPainel);
              array_push($produtosVenda,$productOrder);

            }

            $produtosArray = count($produtos) == 1 ? [$product] : $produtos;

            $n_pedido = $dados->Order->id;
            $chaveNf = '000000';
            $NumeroNf = '000000';
            $dataNf = '0000-00-00';
            $serieNf = '0';
            $TotalNf = '0.00';

            // CONEXAO BANCO
            $db = new Banco();

            // NOVA ORDEM
            $OrderGravaBanco = new CadastraNewOrder(
                $dados->Order->status,
                $n_pedido,
                $dados->Order->date,
                $dados->Order->customer_id,
                $dados->Order->partial_total,
                $dados->Order->taxes,
                $dados->Order->discount,
                $dados->Order->point_sale,
                $dados->Order->shipment,
                $dados->Order->shipment_value,
                $dados->Order->shipment_date,
                $dados->Order->store_note,
                $dados->Order->discount_coupon,
                $dados->Order->payment_method_rate,
                $dados->Order->value_1,
                $dados->Order->payment_method_type,
                $dados->Order->sending_code,
                $dados->Order->session_id,
                $dados->Order->total,
                $dados->Order->payment_date,
                $dados->Order->access_code,
                $dados->Order->Customer->discount,
                $dados->Order->Customer->discount,
                $dados->Order->shipment_integrator,
                $dados->Order->modified,
                $dados->Order->printed,
                $dados->Order->interest,
                $dados->Order->id_quotation,
                $dados->Order->estimated_delivery_date,
                $dados->Order->external_code,
                $dados->Order->has_payment,
                $dados->Order->has_shipment,
                $dados->Order->has_invoice,
                $dados->Order->total_comission_user,
                $dados->Order->total_comission,
                0,
                0,
                $dados->Order->OrderStatus->id,
                $dados->Order->OrderStatus->default,
                $dados->Order->OrderStatus->type,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->description,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->show_status_central,
                $dados->Order->OrderStatus->background,
                $dados->Order->Customer->name,
                $dados->Order->Customer->email,
                $dados->Order->Customer->cellphone,
                $rua,
                $numero,
                $bairro,
                $zipcode,
                $bairro,
                $cidade,
                $state,
                $chaveNf,
                $NumeroNf,
                $dataNf,
                $serieNf,
                $TotalNf,
                $peso,
                $dados->Order->Customer->cpf,
                $db->getPdo(),
                $complemento,
                0,
                0,
                json_encode($produtosArray),
                json_encode($produtosPainel)
                ,$dados->Order->ProductsSold
            );

            // $getDataOrder = new TrayOrderComplete($OrderGravaBanco);
            // $getDataOrder->saveOrder();
            // GRAVA NO BANCO

            $OrderGravaBanco->CadastrarOrdem();
            $cpf = $dados->Order->Customer->cpf != null ? $dados->Order->Customer->cpf : $dados->Order->Customer->cnpj;
            $telefone = $dados->Order->Customer->cellphone != null ? $dados->Order->Customer->cellphone : $dados->Order->Customer->phone;
            // CADASTRAR PEDIDO SMART ENVIOS
            $cotacao = new CotacaoFrete($OrderGravaBanco,"jsVC2QAsoHijI0ULb7hkyku9kq8117nw");
            $dadosCotacao = $cotacao->resource();
            $newOrder = new createOrder($db,$n_pedido,"jsVC2QAsoHijI0ULb7hkyku9kq8117nw",$dadosCotacao,$n_pedido,$complemento,$cpf,$dados->Order->Customer->name,$zipcode,$rua,$telefone,$numero,$bairro,$complemento,$dados->Order->Customer->email,1,$produtosVenda);
            $newOrder->resource();
        }else{
            $peso = 0;
            foreach ($dados->Order->ProductsSold as $ProdutoUnid) {
              $peso += $ProdutoUnid->ProductsSold->weight * $ProdutoUnid->ProductsSold->quantity;

            $product = [
                //"description" => $ProdutoUnid->ProductsSold->name,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height) / 100,
                "length" => floatval($ProdutoUnid->ProductsSold->length) / 100,
                "width" => floatval($ProdutoUnid->ProductsSold->width) / 100,
                "price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "quantity" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                //"unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
            ];

            $productOrder = [
                "description" => $ProdutoUnid->ProductsSold->name,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height),
                "length" => floatval($ProdutoUnid->ProductsSold->length),
                "width" => floatval($ProdutoUnid->ProductsSold->width),
                "total_price" =>  floatval($ProdutoUnid->ProductsSold->price) * floatval($ProdutoUnid->ProductsSold->quantity),
                "amount" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                "unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
            ];

            $productPainel = [
                "description" => $ProdutoUnid->ProductsSold->name,
                "amount" =>  floatval($ProdutoUnid->ProductsSold->quantity),
                "unit_price" =>  floatval($ProdutoUnid->ProductsSold->price),
                "total_price" =>  floatval($ProdutoUnid->ProductsSold->price *  $ProdutoUnid->ProductsSold->quantity),
                "weight" =>  floatval($ProdutoUnid->ProductsSold->weight) / 1000,
                "height" =>  floatval($ProdutoUnid->ProductsSold->height),
                "width" => floatval($ProdutoUnid->ProductsSold->width),
                "length" => floatval($ProdutoUnid->ProductsSold->length) ,
                "pictures" => $ProdutoUnid->ProductsSold->ProductSoldImage
            ];

              array_push($produtos,$product);
              array_push($produtosPainel,$productPainel);
              array_push($produtosVenda,$productOrder);

            }

            $produtosArray = count($produtos) == 1 ? [$product] : $produtos;

            $n_pedido = $dados->Order->id;
            $chaveNf = '000000';
            $NumeroNf = '000000';
            $dataNf = '0000-00-00';
            $serieNf = '0';
            $TotalNf = '0.00';

            // CONEXAO BANCO
            $db = new Banco();

            // NOVA ORDEM
            $OrderGravaBanco = new CadastraNewOrder(
                $dados->Order->status,
                $n_pedido,
                $dados->Order->date,
                $dados->Order->customer_id,
                $dados->Order->partial_total,
                $dados->Order->taxes,
                $dados->Order->discount,
                $dados->Order->point_sale,
                $dados->Order->shipment,
                $dados->Order->shipment_value,
                $dados->Order->shipment_date,
                $dados->Order->store_note,
                $dados->Order->discount_coupon,
                $dados->Order->payment_method_rate,
                $dados->Order->value_1,
                $dados->Order->payment_method_type,
                $dados->Order->sending_code,
                $dados->Order->session_id,
                $dados->Order->total,
                $dados->Order->payment_date,
                $dados->Order->access_code,
                $dados->Order->Customer->discount,
                $dados->Order->Customer->discount,
                $dados->Order->shipment_integrator,
                $dados->Order->modified,
                $dados->Order->printed,
                $dados->Order->interest,
                $dados->Order->id_quotation,
                $dados->Order->estimated_delivery_date,
                $dados->Order->external_code,
                $dados->Order->has_payment,
                $dados->Order->has_shipment,
                $dados->Order->has_invoice,
                $dados->Order->total_comission_user,
                $dados->Order->total_comission,
                0,
                0,
                $dados->Order->OrderStatus->id,
                $dados->Order->OrderStatus->default,
                $dados->Order->OrderStatus->type,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->description,
                $dados->Order->OrderStatus->show_backoffice,
                $dados->Order->OrderStatus->show_status_central,
                $dados->Order->OrderStatus->background,
                $dados->Order->Customer->name,
                $dados->Order->Customer->email,
                $dados->Order->Customer->cellphone,
                $dados->Order->Customer->address,
                isset($dados->Order->Customer->number) ? $dados->Order->Customer->number : 0,
                $dados->Order->Customer->neighborhood,
                $dados->Order->Customer->zip_code,
                $dados->Order->Customer->neighborhood,
                $dados->Order->Customer->city,
                $dados->Order->Customer->state,
                $chaveNf,
                $NumeroNf,
                $dataNf,
                $serieNf,
                $TotalNf,
                $peso,
                $dados->Order->Customer->cpf,
                $db->getPdo(),
                $dados->Order->Customer->complement,
                0,
                0,
                json_encode($produtosArray),
                json_encode($produtosPainel)
                ,$dados->Order->ProductsSold
            );

            $getDataOrder = new TrayOrderComplete($OrderGravaBanco);
            $getDataOrder->saveOrder();
        }
    }

    /**
     * Get the value of data
     */
    public function getData(): TrayWebHookController
    {
        return $this->data;
    }
}
