<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use Carbon\Carbon;

class ContratoModel extends Model{
    protected $table="CONTRATO";
    public $timestamps=false;
    public $incrementing=false;
    public $fillable=["cd_moneda",
    "st_contrato",
    "cd_empresa",
    "cd_usuario_emision",
    "cd_usuario_cotizacion",
    "fe_cotizacion",
    "fe_emision",
    "tp_contrato",
    "cd_producto",
    "cd_persona_asegurada",
    "nu_contrato"];
    protected $validations=["cd_moneda"=>"required",
    "st_contrato"=>"required",
    "cd_empresa"=>"required",
    "cd_usuario_emision"=>"required",
    "cd_usuario_cotizacion"=>"required",
    "fe_cotizacion"=>"required",
    "fe_emision"=>"required",
    "tp_contrato"=>"required",
    "cd_producto"=>"required",
    "cd_persona_asegurada"=>"required",
    "nu_contrato"=>"required"];
    protected $messages=[
    "cd_moneda.required"=>"El campo está vacío.",
    "st_contrato.required"=>"El campo está vacío.",
    "cd_empresa.required"=>"El campo está vacío.",
    "cd_usuario_emision.required"=>"El campo está vacío.",
    "cd_usuario_cotizacion.required"=>"El campo está vacío.",
    "fe_cotizacion.required"=>"El campo está vacío.",
    "fe_emision.required"=>"El campo está vacío.",
    "tp_contrato.required"=>"El campo está vacío.",
    "cd_producto.required"=>"El campo está vacío.",
    "cd_persona_asegurada.required"=>"El campo está vacío.",
    "nu_contrato.required"=>"El campo está vacío."];

    function fnCreate($request,$titular){
        $fecha=date("Y/m/d");
        $usuarioElaborador=Session::get('user')['cd_usuario'];
        //$empresa=Session::get('user')['cd_empresa'];
        $instanciaAuditoria=new Auditoria;
        $secuenciaContrato=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaContrato',array())[0]['secuencia'];
        $arrayContrato=array(
            'cd_producto'=>$request->post('cd_producto'),
            'cd_persona_asegurada'=>$titular,
            'tp_contrato'=>1,
            'fe_emision'=>$fecha,
            'fe_cotizacion'=>$fecha,
            'cd_usuario_cotizacion'=>$usuarioElaborador,
            'cd_usuario_emision'=>$usuarioElaborador,
            'cd_empresa'=>15,
            'st_contrato'=>1,
            'nu_contrato'=>$secuenciaContrato,
            'cd_moneda'=>2
        );
        
        $this->create($arrayContrato);
        return $secuenciaContrato;
    }

}
