<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoEndosoAseguradosModel extends Model{
    protected $table="CONTRATOENDOSOASEGURADOS";
    public $timestamps=false;
    public $incrementing=false;
    public $fillable=["cd_persona",
    "fe_exlusion",
    "fe_inclusion",
    "ta_riesgo",
    "cd_parentesco",
    "nu_endoso",
    "nu_certificado",
    "cd_empresa",
    "cd_producto",
    "nu_contrato"];
    public function fnValidaciones(){ return [
        "cd_persona"=>"required",
        "fe_exlusion"=>"required",
        "fe_inclusion"=>"required",
        "ta_riesgo"=>"required",
        "cd_parentesco"=>"required",
        "nu_endoso"=>"required",
        "nu_certificado"=>"required",
        "cd_empresa"=>"required",
        "cd_producto"=>"required",
        "nu_contrato"=>"required"];}
    public function fnMensajes(){
        return 
        ["cd_persona.required"=>"El campo está vacío.",
        "fe_exlusion.required"=>"El campo está vacío.",
        "fe_inclusion.required"=>"El campo está vacío.",
        "ta_riesgo.required"=>"El campo está vacío.",
        "cd_parentesco.required"=>"El campo está vacío.",
        "nu_endoso.required"=>"El campo está vacío.",
        "nu_certificado.required"=>"El campo está vacío.",
        "cd_empresa.required"=>"El campo está vacío.",
        "cd_producto.required"=>"El campo está vacío.",
        "nu_contrato.required"=>"El campo está vacío."];
    }
    function fnCreate($arrayAseguros){
        try {
            $this->create($arrayAseguros);
        } catch (Exception $th) {
            print_r($th);
        }
    }

}
