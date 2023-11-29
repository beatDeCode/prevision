<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Session;

class ContratoCertificadoEndosoModel extends Model{
    protected $table="CONTRATOCERTIFICADOENDOSO";
    public $timestamps=false;
    public $incrementing=false;
    public $fillable=[
    "cd_persona_intermediario",
    "cd_domicilio",
    "tp_pago",
    "cd_usuario",
    "cd_transaccion",
    "nu_certificado",
    "nu_endoso",
    "fe_endoso",
    "cd_plan_pago",
    "cd_empresa",
    "cd_producto",
    "nu_contrato"];
    protected $validations=
    ["cd_persona_intermediario"=>"required",
    "cd_domicilio"=>"required",
    "tp_pago"=>"required",
    "cd_usuario"=>"required",
    "cd_transaccion"=>"required",
    "nu_certificado"=>"required",
    "nu_endoso"=>"required",
    "fe_endoso"=>"required",
    "cd_plan_pago"=>"required",
    "cd_empresa"=>"required",
    "cd_producto"=>"required",
    "nu_contrato"=>"required"];
    protected $messages=["cd_persona_intermediario.required"=>"El campo está vacío.",
    "cd_domicilio.required"=>"El campo está vacío.",
    "tp_pago.required"=>"El campo está vacío.",
    "cd_usuario.required"=>"El campo está vacío.",
    "cd_transaccion.required"=>"El campo está vacío.",
    "nu_certificado.required"=>"El campo está vacío.",
    "nu_endoso.required"=>"El campo está vacío.",
    "fe_endoso.required"=>"El campo está vacío.",
    "cd_plan_pago.required"=>"El campo está vacío.",
    "cd_empresa.required"=>"El campo está vacío.",
    "cd_producto.required"=>"El campo está vacío.",
    "nu_contrato.required"=>"El campo está vacío."];

    function fnCreate($request,$contrato,$domicilio){
        $usuarioElaborador=Session::get('user')['cd_usuario'];
        //$empresa=Session::get('user')['cd_empresa'];
        $fecha=date('d-M-y');
        $arrayContratoEndoso=array(
            "cd_persona_intermediario"=>2,
            "cd_domicilio"=>$domicilio,
            "tp_pago"=>$request->post('cd_forma_pago'),
            "cd_usuario"=>$usuarioElaborador,
            "cd_transaccion"=>1,
            "nu_certificado"=>0,
            "nu_endoso"=>0,
            "fe_endoso"=>$fecha,//Carbon::now()->format('Y/m/d'),
            "cd_plan_pago"=>$request->post('cd_plan_pago'),
            "cd_empresa"=>15,
            "cd_producto"=>$request->post('cd_producto'),
            "nu_contrato"=>$contrato
        );
        $this->create($arrayContratoEndoso);
    }


}
