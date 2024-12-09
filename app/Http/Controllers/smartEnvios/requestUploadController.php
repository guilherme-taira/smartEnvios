<?php

namespace App\Http\Controllers\smartEnvios;

use App\Http\Controllers\Controller;
use CURLFile;
use Illuminate\Http\Request;

class requestUploadController extends Controller
{


    public function getEtiqueta(){

    }


    public function RequestUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $upload = new requestSmartEnviosController("a66cb425-a04c-460a-a0ac-b5ef61367e50",$request->freight_order_id,$file,"jsVC2QAsoHijI0ULb7hkyku9kq8117nw");
            $status = $upload->resource();
            (new etiquetaController($upload))->resource();

            if($status == "200"){
                return redirect()->back()->with('msg',"Xml Enviada Com Sucesso!");
            }else{
                $data = json_decode(json_encode($status));
                return redirect()->back()->with('error',$data->message);
            }

        } else {
            return redirect()->back()->with('msg',"Envie o Xml da nota fiscal");
        }
    }
}
