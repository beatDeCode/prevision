<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonasModel;
use Carbon\Carbon;
use Validator;
use App\Models\PersonaDomicilioBancarioModel;

class EmpresasModel extends Model{
    protected $table="EMPRESAS";
    public $timestamps=false;
    public $incrementing=false;
    protected $attributes = [
        'st_empresa' => 1
    ];
    public $fillable=["st_empresa",
    "fe_registro",
    "cd_asoproinfu",
    "in_asoproinfu",
    "cd_persona",
    "cd_empresa"];

    protected function validaciones(){ 
    return [
        "nm_completo"=>"required",
        "tp_documento"=>"required",
        "nu_documento"=>"required|unique:personas,nu_documento",
        "nu_area"=>"required",
        "nu_telefono"=>"required",
        "de_correo"=>"required",
        "cd_estado"=>"required",
        "cd_municipio"=>"required",
        "cd_parroquia"=>"required",
        "de_direccion"=>"required",
        "cd_asoproinfu"=>"required",
        "in_asoproinfu"=>"required",
        "cd_persona"=>"required",
        "cd_empresa"=>"required"];}
    
    protected function validacionesUpd(){ 
    return [
        "nm_completo"=>"required",
        "tp_documento"=>"required",
        "nu_documento"=>"required",
        "nu_area"=>"required",
        "nu_telefono"=>"required",
        "de_correo"=>"required",
        "cd_estado"=>"required",
        "cd_municipio"=>"required",
        "cd_parroquia"=>"required",
        "de_direccion"=>"required",
        "cd_asoproinfu"=>"required",
        "in_asoproinfu"=>"required",
        "cd_persona"=>"required",
        "cd_empresa"=>"required"];}

    protected function mensajes(){ 
    return [
        "nm_completo.required"=>"El campo está vacío.",
        "tp_documento.required"=>"El campo está vacío.",
        "nu_documento.required"=>"El campo está vacío.",
        "nu_documento.unique"=>"El valor existe.",
        "nu_area.required"=>"El campo está vacío.",
        "nu_telefono.required"=>"El campo está vacío.",
        "de_correo.required"=>"El campo está vacío.",
        "cd_estado.required"=>"El campo está vacío.",
        "cd_municipio.required"=>"El campo está vacío.",
        "cd_parroquia.required"=>"El campo está vacío.",
        "de_direccion.required"=>"El campo está vacío.",
        "st_empresa.required"=>"El campo está vacío.",
        "in_asoproinfu.required"=>"El campo está vacío.",
        "cd_persona.required"=>"El campo está vacío.",
        "cd_empresa.required"=>"El campo está vacío."];}

    function fnCreate($request){
        $validacionFormulario=array();
        $detalleOperacion=array();
        $instanciaAuditoria=new Auditoria;
        try {
            $request->request->add(['cd_empresa'=> 1 ]);
            $request->request->add(['cd_persona'=> 1 ]);
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
                $secuencia=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaEmpresas',array());
                $request->request->add(['cd_empresa'=> $secuencia[0]['secuencia'] ]);
                $fecha=date('Y-m-d');
                $valorInAsoprofinfu=$request->post('in_asoproinfu');
                if($valorInAsoprofinfu=='on'){
                    $valorInAsoprofinfu=1;
                }else{
                    $valorInAsoprofinfu=0;
                }
                $secuenciaPersona=$instanciaPersonas=new PersonasModel;
                $request->request->add(['cd_persona'=> $secuenciaPersona ]);
                $request->request->add(['fe_registro'=> $fecha ]);
                $request->request->add(['st_empresa'=>1 ]);
                $retornoPersona=$instanciaPersonas->fnCreate($request);
                $arrayIgnorarIndices=[
                    'nm_completo',
                    'nm_persona1',
                    'nm_persona2',
                    'ap_persona_1',
                    'ap_persona2',
                    'tp_documento',
                    'nu_documento',
                    'nu_telefono',
                    'nu_area',
                    'nu_telefono_aux',
                    'nu_area_aux',
                    'cd_estado',
                    'cd_parroquia',
                    'cd_municipio',
                    'de_direccion',
                    'cd_profesion',
                    'de_correo',
                    'cd_sexo','_token'
                ];
                $request->request->add(['in_asoproinfu'=>$valorInAsoprofinfu]);
                $this->create($request->except(
                    $arrayIgnorarIndices
                ));
                $mensajeExitoso=$request->post('cd_persona');
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
        $instanciaAuditoria=new Auditoria;
        try {
            $validacionFormulario = Validator::make(
                $request->all(),
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
                $valorInAsoprofinfu=$request->post('in_asoproinfu');
                if($valorInAsoprofinfu=='on'){
                    $valorInAsoprofinfu=1;
                }else{
                    $valorInAsoprofinfu=0;
                }
                $instanciaPersonas=new PersonasModel;
                $retornoPersona=$instanciaPersonas->fnUpdate($request);
                $arrayIgnorarIndices=[
                    'cd_empresa',
                    'nm_completo',
                    'nm_persona1',
                    'nm_persona2',
                    'ap_persona1',
                    'ap_persona2',
                    'tp_documento',
                    'nu_documento',
                    'nu_telefono',
                    'nu_area',
                    'nu_telefono_aux',
                    'nu_area_aux',
                    'cd_estado',
                    'cd_parroquia',
                    'cd_municipio',
                    'de_direccion',
                    'cd_profesion',
                    'de_correo',
                    'cd_sexo','_token'
                ];
                $request->request->add(['in_asoproinfu'=>$valorInAsoprofinfu]);
                $this->where('cd_empresa',$request->post('cd_empresa'))->update($request->except($arrayIgnorarIndices));
                $mensajeExitoso='Se creó con exito la moneda'.$request->post('nm_completo');
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
