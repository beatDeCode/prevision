<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaCorreoModel extends Model{
    protected $table="personacorreo";
    public $timestamps=false;
    public $incrementing=false;
    protected $attributes = [
        'st_correo' => 1
    ];
    public $fillable=["st_correo",
    "de_correo",
    "cd_persona"];
    public function fnValidaciones(){ return ["st_correo"=>"required",
        "de_correo"=>"required",
        "cd_persona"=>"required"];}
    public function fnMensajes(){return ["st_correo.required"=>"El campo está vacío.",
        "de_correo.required"=>"El campo está vacío.",
        "cd_persona.required"=>"El campo está vacío."];}
    public function fnCreate($request){
        try {
            $request->request->add(['st_correo'=>1 ]);
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
                'cd_estado',
                'cd_parroquia',
                'cd_municipio',
                'de_direccion',
                'st_telefono',
                'fe_registro',
                'st_empresa',
                'st_persona',
                'cd_sexo',
                'cd_asoproinfu',
                'in_asoproinfu','_token'];
            $this->create($request->except($arrayIgnorarIndices));
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
                'ap_persona1',
                'ap_persona2',
                'tp_documento',
                'nu_documento',
                'nu_telefono',
                'nu_area',
                'nu_telefono_aux',
                'nu_area_aux',
                'cd_profesion',
                'cd_sexo',
                'cd_asoproinfu',
                'cd_estado',
                'cd_parroquia',
                'cd_municipio',
                'de_direccion',
                'in_asoproinfu','_token'];
            $this->where('cd_persona',$request->post('cd_persona'))->update($request->except($arrayIgnorarIndices));
    
        } catch (Throwable $th) {
            print_r($th);
        }
    }
}
