<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AutenticacionQuery;
use NegocioQuery;
use CatalogoQuery;
use DB;

class Auditoria extends Model{
    public function fnBusquedaParametrizada($constanteQuery,$parametros,$inQuery){
        $transaccionBD=array();
        $busqueda=array();
        try {
            //Autenticacion
            //print_r($parametros);
            if($inQuery==0){
                $busqueda=constant(AutenticacionQuery::class."::".$constanteQuery);
            }
            //Catalogo
            if($inQuery==1){
                $busqueda=constant(CatalogoQuery::class."::".$constanteQuery);
            }
            //Procesos
            if($inQuery==2){
                $busqueda=constant(NegocioQuery::class."::".$constanteQuery);
            }
           
            $transaccionBD=DB::select($busqueda,$parametros);
            $transaccionBD=array_map(function($valor){
                return (array)$valor;
            }, $transaccionBD);
            
        } catch (Exception $th) {
            print_r($th->getMessage());
        }
        return $transaccionBD; 
    }

    public function fnBuscarSecuenciaCatalogo($constanteQuery,$parametros){
        $transaccionBD=array();
        $busqueda=array();
        try {
            $busqueda=constant(CatalogoQuery::class."::".$constanteQuery);
            $transaccionBD=DB::select($busqueda,$parametros);
            $transaccionBD=array_map(function($valor){
                return (array)$valor;
            }, $transaccionBD);
        } catch (Exception $th) {
            print_r($th->getMessage());
        }
        return $transaccionBD; 
    }

}
