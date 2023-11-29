<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonaTelefonoModel;
use App\Models\PersonaCorreoModel;
use App\Models\PersonaDireccionModel;
use App\Models\Auditoria;

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

     
}
