<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\MonedaModel;

class Moneda extends Controller{
    public function fnIndice(){
        //Configuracion dinámica
        $menu=1;
        $submenu=2;
        $formularios=array();
        $titulo='Gestión de Catálago para Moneda';
        $columnas='12';
        $descripcion='Listado de Monedas';
        $inputBusqueda1=array('input'=>'text','columnas'=>'2','titulo'=>'Descripcion Moneda','nombre'=>'de_moneda');
        $formularios=array($inputBusqueda1);
        $modelo='moneda';
        $linkCreate='/prevision.catalogo.moneda.create';
        $formulariosOcultos=array(
            'nombre-tabla|tabla-moneda',
            'formulario-tabla|formulario-moneda',
            'query-tabla|buscarInformacionMonedas',
            'campos-tabla|Codigo Moneda,Detalle Moneda,Siglas,Estatus,Acciones',
            'indices-tabla|cd_moneda,de_moneda,de_siglas_moneda,st_moneda',
            'tipo-query|1',
            'nombre-div|div-moneda',
            'clave-principal|cd_moneda',
            'link-update|/prevision.catalogo.moneda.update',
            'link-delete|/prevision.catalogo.moneda.delete',
        );
        $funcionJsDeBusqueda='fnTablaDinamica()';
        $scripts=array('/datatables/datatables.js','/prevision/catalogo/moneda.js','/prevision/utiles/datatables.js');
        

        
        return view(
            'catalogo.moneda-index',
            compact('formularios','titulo','columnas','descripcion','menu','submenu','scripts','funcionJsDeBusqueda',
                'modelo','formulariosOcultos','linkCreate')

        );
    }
    public function fnUpdateIndice($clavePrincipal){
        $menu=1;
        $submenu=2;
        $formularios=array();
        $titulo='Actualización de Catálago para Moneda';
        $columnas='12';
        $descripcion='Listado de Monedas';
        $nombreFormulario='formulario-moneda';
        $linkVolver='/prevision.catalogo.moneda';
        $formulariosOcultos=array(
            'url-validacion|/prevision.catalogo.moneda.update.validar',
            'url-principal|/prevision.catalogo.moneda',
            'nombre-formulario|formulario-moneda',
        );
        $formulariosUpdate=array();
        $instanciaAuditoria=new Auditoria;
        try {
            $busquedaUpdate=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaUpdateMoneda',
                ['cd_moneda'=>$clavePrincipal],
                1
            );
            $busquedaParaEstatus=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaParaEstatus',
                array(),
                1
            );
            if(sizeof($busquedaUpdate)>0){
                $formulariosUpdate=array(
                    'cd_moneda|input|hidden|col-md-4|Código Moneda|'.$busquedaUpdate[0]['cd_moneda']=>array(),
                    'de_moneda|input|text|col-md-4|Detalle Moneda|'.$busquedaUpdate[0]['de_moneda']=>array(),
                    'de_siglas_moneda|input|text|col-md-4|Siglas Moneda|'.$busquedaUpdate[0]['de_siglas_moneda']=>array(),
                    'st_moneda|select|text|col-md-4|Estatus Moneda|'.$busquedaUpdate[0]['st_moneda']=>$busquedaParaEstatus ) ;

            }
            
        } catch (Throwable $th) {
            print_r($th);
        }
        $scripts=array(
        '/prevision/utiles/validacionFormulario.js',
        '/prevision/utiles/sweetAlertsPersonalizados.js');

        return view('catalogo.moneda-update',
            compact('formulariosUpdate','titulo','columnas','descripcion','menu','submenu','scripts','formulariosOcultos',
            'linkVolver','nombreFormulario'));
    }
    public function fnValidarUpdate(Request $request){
        $retorno=json_encode(array());
        try {
            $instanciaMoneda=new MonedaModel;
            $retorno=$instanciaMoneda->fnUpdate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $retorno;
    }
    public function fnCreateIndice(){
        try {
            $menu=1;
            $submenu=2;
            $formularios=array();
            $titulo='Registro de Catálago para Moneda';
            $columnas='12';
            $descripcion='Listado de Monedas';
            $nombreFormulario='formulario-moneda';
            $linkVolver='/prevision.catalogo.moneda';
            $formulariosOcultos=array(
                'url-validacion|/prevision.catalogo.moneda.create.validar',
                'url-principal|/prevision.catalogo.moneda',
                'nombre-formulario|formulario-moneda',
            );
            $scripts=array(
                '/prevision/utiles/validacionFormulario.js',
                '/prevision/utiles/sweetAlertsPersonalizados.js');
            $instanciaAuditoria=new Auditoria;
            $busquedaParaEstatus=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaParaEstatus',
                array(),
                1
            );
            $formulariosCreate=array(
                'de_moneda|input|text|col-md-4|Detalle Moneda'=>array(),
                'de_siglas_moneda|input|text|col-md-4|Siglas Moneda'=>array(),
                'st_moneda|select|text|col-md-4|Estatus Moneda'=>$busquedaParaEstatus ) ;

        } catch (Throwable $th) {
            print_r($th);
        }
        return view('catalogo.moneda-create',
            compact('formulariosCreate','titulo','columnas','descripcion','menu','submenu','scripts','formulariosOcultos',
            'linkVolver','nombreFormulario'));

    }
    public function fnValidarCreate(Request $request){
        $retorno=json_encode(array());
        try {
            $instanciaMoneda=new MonedaModel;
            $retorno=$instanciaMoneda->fnCreate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $retorno;
    }
}
