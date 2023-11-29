<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaDireccionModel extends Model{

    protected $table="personadireccion";
    public $timestamps=false;
    public $incrementing=false;
    protected $attributes = [
        'st_direccion' => 1
    ];
    public $fillable=["st_direccion",
    "tp_prioridad",
    "de_direccion",
    "cd_parroquia",
    "cd_municipio",
    "cd_estado",
    "cd_persona"];
    public function fnValidaciones(){ return ["st_direccion"=>"required",
        "de_direccion"=>"required",
        "cd_parroquia"=>"required",
        "cd_municipio"=>"required",
        "cd_estado"=>"required",
        "cd_persona"=>"required"];}
    public function fnMensajes(){return ["st_direccion.required"=>"El campo está vacío.",
        "tp_prioridad.required"=>"El campo está vacío.",
        "de_direccion.required"=>"El campo está vacío.",
        "cd_parroquia.required"=>"El campo está vacío.",
        "cd_municipio.required"=>"El campo está vacío.",
        "cd_estado.required"=>"El campo está vacío.",
        "cd_persona.required"=>"El campo está vacío."];}

    public function fnCreate($request){
        try {
            $request->request->add(['st_direccion'=>1 ]);
            $arrayIgnorarIndices=[
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
                'cd_profesion',
                'st_telefono',
                'cd_empresa',
                'fe_registro',
                'de_correo',
                'st_empresa',
                'st_persona',
                'cd_sexo',
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
                'nu_telefono',
                'nu_area',
                'nu_telefono_aux',
                'nu_area_aux',
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
