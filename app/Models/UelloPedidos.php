<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UelloPedidos extends Model
{
    use HasFactory;

    protected $table = "UelloPedidos";


    public static function getDataByFilter($orderid,$enviado = null){

        $data = DB::table('UelloPedidos');

        // if($datainicial && $datafinal){
        //     $data->whereBetween('divergencia_order.dataVenda',[$datainicial, $datafinal]);
        // }

        if($orderid){
            $data->where('UelloPedidos.OrderId',$orderid);
        }

        if(!$enviado == null){
            if($enviado == 1){
                $data->where('UelloPedidos.NFenviada',$enviado);
            }else{
                $data->where('UelloPedidos.NFenviada',$enviado);
            }
        }

        $dados = $data->orderBy('id','desc')->paginate(10);
        return $dados;
    }
}
