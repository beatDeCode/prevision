<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auditoria;
use Exception;

class RecibosModel extends Model{
    protected $table="RECIBOS";
    public $timestamps=false;
    public $incrementing=false;
    public $fillable=["cd_recibo",
    "nu_egreso",
    "nu_ingreso",
    "tp_transaccion",
    "st_recibo",
    "po_comision",
    "mt_iva",
    "mt_recibo",
    "fe_hasta",
    "fe_desde",
    "nu_endoso",
    "nu_certificado",
    "nu_contrato",
    "cd_producto"];
    public function fnValidaciones(){ return ["cd_recibo"=>"required",
        "nu_egreso"=>"required",
        "nu_ingreso"=>"required",
        "tp_transaccion"=>"required",
        "st_recibo"=>"required",
        "po_comision"=>"required",
        "mt_iva"=>"required",
        "mt_recibo"=>"required",
        "fe_hasta"=>"required",
        "fe_desde"=>"required",
        "nu_endoso"=>"required",
        "nu_certificado"=>"required",
        "nu_contrato"=>"required",
        "cd_producto"=>"required"];}
    public function fnMensajes(){return ["cd_recibo.required"=>"El campo está vacío.",
        "nu_egreso.required"=>"El campo está vac¿o.",
        "nu_ingreso.required"=>"El campo está vacío.",
        "tp_transaccion.required"=>"El campo está vacío.",
        "st_recibo.required"=>"El campo está vacío.",
        "po_comision.required"=>"El campo está vacío.",
        "mt_iva.required"=>"El campo está vacío.",
        "mt_recibo.required"=>"El campo está vacío.",
        "fe_hasta.required"=>"El campo está vacío.",
        "fe_desde.required"=>"El campo está vacío.",
        "nu_endoso.required"=>"El campo está vacío.",
        "nu_certificado.required"=>"El campo está vacío.",
        "nu_contrato.required"=>"El campo está vacío.",
        "cd_producto.required"=>"El campo está vacío."];}

    public function fnCreateFacturacion($contrato){
        $fecha=date("Y/m/d");
        
        try {
            $instanciaAuditoria=new Auditoria;
            //Busqueda tasa Riesgo para titular
            $busquedaInformacionContrato=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaInformacionContrato',
                array('cd_contrato'=>$contrato),
                2
            );
            $cantidadRecibos=$busquedaInformacionContrato[0]['ca_recibo'];
            $mesesRecibos=$busquedaInformacionContrato[0]['nu_meses_recibo'];
            $contador=0;
            $contadorGeneral=0;
            while($cantidadRecibos>$contadorGeneral){
                $contadorGeneral+=1;
                $secuenciaRecibo=$instanciaAuditoria->fnBuscarSecuenciaCatalogo('busquedaSecuenciaRecibo',array())[0]['secuencia'];
                $mes=$contador;
                $mesHasta=$contador+$mesesRecibos;
                
                $fechaDesde=date("Y/m/d",strtotime('+'.$mes.' month'));
                $fechaHasta=date("Y/m/d",strtotime('+'.$mesHasta.' month'));
                $arrayRecibos=array(
                    "cd_recibo"=>$secuenciaRecibo,
                    "nu_egreso"=>'',
                    "nu_ingreso"=>'',
                    "tp_transaccion"=>1,
                    "st_recibo"=>1,
                    "po_comision"=>0,
                    "mt_iva"=>0,
                    "mt_recibo"=>$busquedaInformacionContrato[0]['mt_prima_recibo'],
                    "fe_hasta"=>$fechaHasta,
                    "fe_desde"=>$fechaDesde,
                    "nu_endoso"=>$busquedaInformacionContrato[0]['nu_endoso'],
                    "nu_certificado"=>$busquedaInformacionContrato[0]['nu_certificado'],
                    "nu_contrato"=>$busquedaInformacionContrato[0]['nu_contrato'],
                    "cd_producto"=>$busquedaInformacionContrato[0]['cd_producto']
                );
                $this->create($arrayRecibos);
                $arrayRecibos=array();
                $contador+=$mesesRecibos;
            }
            ///throw new \Exception($contador);
        } catch (Exception $th) {
            print_r($th->getMessage());
        }
    }

}
