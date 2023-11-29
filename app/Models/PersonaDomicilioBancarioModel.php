<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class PersonaDomicilioBancarioModel extends Model{
    protected $table="PERSONADOMICILIOBANCARIO";
    public $timestamps=false;
    public $incrementing=false;
    protected $fillable=[
    "cd_persona",
    "st_cuenta",
    "tp_cuenta",
    "nu_cuenta",
    "cd_banco",
    "cd_domicilio"];
    public function fnValidaciones(){ 
        return [
        "st_cuenta"=>"required",
        "tp_cuenta"=>"required",
        "nu_cuenta"=>"required",
        "cd_banco"=>"required"];
    }
    public function fnMensajes(){return [
        "st_cuenta.required"=>"El campo está vacío.",
        "tp_cuenta.required"=>"El campo está vacío.",
        "nu_cuenta.required"=>"El campo está vacío.",
        "cd_banco.required"=>"El campo está vacío.",];
    }

    public function fnClonacionValidaciones($contadorClonacion){
        $valoresValidaciones=
            array_keys($this->fnValidaciones());
        $valores=array();
        for($b=0;$b<sizeof($valoresValidaciones);$b++){
            $valores[$valoresValidaciones[$b]]='required';
        }
        for($a=0;$a<$contadorClonacion;$a++){
            for($b=0;$b<sizeof($valoresValidaciones);$b++){
                $valores[$valoresValidaciones[$b].''.$a]='required';
            }
        }
        return $valores;
    }
    public function fnClonacionMensajes($contadorClonacion){
        $valoresMensajes=
            array_keys($this->fnMensajes());
        $valores=array();
        for($b=0;$b<sizeof($valoresMensajes);$b++){
            $mensajeDesglosado=explode('.',$valoresMensajes[$b]);
            $indice=$mensajeDesglosado[0].'.'.$mensajeDesglosado[1];
            $valores[$indice]='El campo está vacío.';
        }
        for($a=0;$a<$contadorClonacion;$a++){
            for($b=0;$b<sizeof($valoresMensajes);$b++){
                $mensajeDesglosado=explode('.',$valoresMensajes[$b]);
                $indice=$mensajeDesglosado[0].''.$a.'.'.$mensajeDesglosado[1];
                $valores[$indice]='El campo está vacío.';
            }
        }
        return $valores;
    }
    function fnCreate($request,$contadorClonacion,$codigoPersona){
        $validacionFormulario=array();
        $detalleOperacion=array();
        $instanciaAuditoria=new Auditoria;
        try {
            $request->request->add(['cd_empresa'=> 1 ]);
            $validacionFormulario = Validator::make(
                $request->all(),
                $this->fnClonacionValidaciones($contadorClonacion),
                $this->fnClonacionMensajes($contadorClonacion)
            );
            
            if($validacionFormulario->fails()){
                $detalleOperacion= $validacionFormulario->errors();
                $retorno=array(
                    'httpResponse'=>400,
                    'message'=>array(
                        'validate'=>0,
                        'content'=>$detalleOperacion,
                        'object'=>array(),
                    ),
                    'error'=>1
                );
            }else{
                $secuencia=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonaDomiclio',array());
                $arrayIgnorarIndices=[
                    '_token'
                ];
                $valoresRequest=$request->except($arrayIgnorarIndices);

                $valoresInsercion=array();
                $indicesTabla=array_keys($this->fnValidaciones());
                
                for($a=0;$a<sizeof($indicesTabla);$a++ ){
                    $valoresInsercion[$indicesTabla[$a]]=$valoresRequest[$indicesTabla[$a]];
                }
                $valoresInsercion['cd_persona']=$codigoPersona;
                $valoresInsercion['cd_domicilio']=$secuencia[0]['secuencia'];
                //print_r($valoresInsercion);
                $this->create($valoresInsercion);
                if($contadorClonacion>0){
                    $valoresInsercion=array();
                    for($b=0;$b<$contadorClonacion;$b++){
                        $secuencia=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonaDomiclio',array());
                        $valoresInsercion['cd_persona']=$request->post('cd_persona');
                        $valoresInsercion['cd_domicilio']=$secuencia[0]['secuencia'];
                        for($a=0;$a<sizeof($indicesTabla);$a++ ){
                            $valoresInsercion[$indicesTabla[$a]]=$valoresRequest['clone'.$indicesTabla[$a].''.$b];
                        }
                        $this->create($valoresInsercion);
                    }
                }
                
                $mensajeExitoso='Se creó con exito la cuentas ';
                $retorno=array(
                    'httpResponse'=>200,
                    'message'=>array(
                        'validate'=>0,
                        'content'=>$mensajeExitoso,
                        'object'=>array(),
                    ),
                    'error'=>0
                );
            }
        } catch (Throwable $th) {
            print_r($th);
        }
        return json_encode($retorno);
    }


}
