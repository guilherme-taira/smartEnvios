<?php

namespace App\Http\Controllers\SmartEnvios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

interface Cadastrar{

    public function CadastrarOrdem();
    public function UpdateOrdem();
    public function DeleteOrdem();
}


class CadastrarNewOrder implements Cadastrar {

    // VARIAVEIS PRIVADAS

    private $status;
    private $Orderid;
    private $date;
    private $customer_id;
    private $partial_total;
    private $taxes;
    private $discount;
    private $point_sale;
    private $shipment;
    private $shipment_value;
    private $shipment_date;
    private $store_note;
    private $discount_coupon;
    private $payment_method_rate;
    private $value_1;
    private $payment_form;
    private $sending_code;
    private $session_id;
    private $total;
    private $payment_date;
    private $access_code;
    private $progressive_discount;
    private $shipping_progressive_discount;
    private $shipment_integrator;
    private $modified;
    private $printed;
    private $interest;
    private $id_quotation;
    private $estimated_delivery_date;
    private $external_code;
    private $has_payment;
    private $has_shipment;
    private $has_invoice;
    private $total_comission_user;
    private $total_comission;
    private $couponcode;
    private $coupondiscount;
    private $OrderStatusid;
    private $OrderStatusdefault;
    private $OrderStatustype;
    private $OrderStatusshow_backoffice;
    private $OrderStatusallow_edit_order;
    private $OrderStatusdescription;
    private $OrderStatusstatus;
    private $OrderStatusshow_status_central;
    private $OrderStatusbackground;
    // DADOS DO CLIENTE
    private $nomeCliente;
    private $cpf;
    private $email;
    private $telefone;
    private $endereco;
    private $NumeroCasa;
    private $referencia;
    private $cep;
    private $vizinho;
    private $cidade;
    private $uf;
    // DADOS DO INVOICE NOTA FISCAL
    private $ChaveNf;
    private $NumeroNf;
    private $dataNf;
    private $serieNf;
    private $TotalNf;
    private $Peso;
    private $complement;
    // DADOS DO VOLUME
    private $quantityVolume;
    private $dataVolumes; // DADOS SEREALIZADOS EM JSON
    // DADOS DE CONEXAO
    private $pdo;
    private $produtos;
    private $produtosPainel;
    private $produtosNormal;

    function __construct($status,$Orderid,$date,$customer_id,$partial_total,$taxes,$discount,$point_sale,
    $shipment,$shipment_value,$shipment_date,$store_note,$discount_coupon,$payment_method_rate,$value_1,$payment_form = 'INDEFINIDO',
    $sending_code,$session_id,$total,$payment_date,$access_code,$progressive_discount,$shipping_progressive_discount,
    $shipment_integrator,$modified,$printed,$interest,$id_quotation,$estimated_delivery_date,$external_code,$has_payment,
    $has_shipment,$has_invoice,$total_comission_user,$total_comission,$couponcode,
    $coupondiscount,$OrderStatusid,$OrderStatusdefault,$OrderStatustype,$OrderStatusshow_backoffice,$OrderStatusallow_edit_order,
    $OrderStatusdescription = 0,$OrderStatusstatus,$OrderStatusshow_status_central,$OrderStatusbackground,$nomeCliente,$email,$telefone,$endereco,
    $NumeroCasa,$referencia,$cep,$vizinho,$cidade,$uf,$ChaveNf,$NumeroNf,$dataNf,$serieNf,$TotalNf,$Peso,$cpf,PDO $pdo,$complement,$quantityVolume,$dataVolumes,$produtos,$produtosPainel,$produtosNormal)
    {
            $this->status = $status;
            $this->Orderid = $Orderid;
            $this->date = $date;
            $this->customer_id = $customer_id;
            $this->partial_total = $partial_total;
            $this->taxes = $taxes;
            $this->discount = $discount;
            $this->point_sale = $point_sale;
            $this->shipment = $shipment;
            $this->shipment_value = $shipment_value;
            $this->shipment_date = $shipment_date;
            $this->store_note = $store_note;
            $this->discount_coupon = $discount_coupon;
            $this->payment_method_rate = $payment_method_rate;
            $this->value_1 = $value_1;
            $this->payment_form = $payment_form;
            $this->sending_code = $sending_code;
            $this->session_id = $session_id;
            $this->total = $total;
            $this->payment_date = $payment_date;
            $this->access_code = $access_code;
            $this->progressive_discount = $progressive_discount;
            $this->shipping_progressive_discount = $shipping_progressive_discount;
            $this->shipment_integrator = $shipment_integrator;
            $this->modified = $modified;
            $this->printed = $printed;
            $this->interest = $interest;
            $this->id_quotation = $id_quotation;
            $this->estimated_delivery_date = $estimated_delivery_date;
            $this->external_code = $external_code;
            $this->has_payment = $has_payment;
            $this->has_shipment = $has_shipment;
            $this->has_invoice = $has_invoice;
            $this->total_comission_user = $total_comission_user;
            $this->total_comission = $total_comission;
            $this->couponcode = $couponcode;
            $this->coupondiscount = $coupondiscount;
            $this->OrderStatusid = $OrderStatusid;
            $this->OrderStatusdefault = $OrderStatusdefault;
            $this->OrderStatustype = $OrderStatustype;
            $this->OrderStatusshow_backoffice = $OrderStatusshow_backoffice;
            $this->OrderStatusdescription = $OrderStatusdescription;
            $this->OrderStatusstatus = $OrderStatusstatus;
            $this->OrderStatusshow_status_central = $OrderStatusshow_status_central;
            $this->OrderStatusbackground = $OrderStatusbackground;
            // DADOS DO CLIENTE
            $this->nomeCliente = $nomeCliente;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->endereco = $endereco;
            $this->NumeroCasa = $NumeroCasa;
            $this->referencia = $referencia;
            $this->cep = $cep;
            $this->vizinho = $vizinho;
            $this->cidade = $cidade;
            $this->uf = $uf;
            $this->pdo = $pdo;
            $this->complement = $complement;
            // DADOS DA NOTA FISCAL INVOICE
            $this->ChaveNf = $ChaveNf;
            $this->NumeroNf = $NumeroNf;
            $this->dataNf = $dataNf;
            $this->serieNf = $serieNf;
            $this->TotalNf = $TotalNf;
            $this->Peso = $Peso;
            $this->cpf = $cpf;
            // DADOS DE VOLUMES
            $this->quantityVolume = $quantityVolume;
            $this->dataVolumes = $dataVolumes;
            $this->produtos = $produtos;
            $this->produtosPainel = $produtosPainel;
            $this->produtosNormal = $produtosNormal;
    }

    public function CadastrarOrdem(){
        // CADASTRAR ORDEM NO BANCO

        // CRIANDO O STATEMENT E GRAVANDO NO BANCO
        try {

              $this->pdo->beginTransaction();

              $sql = "INSERT INTO UelloPedidos (statusPedido ,Orderid,dataPedido,customer_id,partial_total,taxes,discount,point_sale,shipment,
              shipment_value,shipment_date,store_note,discount_coupon,payment_method_rate,value_1,payment_form,sending_code,
              session_id, total, payment_date, access_code, progressive_discount,
              shipping_progressive_discount,shipment_integrator,modified,printed,
              interest,id_quotation,estimated_delivery_date,external_code,has_payment,has_shipment,
              has_invoice,total_comission_user,total_comission,code,coupondiscount,OrderStatusid,
              OrderStatusdefault,OrderStatustype,OrderStatusshow_backoffice,OrderStatusallow_edit_order,
              OrderStatusdescription,OrderStatusstatus,OrderStatusshow_status_central,OrderStatusbackground,
              nomeCliente,email,telefone,endereco,NumeroCasa,referencia,cep,vizinho,cidade,uf,chaveNota,NumeroNf,dataNf,serieNf,TotalNf,Peso,documento,complement,produtos,produtosPainel)";

              // VALORES DO STATEMENT lkrn
              $sql_values = " VALUES(:status,:Orderid,:date,:customer_id,:partial_total,:taxes,:discount,:point_sale,
                                    :shipment,:shipment_value,:shipment_date,:store_note,:discount_coupon,:payment_method_rate,
                                    :value_1,:payment_form,:sending_code,:session_id,:total,:payment_date,:access_code,
                                    :progressive_discount,:shipping_progressive_discount,:shipment_integrator,:modified,:printed,
                                    :interest,:id_quotation,:estimated_delivery_date,:external_code,:has_payment,:has_shipment,
                                    :has_invoice,:total_comission_user,:total_comission,:code,:coupondiscount,:OrderStatusid,
                                    :OrderStatusdefault,:OrderStatustype,:OrderStatusshow_backoffice,:OrderStatusallow_edit_order,
                                    :OrderStatusdescription,:OrderStatusstatus,:OrderStatusshow_status_central,:OrderStatusbackground,:nomeCliente,
                                    :email,:telefone,:endereco,:NumeroCasa,:referencia,:cep,:vizinho,:cidade,:uf,:chaveNota,:NumeroNf,:dataNf,:serieNf,:TotalNf,
                                    :Peso,:documento,:complement,:produtos,:produtosPainel)";

              $sql_complete = $sql.=$sql_values;
              $statement = $this->pdo->prepare($sql_complete);
              $statement->bindValue(':status', $this->getStatus(), PDO::PARAM_STR);
              $statement->bindValue(':Orderid', $this->getOrderid(), PDO::PARAM_STR);
              $statement->bindValue(':date', $this->getDate(), PDO::PARAM_STR);
              $statement->bindValue(':customer_id', $this->getCustomer_id(),PDO::PARAM_STR);
              $statement->bindValue(':partial_total', $this->getPartial_total(),PDO::PARAM_STR);
              $statement->bindValue(':taxes', $this->getTaxes(),PDO::PARAM_STR);
              $statement->bindValue(':discount', $this->getDiscount(),PDO::PARAM_STR);
              $statement->bindValue(':point_sale', $this->getPoint_sale(),PDO::PARAM_STR);
              $statement->bindValue(':shipment', $this->getShipment(),PDO::PARAM_STR);
              $statement->bindValue(':shipment_value', $this->getShipment_value(),PDO::PARAM_STR);
              $statement->bindValue(':shipment_date', $this->getShipment_date(),PDO::PARAM_STR);
              $statement->bindValue(':store_note', $this->getStore_note(),PDO::PARAM_STR);
              $statement->bindValue(':discount_coupon', $this->getDiscount_coupon(),PDO::PARAM_STR);
              $statement->bindValue(':payment_method_rate', $this->getPayment_method_rate(),PDO::PARAM_STR);
              $statement->bindValue(':value_1', $this->getValue_1(),PDO::PARAM_STR);
              $statement->bindValue(':payment_form', $this->getPayment_form(),PDO::PARAM_STR);
              $statement->bindValue(':sending_code', $this->getSending_code(),PDO::PARAM_STR);
              $statement->bindValue(':session_id', $this->getSession_id(),PDO::PARAM_STR);
              $statement->bindValue(':total', $this->getTotal(),PDO::PARAM_STR);
              $statement->bindValue(':payment_date', $this->getPayment_date(),PDO::PARAM_STR);
              $statement->bindValue(':access_code', $this->getAccess_code(),PDO::PARAM_STR);
              $statement->bindValue(':progressive_discount', $this->getProgressive_discount(),PDO::PARAM_STR);
              $statement->bindValue(':shipping_progressive_discount', $this->getShipping_progressive_discount(),PDO::PARAM_STR);
              $statement->bindValue(':shipment_integrator', $this->getShipment_integrator(),PDO::PARAM_STR);
              $statement->bindValue(':modified', $this->getModified(),PDO::PARAM_STR);
              $statement->bindValue(':printed', $this->getPrinted(),PDO::PARAM_STR);
              $statement->bindValue(':interest', $this->getInterest(),PDO::PARAM_STR);
              $statement->bindValue(':id_quotation', $this->getId_quotation(),PDO::PARAM_STR);
              $statement->bindValue(':estimated_delivery_date',$this->getEstimated_delivery_date(),PDO::PARAM_STR);
              $statement->bindValue(':external_code', $this->getExternal_code(),PDO::PARAM_STR);
              $statement->bindValue(':has_payment', $this->getHas_payment(),PDO::PARAM_STR);
              $statement->bindValue(':has_shipment', $this->getHas_shipment(),PDO::PARAM_STR);
              $statement->bindValue(':has_invoice', $this->getHas_invoice(),PDO::PARAM_STR);
              $statement->bindValue(':total_comission_user', $this->getTotal_comission_user(),PDO::PARAM_STR);
              $statement->bindValue(':total_comission', $this->getTotal_comission(),PDO::PARAM_STR);
              $statement->bindValue(':code', $this->getCouponcode(),PDO::PARAM_STR);
              $statement->bindValue(':coupondiscount', $this->getCoupondiscount(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusid', $this->getOrderStatusid(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusdefault', $this->getOrderStatusdefault(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatustype', $this->getOrderStatustype(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusshow_backoffice', $this->getOrderStatusshow_backoffice(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusallow_edit_order', $this->getOrderStatusallow_edit_order(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusdescription', 0 ,PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusstatus', $this->getOrderStatusstatus(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusshow_status_central', $this->getOrderStatusshow_status_central(),PDO::PARAM_STR);
              $statement->bindValue(':OrderStatusbackground', 0,PDO::PARAM_STR);
              $statement->bindValue(':nomeCliente',$this->getNomeCliente(),PDO::PARAM_STR);
              $statement->bindValue(':documento',$this->getCpf(),PDO::PARAM_STR);
              $statement->bindValue(':email',$this->getEmail(),PDO::PARAM_STR);
              $statement->bindValue(':telefone',$this->getTelefone(),PDO::PARAM_STR);
              $statement->bindValue(':endereco',$this->getEndereco(),PDO::PARAM_STR);
              $statement->bindValue(':NumeroCasa',$this->getNumeroCasa(),PDO::PARAM_STR);
              $statement->bindValue(':referencia',$this->getReferencia(),PDO::PARAM_STR);
              $statement->bindValue(':cep',$this->getCep(),PDO::PARAM_STR);
              $statement->bindValue(':vizinho',$this->getVizinho(),PDO::PARAM_STR);
              $statement->bindValue(':cidade',$this->getCidade(),PDO::PARAM_STR);
              $statement->bindValue(':uf',$this->getUf(),PDO::PARAM_STR);
              $statement->bindValue(':chaveNota',$this->getChaveNf(),PDO::PARAM_STR);
              $statement->bindValue(':NumeroNf',$this->getNumeroNf(),PDO::PARAM_STR);
              $statement->bindValue(':dataNf',$this->getDataNf(),PDO::PARAM_STR);
              $statement->bindValue(':serieNf',$this->getSerieNf(),PDO::PARAM_STR);
              $statement->bindValue(':TotalNf',$this->getTotalNf(),PDO::PARAM_STR);
              $statement->bindValue(':Peso',$this->getPeso(),PDO::PARAM_STR);
              $statement->bindValue(':complement',$this->getComplement(),PDO::PARAM_STR);
              $statement->bindValue(':produtos',$this->getProdutos(),PDO::PARAM_STR);
              $statement->bindValue(':produtosPainel',$this->getProdutosPainel(),PDO::PARAM_STR);
              $statement->execute();
              $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    function UpdateOrdem(){
        echo "UPDATE";
    }

    function DeleteOrdem(){
        echo "DELETE";
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of customer_id
     */
    public function getCustomer_id()
    {
        return $this->customer_id;
    }

    /**
     * Set the value of customer_id
     *
     * @return  self
     */
    public function setCustomer_id($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * Get the value of partial_total
     */
    public function getPartial_total()
    {
        return $this->partial_total;
    }

    /**
     * Set the value of partial_total
     *
     * @return  self
     */
    public function setPartial_total($partial_total)
    {
        $this->partial_total = $partial_total;

        return $this;
    }

    /**
     * Get the value of taxes
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set the value of taxes
     *
     * @return  self
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of point_sale
     */
    public function getPoint_sale()
    {
        return $this->point_sale;
    }

    /**
     * Set the value of point_sale
     *
     * @return  self
     */
    public function setPoint_sale($point_sale)
    {
        $this->point_sale = $point_sale;

        return $this;
    }

    /**
     * Get the value of shipment
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Set the value of shipment
     *
     * @return  self
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * Get the value of shipment_value
     */
    public function getShipment_value()
    {
        return $this->shipment_value;
    }

    /**
     * Set the value of shipment_value
     *
     * @return  self
     */
    public function setShipment_value($shipment_value)
    {
        $this->shipment_value = $shipment_value;

        return $this;
    }

    /**
     * Get the value of shipment_date
     */
    public function getShipment_date()
    {
        return $this->shipment_date;
    }

    /**
     * Set the value of shipment_date
     *
     * @return  self
     */
    public function setShipment_date($shipment_date)
    {
        $this->shipment_date = $shipment_date;

        return $this;
    }

    /**
     * Get the value of store_note
     */
    public function getStore_note()
    {
        return $this->store_note;
    }

    /**
     * Set the value of store_note
     *
     * @return  self
     */
    public function setStore_note($store_note)
    {
        $this->store_note = $store_note;

        return $this;
    }

    /**
     * Get the value of discount_coupon
     */
    public function getDiscount_coupon()
    {
        return $this->discount_coupon;
    }

    /**
     * Set the value of discount_coupon
     *
     * @return  self
     */
    public function setDiscount_coupon($discount_coupon)
    {
        $this->discount_coupon = $discount_coupon;

        return $this;
    }

    /**
     * Get the value of payment_method_rate
     */
    public function getPayment_method_rate()
    {
        return $this->payment_method_rate;
    }

    /**
     * Set the value of payment_method_rate
     *
     * @return  self
     */
    public function setPayment_method_rate($payment_method_rate)
    {
        $this->payment_method_rate = $payment_method_rate;

        return $this;
    }

    /**
     * Get the value of value_1
     */
    public function getValue_1()
    {
        return $this->value_1;
    }

    /**
     * Set the value of value_1
     *
     * @return  self
     */
    public function setValue_1($value_1)
    {
        $this->value_1 = $value_1;

        return $this;
    }

    /**
     * Get the value of payment_form
     */
    public function getPayment_form()
    {
        return $this->payment_form;
    }

    /**
     * Set the value of payment_form
     *
     * @return  self
     */
    public function setPayment_form($payment_form)
    {
        $this->payment_form = $payment_form;

        return $this;
    }

    /**
     * Get the value of sending_code
     */
    public function getSending_code()
    {
        return $this->sending_code;
    }

    /**
     * Set the value of sending_code
     *
     * @return  self
     */
    public function setSending_code($sending_code)
    {
        $this->sending_code = $sending_code;

        return $this;
    }

    /**
     * Get the value of session_id
     */
    public function getSession_id()
    {
        return $this->session_id;
    }

    /**
     * Set the value of session_id
     *
     * @return  self
     */
    public function setSession_id($session_id)
    {
        $this->session_id = $session_id;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of payment_date
     */
    public function getPayment_date()
    {
        return $this->payment_date;
    }

    /**
     * Set the value of payment_date
     *
     * @return  self
     */
    public function setPayment_date($payment_date)
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    /**
     * Get the value of access_code
     */
    public function getAccess_code()
    {
        return $this->access_code;
    }

    /**
     * Set the value of access_code
     *
     * @return  self
     */
    public function setAccess_code($access_code)
    {
        $this->access_code = $access_code;

        return $this;
    }

    /**
     * Get the value of progressive_discount
     */
    public function getProgressive_discount()
    {
        return $this->progressive_discount;
    }

    /**
     * Set the value of progressive_discount
     *
     * @return  self
     */
    public function setProgressive_discount($progressive_discount)
    {
        $this->progressive_discount = $progressive_discount;

        return $this;
    }

    /**
     * Get the value of shipping_progressive_discount
     */
    public function getShipping_progressive_discount()
    {
        return $this->shipping_progressive_discount;
    }

    /**
     * Set the value of shipping_progressive_discount
     *
     * @return  self
     */
    public function setShipping_progressive_discount($shipping_progressive_discount)
    {
        $this->shipping_progressive_discount = $shipping_progressive_discount;

        return $this;
    }

    /**
     * Get the value of shipment_integrator
     */
    public function getShipment_integrator()
    {
        return $this->shipment_integrator;
    }

    /**
     * Set the value of shipment_integrator
     *
     * @return  self
     */
    public function setShipment_integrator($shipment_integrator)
    {
        $this->shipment_integrator = $shipment_integrator;

        return $this;
    }

    /**
     * Get the value of modified
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set the value of modified
     *
     * @return  self
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get the value of printed
     */
    public function getPrinted()
    {
        return $this->printed;
    }

    /**
     * Set the value of printed
     *
     * @return  self
     */
    public function setPrinted($printed)
    {
        $this->printed = $printed;

        return $this;
    }

    /**
     * Get the value of interest
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set the value of interest
     *
     * @return  self
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get the value of id_quotation
     */
    public function getId_quotation()
    {
        return $this->id_quotation;
    }

    /**
     * Set the value of id_quotation
     *
     * @return  self
     */
    public function setId_quotation($id_quotation)
    {
        $this->id_quotation = $id_quotation;

        return $this;
    }

    /**
     * Get the value of estimated_delivery_date
     */
    public function getEstimated_delivery_date()
    {
        return $this->estimated_delivery_date;
    }

    /**
     * Set the value of estimated_delivery_date
     *
     * @return  self
     */
    public function setEstimated_delivery_date($estimated_delivery_date)
    {
        $this->estimated_delivery_date = $estimated_delivery_date;

        return $this;
    }

    /**
     * Get the value of external_code
     */
    public function getExternal_code()
    {
        return $this->external_code;
    }

    /**
     * Set the value of external_code
     *
     * @return  self
     */
    public function setExternal_code($external_code)
    {
        $this->external_code = $external_code;

        return $this;
    }

    /**
     * Get the value of has_payment
     */
    public function getHas_payment()
    {
        return $this->has_payment;
    }

    /**
     * Set the value of has_payment
     *
     * @return  self
     */
    public function setHas_payment($has_payment)
    {
        $this->has_payment = $has_payment;

        return $this;
    }

    /**
     * Get the value of has_shipment
     */
    public function getHas_shipment()
    {
        return $this->has_shipment;
    }

    /**
     * Set the value of has_shipment
     *
     * @return  self
     */
    public function setHas_shipment($has_shipment)
    {
        $this->has_shipment = $has_shipment;

        return $this;
    }

    /**
     * Get the value of has_invoice
     */
    public function getHas_invoice()
    {
        return $this->has_invoice;
    }

    /**
     * Set the value of has_invoice
     *
     * @return  self
     */
    public function setHas_invoice($has_invoice)
    {
        $this->has_invoice = $has_invoice;

        return $this;
    }

    /**
     * Get the value of total_comission_user
     */
    public function getTotal_comission_user()
    {
        return $this->total_comission_user;
    }

    /**
     * Set the value of total_comission_user
     *
     * @return  self
     */
    public function setTotal_comission_user($total_comission_user)
    {
        $this->total_comission_user = $total_comission_user;

        return $this;
    }

    /**
     * Get the value of total_comission
     */
    public function getTotal_comission()
    {
        return $this->total_comission;
    }

    /**
     * Set the value of total_comission
     *
     * @return  self
     */
    public function setTotal_comission($total_comission)
    {
        $this->total_comission = $total_comission;

        return $this;
    }

    /**
     * Get the value of couponcode
     */
    public function getCouponcode()
    {
        return $this->couponcode;
    }

    /**
     * Set the value of couponcode
     *
     * @return  self
     */
    public function setCouponcode($couponcode)
    {
        $this->couponcode = $couponcode;

        return $this;
    }

    /**
     * Get the value of coupondiscount
     */
    public function getCoupondiscount()
    {
        return $this->coupondiscount;
    }

    /**
     * Set the value of coupondiscount
     *
     * @return  self
     */
    public function setCoupondiscount($coupondiscount)
    {
        $this->coupondiscount = $coupondiscount;

        return $this;
    }

    /**
     * Get the value of OrderStatusid
     */
    public function getOrderStatusid()
    {
        return $this->OrderStatusid;
    }

    /**
     * Set the value of OrderStatusid
     *
     * @return  self
     */
    public function setOrderStatusid($OrderStatusid)
    {
        $this->OrderStatusid = $OrderStatusid;

        return $this;
    }

    /**
     * Get the value of OrderStatusdefault
     */
    public function getOrderStatusdefault()
    {
        return $this->OrderStatusdefault;
    }

    /**
     * Set the value of OrderStatusdefault
     *
     * @return  self
     */
    public function setOrderStatusdefault($OrderStatusdefault)
    {
        $this->OrderStatusdefault = $OrderStatusdefault;

        return $this;
    }

    /**
     * Get the value of OrderStatustype
     */
    public function getOrderStatustype()
    {
        return $this->OrderStatustype;
    }

    /**
     * Set the value of OrderStatustype
     *
     * @return  self
     */
    public function setOrderStatustype($OrderStatustype)
    {
        $this->OrderStatustype = $OrderStatustype;

        return $this;
    }

    /**
     * Get the value of OrderStatusshow_backoffice
     */
    public function getOrderStatusshow_backoffice()
    {
        return $this->OrderStatusshow_backoffice;
    }

    /**
     * Set the value of OrderStatusshow_backoffice
     *
     * @return  self
     */
    public function setOrderStatusshow_backoffice($OrderStatusshow_backoffice)
    {
        $this->OrderStatusshow_backoffice = $OrderStatusshow_backoffice;

        return $this;
    }

    /**
     * Get the value of OrderStatusallow_edit_order
     */
    public function getOrderStatusallow_edit_order()
    {
        return $this->OrderStatusallow_edit_order;
    }

    /**
     * Set the value of OrderStatusallow_edit_order
     *
     * @return  self
     */
    public function setOrderStatusallow_edit_order($OrderStatusallow_edit_order)
    {
        $this->OrderStatusallow_edit_order = $OrderStatusallow_edit_order;

        return $this;
    }

    /**
     * Get the value of OrderStatusdescription
     */
    public function getOrderStatusdescription()
    {
        return $this->OrderStatusdescription;
    }

    /**
     * Set the value of OrderStatusdescription
     *
     * @return  self
     */
    public function setOrderStatusdescription($OrderStatusdescription)
    {
        $this->OrderStatusdescription = $OrderStatusdescription;

        return $this;
    }

    /**
     * Get the value of OrderStatusstatus
     */
    public function getOrderStatusstatus()
    {
        return $this->OrderStatusstatus;
    }

    /**
     * Set the value of OrderStatusstatus
     *
     * @return  self
     */
    public function setOrderStatusstatus($OrderStatusstatus)
    {
        $this->OrderStatusstatus = $OrderStatusstatus;

        return $this;
    }

    /**
     * Get the value of OrderStatusshow_status_central
     */
    public function getOrderStatusshow_status_central()
    {
        return $this->OrderStatusshow_status_central;
    }

    /**
     * Set the value of OrderStatusshow_status_central
     *
     * @return  self
     */
    public function setOrderStatusshow_status_central($OrderStatusshow_status_central)
    {
        $this->OrderStatusshow_status_central = $OrderStatusshow_status_central;

        return $this;
    }

    /**
     * Get the value of OrderStatusbackground
     */
    public function getOrderStatusbackground()
    {
        return $this->OrderStatusbackground;
    }

    /**
     * Set the value of OrderStatusbackground
     *
     * @return  self
     */
    public function setOrderStatusbackground($OrderStatusbackground)
    {
        $this->OrderStatusbackground = $OrderStatusbackground;

        return $this;
    }



    /**
     * Get the value of Orderid
     */
    public function getOrderid()
    {
        return $this->Orderid;
    }

    /**
     * Set the value of Orderid
     *
     * @return  self
     */
    public function setOrderid($Orderid)
    {
        $this->Orderid = $Orderid;

        return $this;
    }

    /**
     * Get the value of nomeCliente
     */
    public function getNomeCliente()
    {
        return $this->nomeCliente;
    }

    /**
     * Set the value of nomeCliente
     *
     * @return  self
     */
    public function setNomeCliente($nomeCliente)
    {
        $this->nomeCliente = $nomeCliente;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telefone
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     *
     * @return  self
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @return  self
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get the value of NumeroCasa
     */
    public function getNumeroCasa()
    {
        return $this->NumeroCasa;
    }

    /**
     * Set the value of NumeroCasa
     *
     * @return  self
     */
    public function setNumeroCasa($NumeroCasa)
    {
        $this->NumeroCasa = $NumeroCasa;

        return $this;
    }

    /**
     * Get the value of referencia
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set the value of referencia
     *
     * @return  self
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get the value of cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @return  self
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of vizinho
     */
    public function getVizinho()
    {
        return $this->vizinho;
    }

    /**
     * Set the value of vizinho
     *
     * @return  self
     */
    public function setVizinho($vizinho)
    {
        $this->vizinho = $vizinho;

        return $this;
    }

    /**
     * Get the value of cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @return  self
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of uf
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set the value of uf
     *
     * @return  self
     */
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get the value of ChaveNf
     */
    public function getChaveNf()
    {
        return $this->ChaveNf;
    }

    /**
     * Set the value of ChaveNf
     *
     * @return  self
     */
    public function setChaveNf($ChaveNf)
    {
        $this->ChaveNf = $ChaveNf;

        return $this;
    }

    /**
     * Get the value of NumeroNf
     */
    public function getNumeroNf()
    {
        return $this->NumeroNf;
    }

    /**
     * Set the value of NumeroNf
     *
     * @return  self
     */
    public function setNumeroNf($NumeroNf)
    {
        $this->NumeroNf = $NumeroNf;

        return $this;
    }

    /**
     * Get the value of dataNf
     */
    public function getDataNf()
    {
        return $this->dataNf;
    }

    /**
     * Set the value of dataNf
     *
     * @return  self
     */
    public function setDataNf($dataNf)
    {
        $this->dataNf = $dataNf;

        return $this;
    }

    /**
     * Get the value of serieNf
     */
    public function getSerieNf()
    {
        return $this->serieNf;
    }

    /**
     * Set the value of serieNf
     *
     * @return  self
     */
    public function setSerieNf($serieNf)
    {
        $this->serieNf = $serieNf;

        return $this;
    }

    /**
     * Get the value of TotalNf
     */
    public function getTotalNf()
    {
        return $this->TotalNf;
    }

    /**
     * Set the value of TotalNf
     *
     * @return  self
     */
    public function setTotalNf($TotalNf)
    {
        $this->TotalNf = $TotalNf;

        return $this;
    }

    /**
     * Get the value of Peso
     */
    public function getPeso()
    {
        return $this->Peso;
    }

    /**
     * Set the value of Peso
     *
     * @return  self
     */
    public function setPeso($Peso)
    {
        $this->Peso = $Peso;

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of complement
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set the value of complement
     *
     * @return  self
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get the value of quantityVolume
     */
    public function getQuantityVolume()
    {
        return $this->quantityVolume;
    }

    /**
     * Get the value of dataVolumes
     */
    public function getDataVolumes()
    {
        return $this->dataVolumes;
    }

    /**
     * Get the value of produtos
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Get the value of produtosPainel
     */
    public function getProdutosPainel()
    {
        return $this->produtosPainel;
    }

    /**
     * Get the value of pdo
     */
    public function getPdo():PDO
    {
        return $this->pdo;
    }

    /**
     * Get the value of point_sale
     */
    public function getPointSale()
    {
        return $this->point_sale;
    }

    /**
     * Get the value of produtosNormal
     */
    public function getProdutosNormal()
    {
        return $this->produtosNormal;
    }
}
