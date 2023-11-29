<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Session;

class ContratoCertificadoModel extends Model{
    protected $table="CONTRATOCERTIFICADO";
    public $timestamps=false;
    public $incrementing=false;
    public $fillable=[
    "cd_empresa",
    "cd_causa_anulacion",
    "nu_ultimo_endoso",
    "cd_producto",
    "nu_certificado",
    "cd_persona_asegurada",
    "fe_hasta",
    "fe_desde",
    "fe_emision_certificado",
    "nu_contrato"];
    protected $validations=[
    "cd_empresa"=>"required",
    "cd_causa_anulacion"=>"required",
    "nu_ultimo_endoso"=>"required",
    "cd_producto"=>"required",
    "nu_certificado"=>"required",
    "cd_persona_asegurada"=>"required",
    "fe_hasta"=>"required",
    "fe_desde"=>"required",
    "fe_emision_certificado"=>"required",
    "nu_contrato"=>"required"];
    protected $messages=[
    "cd_empresa.required"=>"El campo está vacío.",
    "nu_ultimo_endoso.required"=>"El campo está vacío.",
    "cd_producto.required"=>"El campo está vacío.",
    "nu_certificado.required"=>"El campo está vacío.",
    "cd_persona_asegurada.required"=>"El campo está vacío.",
    "fe_hasta.required"=>"El campo está vacío.",
    "fe_desde.required"=>"El campo está vacío.",
    "fe_emision_certificado.required"=>"El campo está vacío.",
    "nu_contrato.required"=>"El campo está vacío."];
    function fnCreate($request,$titular,$contrato){
        $fecha=date("Y/m/d");
        $fechaHasta=date("Y/m/d",strtotime('+1 year'));
        $usuarioElaborador=Session::get('user')['cd_usuario'];
        //$empresa=Session::get('user')['cd_empresa'];
        $arrayContrato=array(
            'cd_producto'=>$request->post('cd_producto'),
            'cd_persona_asegurada'=>$titular,
            'nu_ultimo_endoso'=>0,
            'cd_empresa'=>15,
            'nu_contrato'=>$contrato,
            'nu_certificado'=>0,
            'fe_hasta'=>$fechaHasta,//Carbon::now()->addYear()->format('Y/m/d'),
            'fe_desde'=>$fecha,
            'fe_emision_certificado'=>$fecha,

        );
        $this->create($arrayContrato);
    }

}
