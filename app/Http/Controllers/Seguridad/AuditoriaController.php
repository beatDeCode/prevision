<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;

class AuditoriaController extends Controller{

    public function fnBusquedaGeneral(Request $request){
        $retorno=array();
        try {
            $instanciaAuditoria=new Auditoria;
            $arrayParaBusqueda=array();
            //print_r($request->post());
            $busqueda=$instanciaAuditoria->fnBusquedaParametrizada(
                $request->post('query'),
                $request->except(
                    array('_token','tp_query','query'),
                ),
                $request->post('tp_query')
                );
            $retorno=array(
                'httpResponse'=>200,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$busqueda,
                    'object'=>array(),
                ),
                'error'=>1
            );
        } catch (Throwable $th) {
            $retorno=array(
                'httpResponse'=>400,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$th->getMessage(),
                    'object'=>array(),
                ),
                'error'=>1
            );
        }
        return json_encode($retorno);
    }
}
