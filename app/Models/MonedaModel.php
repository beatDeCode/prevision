<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Models\Auditoria;

class MonedaModel extends Model{
    protected $table="MONEDA";
    public $timestamps=false;
    public $incrementing=false;
    protected $fillable=[
        "st_moneda",
        "de_moneda",
        "de_siglas_moneda",
        "cd_moneda"];
    public function validaciones(){
        return [
        "st_moneda"=>"required",
        "de_moneda"=>"required|unique:moneda,de_moneda",
        "cd_moneda"=>"required",
        "de_siglas_moneda"=>"required"
    ];
    }

    public function validacionesUpd () {
        return [
            "st_moneda"=>"required",
            "de_moneda"=>"required",
            "cd_moneda"=>"required",
            "de_siglas_moneda"=>"required"];
    }
    public function mensajes () {
        return [
            "de_siglas_moneda.required"=>"El campo está vacío.",
            "st_moneda.required"=>"El campo está vacío.",
            "de_moneda.required"=>"El campo está vacío.",
            "cd_moneda.required"=>"El campo está vacío.",
            "de_moneda.unique"=>"El valor existe."];
    }

    
    function fnCreate($request){
        $validacionFormulario=array();
        $detalleOperacion=array();
        $instanciaAuditoria=new Auditoria;
        
        try {
            $request->request->add(['cd_moneda'=> 1 ]);
            $validacionFormulario = Validator::make(
                $request->all(),
                $this->validaciones(),
                $this->mensajes()
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
                $secuencia=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaMoneda',array());
                $request->request->add(['cd_moneda'=> $secuencia[0]['secuencia'] ]);
                $this->create($request->except(
                    '_token','tp_operacion'
                ));
                $mensajeExitoso='Se creó con exito la moneda'.$request->post('de_moneda');
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

    function fnUpdate($request){
        $validacionFormulario=array();
        $detalleOperacion=array();
        $retorno=array();
        try {
            $validacionFormulario = Validator::make(
                $request->except('_token'),
                $this->validacionesUpd(),
                $this->mensajes()
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
                $this->where(
                    'cd_moneda',$request->post('cd_moneda'))
                    ->update($request->except('_token','cd_moneda')
                );
                $mensajeExitoso='Se actualizó con exito la moneda'.$request->post('de_moneda');
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
