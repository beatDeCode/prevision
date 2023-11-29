<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonaTelefonoModel;
use App\Models\PersonaCorreoModel;
use App\Models\PersonaDireccionModel;
use App\Models\Auditoria;
use App\Models\ContratoEndosoAseguradosModel;


class PersonasModel extends Model
{
    protected $table="personas";
    public $timestamps=false;
    public $incrementing=false;
    protected $primaryKey='cd_persona';
    public $fillable=[
    "st_persona",
    "nm_completo",
    "fe_fallecimiento",
    "fe_registro",
    "cd_profesion",
    "cd_sexo",
    "nu_documento",
    "tp_documento",
    "ap_persona2",
    "ap_persona1",
    "nm_persona2",
    "nm_persona1",
    "cd_persona"];
    protected function fnValidaciones(){ 
        return ["st_persona"=>"required",
        "nm_completo"=>"required",
        "fe_fallecimiento"=>"required",
        "fe_registro"=>"required",
        "cd_profesion"=>"required",
        "cd_sexo"=>"required",
        "nu_documento"=>"required",
        "tp_documento"=>"required",
        "ap_persona2"=>"required",
        "ap_persona1"=>"required",
        "nm_persona2"=>"required",
        "nm_persona1"=>"required",
        "cd_persona"=>"required"];}
    protected function fnValidacionesUpd(){ 
            return ["st_persona"=>"required",
            "nm_completo"=>"required",
            "fe_fallecimiento"=>"required",
            "fe_registro"=>"required",
            "cd_profesion"=>"required",
            "cd_sexo"=>"required",
            "tp_documento"=>"required",
            "ap_persona2"=>"required",
            "ap_persona1"=>"required",
            "nm_persona2"=>"required",
            "nm_persona1"=>"required",
            "cd_persona"=>"required"];}
    protected function fnMensajes(){ 
        return [
        "st_persona.required"=>"El campo está vacío.",
        "nm_completo.required"=>"El campo está vacío.",
        "fe_fallecimiento.required"=>"El campo está vacío.",
        "fe_registro.required"=>"El campo está vacío.",
        "cd_profesion.required"=>"El campo está vacío.",
        "cd_sexo.required"=>"El campo está vacío.",
        "nu_documento.required"=>"El campo está vacío.",
        "tp_documento.required"=>"El campo está vacío.",
        "ap_persona2.required"=>"El campo está vacío.",
        "ap_persona1.required"=>"El campo está vacío.",
        "nm_persona2.required"=>"El campo está vacío.",
        "nm_persona1.required"=>"El campo está vacío.",
        "cd_persona.required"=>"El campo está vacío."];
    }
    public function fnCreate($request){
        $secuenciaPersona='';
        try {
            $arrayIgnorarIndices=[
                'nu_telefono',
                'nu_area',
                'nu_telefono_aux',
                'nu_area_aux',
                'cd_estado',
                'cd_parroquia',
                'cd_municipio',
                'de_direccion',
                'cd_asoproinfu',
                'in_asoproinfu',
                'de_correo','_token'];
            $instanciaAuditoria=new Auditoria;
            $secuenciaPersona=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonas',array());
                
            $request->request->add(array('cd_persona'=>$secuenciaPersona[0]['secuencia']));
            $fecha=date('Y-m-d');
            $request->request->add(['fe_registro'=>$fecha ]);
            $request->request->add(['st_persona'=>1 ]);
            $this->create(
                $request->except($arrayIgnorarIndices)
            );

            $instanciaPersonaTelefono=new PersonaTelefonoModel;
            $instanciaPersonaCorreo=new PersonaCorreoModel;
            $instanciaPersonaDireccion=new PersonaDireccionModel;

            $instanciaPersonaTelefono->fnCreate($request);
            $instanciaPersonaCorreo->fnCreate($request);
            $instanciaPersonaDireccion->fnCreate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $secuenciaPersona;
    }

    public function fnUpdate($request){
        $secuenciaPersona='';
        try {
            $arrayIgnorarIndices=[
                'cd_empresa',
                'nu_telefono',
                'cd_empresa',
                'nu_area',
                'nu_telefono_aux',
                'nu_area_aux',
                'cd_asoproinfu',
                'in_asoproinfu',
                'cd_estado',
                'cd_parroquia',
                'cd_municipio',
                'de_direccion',
                'de_correo','_token','cd_persona'];
            $instanciaAuditoria=new Auditoria;
            $this->where('cd_persona',$request->post('cd_persona'))->update($request->except($arrayIgnorarIndices));

            $instanciaPersonaTelefono=new PersonaTelefonoModel;
            $instanciaPersonaCorreo=new PersonaCorreoModel;
            $instanciaPersonaDireccion=new PersonaDireccionModel;

            $instanciaPersonaTelefono->fnUpdate($request);
            $instanciaPersonaCorreo->fnUpdate($request);
            $instanciaPersonaDireccion->fnUpdate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $secuenciaPersona;
    }
    function fnCreateTitular($request){
        $secuenciaPersona='';
        try {
            $instanciaAuditoria=new Auditoria;
            $secuenciaPersona=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonas',array())[0]['secuencia'];
            $arrayPersona=array(
                'nm_persona1'=>$request->post('nm_persona1'),
                'ap_persona1'=>$request->post('ap_persona1'),
                'tp_documento'=>$request->post('tp_documento'),
                'nu_documento'=>$request->post('nu_documento'),
                'fe_nacimiento'=>$request->post('fe_nacimiento'),
                'cd_sexo'=>$request->post('cd_sexo'),
                'nm_completo'=>$request->post('nm_persona1').' '.$request->post('ap_persona1'),
                'st_persona'=>1,
                'cd_persona'=>$secuenciaPersona
            );
            $arrayPersonaDireccion=array(
                'cd_estado'=>$request->post('cd_estado'),
                'cd_municipio'=>$request->post('cd_municipio'),
                'cd_parroquia'=>$request->post('cd_parroquia'),
                'de_direccion'=>$request->post('de_direccion'),
                'cd_persona'=>$secuenciaPersona
            );
            $arrayTelefono=array(
                'nu_area'=>$request->post('nu_area'),
                'nu_telefono'=>$request->post('nu_telefono'),
                'st_telefono'=>1,
                'cd_persona'=>$secuenciaPersona
            );
            $arrayCorreo=array(
                'de_correo'=>$request->post('de_correo'),
            );
    
            $this->create(
                $arrayPersona
            );
            $instanciaPersonaTelefono=new PersonaTelefonoModel;
            $instanciaPersonaCorreo=new PersonaCorreoModel;
            $instanciaPersonaDireccion=new PersonaDireccionModel;
    
            $instanciaPersonaTelefono->create($arrayTelefono);
            $instanciaPersonaCorreo->create($arrayCorreo);
            $instanciaPersonaDireccion->create($arrayPersonaDireccion);
        } catch (Exception $th) {
            
        }
        return $secuenciaPersona;

    }
    function fnCreateAsegurados($request,$contrato,$titular){
        $arrayAsegurados='';
        try {
            $arraySecuencias=array();
            $instanciaAuditoria=new Auditoria;
            $instanciaContratoAsegurados=new ContratoEndosoAseguradosModel;
            //Busqueda tasa Riesgo para titular
            $tasaRiesgo=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaTasaRiesgoPorAsegurado',
                array(
                    'cd_producto'=>$request->post('cd_producto'),
                    'cd_grupo_familiar'=>$request->post('cd_grupo_familiar'),
                ))[0]['tasa_riesgo'];
            
            $fecha= date('d-M-y');
            $arrayTitular=array(
                "cd_persona"=>$titular,
                "fe_exlusion"=>'',
                "fe_inclusion"=>$fecha,
                "ta_riesgo"=>$tasaRiesgo,
                "cd_parentesco"=>1,
                "nu_endoso"=>0,
                "nu_certificado"=>0,
                "cd_empresa"=>15,
                "cd_producto"=>$request->post('cd_producto'),
                "nu_contrato"=>$contrato
            );
            //Almacenamos la informacion del titular en la tabla CONTRATOENDOSOASEGURADOSO
            $instanciaContratoAsegurados->fnCreate($arrayTitular);

            //Guardamos el asegurado en la tabla PERSONAS
            $secuenciaPersona=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonas',array())[0]['secuencia'];
            $arrayAsegurados1=array(
                'nm_persona1'=>$request->post('nm_persona1_asegurado'),
                'ap_persona1'=>$request->post('ap_persona1_asegurado'),
                'tp_documento'=>$request->post('tp_documento_asegurado'),
                'nu_documento'=>$request->post('nu_documento_asegurado'),
                'fe_nacimiento'=>$request->post('fe_nacimiento_asegurado'),
                'cd_sexo'=>$request->post('cd_sexo_asegurado'),
                'nm_completo'=>$request->post('nm_persona1_asegurado').' '.$request->post('ap_persona1_asegurado'),
                'cd_persona'=>$secuenciaPersona,
                'st_persona'=>1,
            );
            $this->create(
                $arrayAsegurados1
            );

            //Chequeamos si el parentesco es adicional.
            $confirmaAdicional=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaConfirmarAdicional',
            array(
                'cd_grupo_familiar'=>$request->post('cd_grupo_familiar'),
                'cd_parentesco'=>$request->post('cd_parentesco_asegurado'),
            ))[0]['cuenta'];

            //Si es adicional colocamos un valor a la tasa sino es 0
            if($confirmaAdicional==0){
                $tasaRiesgo=1.78;
            }else{
                $tasaRiesgo=0;
            }

            //Almacenamos la informacion del asegurado en la tabla CONTRATOENDOSOASEGURADOSO
            $arrayAseguradosEndoso1=array(
                "cd_persona"=>$secuenciaPersona,
                "fe_exlusion"=>'',
                "fe_inclusion"=>$fecha,
                "ta_riesgo"=>$tasaRiesgo,
                "cd_parentesco"=>$request->post('cd_parentesco_asegurado'),
                "nu_endoso"=>0,
                "nu_certificado"=>0,
                "cd_empresa"=>15,
                "cd_producto"=>$request->post('cd_producto'),
                "nu_contrato"=>$contrato
            );
            $instanciaContratoAsegurados->fnCreate($arrayAseguradosEndoso1);
            $varAseguradoAdc='';
            //Recorrido de asegurados            
            $contadorClonacion=$request->post('ca_clonacion');
            if($contadorClonacion>0){
                for($a=0;$a<$contadorClonacion;$a++){
                    $secuenciaPersonaAsegurada=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaPersonas',array())[0]['secuencia'];
                    //Guardamos los asegurados en la tabla PERSONAS
                    $arrayAsegurados2=array(
                        'nm_persona1'=>$request->post('nm_persona1_asegurado'.$a),
                        'ap_persona1'=>$request->post('ap_persona1_asegurado'.$a),
                        'tp_documento'=>$request->post('tp_documento_asegurado'.$a),
                        'nu_documento'=>$request->post('nu_documento_asegurado'.$a),
                        'fe_nacimiento'=>$request->post('fe_nacimiento_asegurado'.$a),
                        'cd_sexo'=>$request->post('cd_sexo_asegurado'.$a),
                        'nm_completo'=>$request->post('nm_persona1_asegurado'.$a).' '.$request->post('ap_persona1_asegurado'.$a),
                        'cd_persona'=>$secuenciaPersonaAsegurada,
                        'st_persona'=>1,
                    );
                    $this->create(
                        $arrayAsegurados2
                    );
                    $arrayAsegurados2=array();
                    //Chequeamos si el parentesco es adicional.
                    $confirmaAdicional=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaConfirmarAdicional',
                    array(
                        'cd_grupo_familiar'=>$request->post('cd_grupo_familiar'),
                        'cd_parentesco'=>$request->post('cd_parentesco_asegurado'.$a),
                    ))[0]['cuenta'];
                    if($confirmaAdicional==0){
                        $tasaRiesgo=1.78;
                    }else{
                        $tasaRiesgo=0;
                    }
                    $varAseguradoAdc=$request->post('cd_parentesco_asegurado'.$a);

                    //Almacenamos la informacion del asegurado en la tabla CONTRATOENDOSOASEGURADOSO
                    $arrayAseguradosEndoso2=array(
                        "cd_persona"=>$secuenciaPersonaAsegurada,
                        "fe_exlusion"=>'',
                        "fe_inclusion"=>$fecha,
                        "ta_riesgo"=>$tasaRiesgo,
                        "cd_parentesco"=>$request->post('cd_parentesco_asegurado'.$a),
                        "nu_endoso"=>0,
                        "nu_certificado"=>0,
                        "cd_empresa"=>15,
                        "cd_producto"=>$request->post('cd_producto'),
                        "nu_contrato"=>$contrato
                    );
                    $instanciaContratoAsegurados->fnCreate($arrayAseguradosEndoso2);
                }
            }

        } catch (Exception $th) {
            print_r($th);
        }
        return $varAseguradoAdc;
    }

     
}
