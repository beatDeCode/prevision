<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\PersonasModel;
use App\Models\ContratoModel;
use App\Models\ContratoCertificadoModel;
use App\Models\ContratoCertificadoEndosoModel;

class Contrato extends Controller{
    public function fnCotizacion(){
        $menu=5;
        $submenu=6;
        //<!-- desglose columas|nombre|active/none|linkedin/dribbble|icono-->
        $scripts=array(
            '/prevision/utiles/validacionFormulario.js',
            '/prevision/utiles/sweetAlertsPersonalizados.js',
            '/prevision/utiles/comboDependienteProductos.js',
            '/prevision/utiles/comboDependienteEstados.js',
            '/prevision/procesos/cotizacion.js',
            '/prevision/utiles/clonarInputs.js');
        
        $tarjeta=array('cotizacion-producto|Cotizacion');
        
        $instanciaAuditoria=new Auditoria;
        $busquedaProductos=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaProductos',
                array(),
                1
        );
        $busquedaAreasTelefonicas=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaAreasTelefono',
            array(),
            1
        );
        $busquedaGruposFamiliares=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaGruposFamiliares',
            array(),
            1
        );
        $busquedaTipoDocumento=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaTipoDocumento',
                array(),
                1
        );
        $busquedaParentescos=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaParentescos',
            array(),
            1
        );
        $busquedaSexos=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaSexos',
            array(),
            1
        );
        $busquedaEstados=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaEstados',
            array(),
            1
        );
        $busquedaPlanesPago=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaPlanesPago',
            array(),
            1
        );
        $busquedaTipoCuenta=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaTipoCuenta',
            array(),
            1
        );
        $busquedaIntermediarios=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaIntermediarios',
            array(),
            1
        );

        $busquedaFormasPago=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaFormasPago',
            array(),
            1
        );

        $busquedaBancos=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaBancos',
            array(),
            1
        );
        $busquedaTipoCalculoPrima=$instanciaAuditoria->fnBusquedaParametrizada(
            'busquedaTipoCalculoPrima',
            array(),
            1
        );
        
        return view('procesos.cotizacion.contrato-principal',compact('menu','submenu','scripts','tarjeta',
        'busquedaProductos','busquedaGruposFamiliares','busquedaTipoDocumento','busquedaSexos','busquedaParentescos',
        'busquedaEstados','busquedaAreasTelefonicas','busquedaPlanesPago','busquedaTipoCuenta','busquedaIntermediarios',
        'busquedaFormasPago','busquedaBancos','busquedaTipoCalculoPrima'
        ));
    }
    function fnGenerarCotizacion(Request $request){
        $CotizacionTitular='procesoCotizacion';
        try {
            $tipoPago=$request->post('cd_tipo_calculo');
            if($tipoPago==2){
                $CotizacionTitular='procesoCotizacionPorPrima';
            }
            /**Declaracion de indices de adicionales */
            $retornoAsegurados=array();
            $arrayInputsAdicionales=array(
                'tp_documento_asegurado',
                'nu_documento_asegurado',
                'cd_parentesco_asegurado',
                'nm_persona1_asegurado'
            );
            /**Llenar valores del titular */
            $arrayTitular=array(
                'tp_documento'=>$request->post('tp_documento'),
                'nu_documento'=>$request->post('nu_documento'),
                'nm_persona1'=>$request->post('nm_persona1'),
                'ap_persona1'=>$request->post('ap_persona1'),
                'cd_producto'=>$request->post('cd_producto'),
                'cd_grupo_familiar'=>$request->post('cd_grupo_familiar'),
                'mt_suma_asegurada'=>$request->post('mt_suma_asegurada'),
                'cd_plan_pago'=>$request->post('cd_plan_pago'),
                'cd_parentesco'=>1,
                'mt_prima'=>$request->post('mt_prima')
            );
            /**Procesamos la cotizacion Para el Titular */
            $instanciaAuditoria=new Auditoria;
            $cotizacionTitular=$instanciaAuditoria->fnBusquedaParametrizada(
                $CotizacionTitular,
                $arrayTitular,
                2
            );

            /**Agregamos al arreglo global de cotizacion al titular */
            $retornoAsegurados[0]=$cotizacionTitular[0];
            $arrayAdicionales=array();
            $cantidadClonacion=$request->post('ca_clonacion');

            /**Recorremos el array de asegurados para reemplazar la palabra _asegurado  */
            for($b=0;$b< sizeof($arrayInputsAdicionales);$b++){
                $arrayAdicionales[str_replace('_asegurado','',$arrayInputsAdicionales[$b])]=$request->post($arrayInputsAdicionales[$b]);
            }
            $arrayAdicionales['cd_producto']=$request->post('cd_producto');
            $arrayAdicionales['cd_grupo_familiar']=$request->post('cd_grupo_familiar');
            $arrayAdicionales['mt_suma_asegurada']=$request->post('mt_suma_asegurada');
            $arrayAdicionales['cd_plan_pago']=$request->post('cd_plan_pago');
            $arrayAdicionales['mt_prima']=0;

            /**Procesamos la cotizacion Para el primer asegurado */
            $cotizacionPrimerAsegurado=$instanciaAuditoria->fnBusquedaParametrizada(
                $CotizacionTitular,
                $arrayAdicionales,
                2
            );
             /**Agregamos al arreglo global de cotizacion del primer asegurado */
            $retornoAsegurados[1]=$cotizacionPrimerAsegurado[0];
            $arrayAdicionalesOtros=null;
            $contadorRetornos=1;
            /**Recorremos los asegurados adicionales restantes*/
            if($cantidadClonacion>0){
                for($a=0;$a<$cantidadClonacion;$a++){
                    $contadorRetornos+=1;
                    //print_r($cantidadClonacion);
                    for($b=0;$b<sizeof($arrayInputsAdicionales);$b++){
                        //print_r($arrayInputsAdicionales[$b].''.$a);
                        $arrayAdicionalesOtros[str_replace('_asegurado','',$arrayInputsAdicionales[$b])]=$request->post($arrayInputsAdicionales[$b].''.$a);
                    }
                    $arrayAdicionalesOtros['cd_producto']=$request->post('cd_producto');
                    $arrayAdicionalesOtros['cd_grupo_familiar']=$request->post('cd_grupo_familiar');
                    $arrayAdicionalesOtros['mt_suma_asegurada']=$request->post('mt_suma_asegurada');
                    $arrayAdicionalesOtros['cd_plan_pago']=$request->post('cd_plan_pago');
                    $arrayAdicionalesOtros['ap_persona1']='';
                    $arrayAdicionales['mt_prima']=0;
                    //print_r($arrayAdicionales);
                    /**Procesamos la cotizacion para el asegurado restante*/
                    $cotizacionOtrosAsegurado=$instanciaAuditoria->fnBusquedaParametrizada(
                        $CotizacionTitular,
                        $arrayAdicionalesOtros,
                        2
                    );
                    /**Agregamos al arreglo global de cotizacion para el asegurado restante*/
                    $retornoAsegurados[$contadorRetornos]=$cotizacionOtrosAsegurado[0];
                    $arrayAdicionales=null;

                }
            }
            $retorno=array(
                'httpResponse'=>200,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$retornoAsegurados,
                    'object'=>array(),
                ),
                'error'=>1
            );
            
        } catch (Exception $th) {
            $retorno=array(
                'httpResponse'=>400,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$th,
                    'object'=>array(),
                ),
                'error'=>1
            );
        }
        return json_encode($retorno);
    }
    function fnValidarAsegurados(Request $request){
        $retorno=array();
        $contadorGlobal=0;
        try {
            $retornoAsegurados=array();
            $contadorClonacion=$request->post('ca_clonacion');
            $instanciaAuditoria=new Auditoria;
            $documentoTitular=$request->post('nu_documento');
            $producto=$request->post('cd_producto');
            $arrayTitular=array('cd_input'=>'nu_documento','nu_documento'=>$documentoTitular,'cd_producto'=>$producto);
            $busquedaDocumentoTitular=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaDocumentoContrato',
                $arrayTitular,
                2
            );
            if(sizeof( $busquedaDocumentoTitular) >0){
                $retornoAsegurados[$contadorGlobal]=$busquedaDocumentoTitular[0];
                $contadorGlobal+=1;
            }
            
            $documentoAsegurado=$request->post('nu_documento_asegurado');
            $arrayAsegurado=array('cd_input'=>'nu_documento_asegurado','nu_documento'=>$documentoAsegurado,'cd_producto'=>$producto);
            $busquedaDocumentoAsegurado=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaDocumentoContrato',
                $arrayAsegurado,
                2
            );
            if(sizeof( $busquedaDocumentoAsegurado) >0){
                $retornoAsegurados[$contadorGlobal]=$busquedaDocumentoAsegurado[0];
                $contadorGlobal+=1;
            }
            
            if($contadorClonacion>0){
                
                for($a=0;$a<$contadorClonacion;$a++){
                    $contadorGlobal+=1;
                    $busquedaDocumentoAseguradoExtra=$request->post('nu_documento_asegurado'.$a);
                    $arrayAseguradoExtra=array('cd_input'=>'nu_documento_asegurado'.$a,'nu_documento'=>$busquedaDocumentoAseguradoExtra,'cd_producto'=>$producto);
                    $documentoAseguradoExtra=$instanciaAuditoria->fnBusquedaParametrizada(
                        'busquedaDocumentoContrato',
                        $arrayAseguradoExtra,
                        2
                    );
                    $retornoAsegurados[$contadorGlobal]=$documentoAseguradoExtra[0];
                }
            } 
            $validacion=0;
            if(sizeof($retornoAsegurados)>0){
                $validacion=1;
            }
            $retorno=array(
                'httpResponse'=>200,
                'message'=>array(
                    'validate'=>$validacion,
                    'content'=>$retornoAsegurados,
                    'object'=>array(),
                ),
                'error'=>1
            ); 
        } catch (Exception $th) {
            $retorno=array(
                'httpResponse'=>400,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$th,
                    'object'=>array(),
                ),
                'error'=>1
            );
        }
        return json_encode($retorno);
    }

    function fnEmision(Request $request){
        try {
            $instanciaPersonas=new PersonasModel;
            $secuenciaPersona=$instanciaPersonas->fnCreateTitular($request);

            $instanciaContrato=new ContratoModel;
            $secuenciaContrato=$instanciaContrato->fnCreate($request,$secuenciaPersona);

            $instanciaContratoCertificado=new ContratoCertificadoModel;
            $instanciaContratoCertificado->fnCreate($request,$secuenciaPersona,$secuenciaContrato);

            $instanciaContratoCertificadoEndoso=new ContratoCertificadoEndosoModel;
            $instanciaContratoCertificadoEndoso->fnCreate($request,$secuenciaContrato,'');

            /*$arrayAsegurados=array(
                'nm_persona1_asegurado'=>$request->post('nm_persona1_asegurado'),
                'ap_persona1_asegurado'=>$request->post('ap_persona1_asegurado'),
                'tp_documento_asegurado'=>$request->post('tp_documento_asegurado'),
                'nu_documento_asegurado'=>$request->post('nu_documento_asegurado'),
                'fe_nacimiento_asegurado'=>$request->post('fe_nacimiento_asegurado'),
                'cd_sexo_asegurado'=>$request->post('cd_sexo_asegurado'),
                'cd_parentesco_asegurado'=>$request->post('cd_parentesco_asegurado'),
            );
            $arrayAseguradosExtra=array();
            $contadorClonacion=$request->post('ca_clonacion');
            if($contadorClonacion>0){
                for($a=0;$a<$contadorClonacion;$a++){
                    $arrayAseguradosExtra['nm_persona1_asegurado'.$a]=$request->post('nm_persona1_asegurado'.$a);
                    $arrayAseguradosExtra['ap_persona1_asegurado'.$a]=$request->post('ap_persona1_asegurado'.$a);
                    $arrayAseguradosExtra['tp_documento_asegurado'.$a]=$request->post('tp_documento_asegurado'.$a);
                    $arrayAseguradosExtra['nu_documento_asegurado'.$a]=$request->post('nu_documento_asegurado'.$a);
                    $arrayAseguradosExtra['fe_nacimiento_asegurado'.$a]=$request->post('fe_nacimiento_asegurado'.$a);
                    $arrayAseguradosExtra['cd_sexo_asegurado'.$a]=$request->post('cd_sexo_asegurado'.$a);
                    $arrayAseguradosExtra['cd_parentesco_asegurado'.$a]=$request->post('cd_parentesco_asegurado'.$a);
                }
            }*/
            
        } catch (Exception $th) {
            print_r($th);
        }
    }


    
}

