<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaTelefonoModel extends Model{

    protected $table="PERSONATELEFONO";
    public $timestamps=false;
    public $incrementing=false;
    protected $attributes = [
        'st_telefono' => 1
    ];
    public $fillable=["tp_prioridad",
    "tp_telefono",
    "nu_telefono",
    "nu_area",
    "cd_persona"];
    public function fnValidaciones(){ return ["tp_prioridad"=>"required",
        "tp_telefono"=>"required",
        "nu_telefono"=>"required",
        "cd_area"=>"required",
        "cd_persona"=>"required"];}
    public function fnMensajes(){return ["tp_prioridad.required"=>"El campo está vacío.",
        "tp_telefono.required"=>"El campo está vacío.",
        "nu_telefono.required"=>"El campo está vacío.",
        "cd_area.required"=>"El campo está vacío.",
        "cd_persona.required"=>"El campo está vacío."];}
    
    public function fnCreate($request){
        try {
            $request->request->add(['st_telefono'=>1 ]);
            $arrayIgnorarIndices=[
                'nm_completo',
                'nm_persona1',
                'nm_persona2',
                'ap_persona_1',
                'ap_persona2',
                'tp_documento',
                'nu_documento',
                'cd_estado',
                'cd_municipio',
                'cd_parroquia',
                'de_direccion',
                'cd_profesion',
                'cd_sexo',
                'de_correo',
                'cd_asoproinfu',
                'in_asoproinfu','_token'];
            $this->create(
                $request->except($arrayIgnorarIndices)
            );
        } catch (Throwable $th) {
            print_r($th);
        }
    }
    public function fnUpdate($request){
        try {
            $arrayIgnorarIndices=[
                'cd_persona',
                'cd_empresa',
                'nm_completo',
                'nm_persona1',
                'nm_persona2',
                'ap_persona_1',
                'ap_persona2',
                'tp_documento',
                'nu_documento',
                'cd_estado',
                'cd_municipio',
                'cd_parroquia',
                'de_direccion',
                'cd_profesion',
                'cd_sexo',
                'de_correo',
                'cd_asoproinfu',
                'in_asoproinfu','_token'];
            $this->where('cd_persona',$request->post('cd_persona'))->update($request->except($arrayIgnorarIndices));
        } catch (Throwable $th) {
            print_r($th);
        }
    }

}
