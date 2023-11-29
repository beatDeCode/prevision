<?php

namespace App\Http\Controllers\Negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\EmpresasModel;
use App\Models\PersonaDomicilioBancarioModel;


class Empresas extends Controller{
    public function fnCreateIndice(){
        $menu=3;
        $submenu=4;
        //<!-- desglose columas|nombre|active/none|linkedin/dribbble|icono-->
        $botonesWizard=array(
            '3|1. Datos Personales|active|linkedin|typcn typcn-user-outline',
            '3|2. Cuentas Bancarias|none|dribbble|typcn typcn-credit-card',
            '3|3. Documentos Digitales|none|dribbble|typcn typcn-image',
        );
        $barra=array('66|success');
        $tarjeta=array('empresa-persona|Registro de Asociados');
        $formulariosOcultos=array(
            'url-validacion|/prevision.negocio.empresas.create.validar',
            'url-principal|/prevision.negocio.empresas.domicilio.create',
            'nombre-formulario|formulario-empresas',
            'transicion|1'
        );
        $scripts=array(
            '/prevision/utiles/validacionFormulario.js',
            '/prevision/utiles/sweetAlertsPersonalizados.js',
            '/prevision/utiles/comboDependienteEstados.js');

        $nombreFormulario='formulario-empresas';
        $instanciaAuditoria=new Auditoria;
            $busquedaParaEstatus=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaParaEstatus',
                array(),
                1
            );
            $busquedaTipoDocumentos=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaTipoDocumento',
                array(),
                1
            );

            $busquedaAreasTelefonicas=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaAreasTelefono',
                array(),
                1
            );
            
            $busquedaEstados=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaEstados',
                array(),
                1
            );
            $formulariosAClonar=array();
            $cantidadDeClonacion=0;
            $formulariosCreate=array(
                'nm_completo|input|text|col-md-6|Asociado a Previsión'=>array(),
                'nm_persona1|input|hidden|col-md-3|Primer Apellido|Empresa'=>array(),
                'ap_persona1|input|hidden|col-md-3|Primer Apellido|Asociada'=>array(),
                'cd_sexo|input|hidden|col-md-3|Primer Apellido|O'=>array(),
                'cd_profesion|input|hidden|col-md-3|Primer Apellido|1'=>array(),
                'tp_documento|select|text|col-md-3|Tipo'=>$busquedaTipoDocumentos,
                'nu_documento|input|text|col-md-3|Documento'=>array(),
                'cd_estado|select|text|col-md-4|Estado'=>$busquedaEstados,
                'cd_municipio|select|text|col-md-4|Municipio'=>array(),
                'cd_parroquia|select|text|col-md-4|Parroquia'=>array(),
                'de_direccion|input|text|col-md-12|Dirección Completa '=>array(),
                'de_correo|input|text|col-md-6|Correo'=>array(),
                'nu_area|select|text|col-md-3|Area Teléfono'=>$busquedaAreasTelefonicas,
                'nu_telefono|input|text|col-md-3|Teléfono'=>array(),
                'in_asoproinfu|checkbox|number|col-md-3|¿Está asociado a ASOPROINFU?'=>array(),
                'cd_asoproinfu|input|number|col-md-3|Código ASOPROINFU'=>array(),) ;

        return view('negocio.empresas-create-index',compact('menu','submenu','scripts','botonesWizard','barra','tarjeta','formulariosCreate',
                'nombreFormulario','formulariosOcultos','formulariosAClonar','cantidadDeClonacion'));
    }

    public function fnIndice(){
        //Configuracion dinámica
        $menu=3;
        $submenu=4;
        $formularios=array();
        $titulo='Gestión de Asociados';
        $columnas='12';
        $descripcion='Listado de Asociados';
        $inputBusqueda1=array('input'=>'text','columnas'=>'2','titulo'=>'Documento Asociado','nombre'=>'nu_documento');
        $formularios=array($inputBusqueda1);
        $modelo='empresas';
        $linkCreate='/prevision.negocio.empresas.create';
        $formulariosOcultos=array(
            'nombre-tabla|tabla-empresas',
            'formulario-tabla|formulario-empresas',
            'query-tabla|busquedaInformacionEmpresas',
            'campos-tabla|Codigo Asociado,Asociado,Documento,Registro,¿Está Asociado?,Código Asoproinfu,Estatus,Acciones',
            'indices-tabla|cd_empresa,nm_completo,nu_documento,fe_registro,in_asoproinfu,cd_asoproinfu,st_empresa',
            'tipo-query|2',
            'nombre-div|div-empresas',
            'clave-principal|cd_empresa',
            'link-update|/prevision.negocio.empresas.update',
            'link-delete|/prevision.negocio.empresas.delete',
        );
        $funcionJsDeBusqueda='fnTablaDinamica()';
        $scripts=array('/datatables/datatables.js','/prevision/utiles/datatables.js');
        
        return view(
            'negocio.empresas-index',
            compact('formularios','titulo','columnas','descripcion','menu','submenu','scripts','funcionJsDeBusqueda',
                'modelo','formulariosOcultos','linkCreate')

        );
    }

    public function fnUpdateIndice($clavePrincipal){
        $menu=3;
        $submenu=4;
        $formularios=array();
        $titulo='Actualización de Asociados.';
        $descripcion='Listado de Asociados';
        $columnas='12';
        $nombreFormulario='formulario-empresas';
        $linkVolver='/prevision.negocio.empresas';
        $formulariosOcultos=array(
            'url-validacion|/prevision.negocio.empresas.update.validar',
            'url-principal|/prevision.negocio.empresas',
            'nombre-formulario|formulario-empresas',
        );
        $formulariosUpdate=array();
        $instanciaAuditoria=new Auditoria;
        try {
            $busquedaUpdate=$instanciaAuditoria->fnBusquedaParametrizada('busquedaUpdateEmpresas',['cd_empresa'=>$clavePrincipal],2);
            $busquedaParaEstatus=$instanciaAuditoria->fnBusquedaParametrizada('busquedaParaEstatus',array(),1);
            $busquedaAreasTelefono=$instanciaAuditoria->fnBusquedaParametrizada('busquedaAreasTelefono',array(),1);
            $busquedaParroquiasGeneral=$instanciaAuditoria->fnBusquedaParametrizada('busquedaParroquiasGeneral',array(),1);
            $busquedaEstados=$instanciaAuditoria->fnBusquedaParametrizada('busquedaEstados',array(),1);
            $busquedaMunicipiosGeneral=$instanciaAuditoria->fnBusquedaParametrizada('busquedaMunicipiosGeneral',array(),1);
            $busquedaTipoDocumento=$instanciaAuditoria->fnBusquedaParametrizada('busquedaTipoDocumento',array(),1);

            if(sizeof($busquedaUpdate)>0){
                $formulariosUpdate=array(
                'cd_persona|input|hidden|col-md-3|Persona|'.$busquedaUpdate[0]['cd_persona'] =>array(),
                'nm_completo|input|text|col-md-6|Asociado a Prevision|'.$busquedaUpdate[0]['nm_completo']=>array(),
                'tp_documento|select|text|col-md-3|Tipo Documento|'.$busquedaUpdate[0]['tp_documento']=>$busquedaTipoDocumento,
                'nu_documento|input|text|col-md-3|Número Documento|'.$busquedaUpdate[0]['nu_documento']=>array(),
                'de_correo|input|text|col-md-6|Correo|'.$busquedaUpdate[0]['de_correo']=>array(),
                'nu_area|select|text|col-md-3|Área Telefono|'.$busquedaUpdate[0]['nu_area']=>$busquedaAreasTelefono,
                'nu_telefono|input|text|col-md-3|Número de Telefono|'.$busquedaUpdate[0]['nu_telefono']=>array(),
                'cd_estado|select|text|col-md-2|Correo|'.$busquedaUpdate[0]['cd_estado']=>$busquedaEstados,
                'cd_municipio|select|text|col-md-2|Correo|'.$busquedaUpdate[0]['cd_municipio']=>$busquedaMunicipiosGeneral,
                'cd_parroquia|select|text|col-md-2|Correo|'.$busquedaUpdate[0]['cd_parroquia']=>$busquedaParroquiasGeneral,
                'de_direccion|input|text|col-md-6|Correo|'.$busquedaUpdate[0]['de_direccion']=>array(),
                'cd_empresa|input|hidden|col-md-2|Asociado a Previsión|'.$busquedaUpdate[0]['cd_empresa']=>array(),
                'in_asoproinfu|input|text|col-md-2|¿Está asociado a ASOPROINFU?|'.$busquedaUpdate[0]['in_asoproinfu']=>array(),
                'cd_asoproinfu|input|text|col-md-2|Código ASOPROINFU|'.$busquedaUpdate[0]['cd_asoproinfu']=>array(),
                ) ;
            }
            
        } catch (Throwable $th) {
            print_r($th);
        }
        $scripts=array(
        '/prevision/utiles/validacionFormulario.js',
        '/prevision/utiles/sweetAlertsPersonalizados.js','/prevision/utiles/comboDependienteEstados.js');

        return view('negocio.empresas-update',
            compact('formulariosUpdate','titulo','columnas','descripcion','menu','submenu','scripts','formulariosOcultos',
            'linkVolver','nombreFormulario'));
    }
    public function fnValidarUpdate(Request $request){
        $retorno=json_encode(array());
        try {
            $instanciaEmpresas=new EmpresasModel;
            $retorno=$instanciaEmpresas->fnUpdate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $retorno;
    }
    public function fnValidarCreate(Request $request){
        $retorno=json_encode(array());
        try {
            $instanciaMoneda=new EmpresasModel;
            $retorno=$instanciaMoneda->fnCreate($request);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $retorno;
    }

    public function fnCreateDomicilioIndice($codigoPersona){
        try {
            $menu=3;
            $submenu=4;
            //<!-- desglose columas|nombre|active/none|linkedin/dribbble|icono-->
            $botonesWizard=array(
                '3|1. Datos Personales|active|dribbble|typcn typcn-user-outline',
                '3|2. Cuentas Bancarias|none|linkedin|typcn typcn-credit-card',
                '3|3. Documentos Digitales|none|dribbble|typcn typcn-image',
            );
            $nombreFormulario="formulario-empresas-domicilio";
            $barra=array('66|success');
            $tarjeta=array('empresa-persona|Registro de Asociados');
            $formulariosOcultos=array(
                'url-validacion|/prevision.negocio.empresas.domicilio.create.validar',
                'nombre-formulario|formulario-empresas-domicilio',
                'valores-formulario|tp_cuenta,nu_cuenta,cd_banco,st_cuenta'
            );
            $scripts=array(
                '/prevision/utiles/validacionFormulario.js',
                '/prevision/utiles/sweetAlertsPersonalizados.js',
                '/prevision/utiles/clonarInputs.js');

            $instanciaAuditoria=new Auditoria;
            $busquedaParaEstatus=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaParaEstatus',
                array(),
                1
            );
            $busquedaBancos=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaBancos',
                array(),
                1
            );
            $busquedaTipoCuenta=$instanciaAuditoria->fnBusquedaParametrizada(
                'busquedaTipoCuenta',
                array(),
                1
            );

            $formulariosCreate=array(
                'cd_persona|input|hidden|col-md-6|Persona|'.$codigoPersona=>array(),
                'tp_cuenta|select|text|col-md-2|Tipo Cuenta|'=>$busquedaTipoCuenta,
                'cd_banco|select|text|col-md-4|Banco|'=>$busquedaBancos,
                'nu_cuenta|input|text|col-md-3|Número Cuenta|'=>array(),
                'st_cuenta|select|text|col-md-2|Estatus Cuenta|'=>$busquedaParaEstatus,
                ) ;
            $formulariosAClonar=array(
                'tp_cuenta|select|text|col-md-2|Tipo Cuenta|'=>$busquedaTipoCuenta,
                'cd_banco|select|text|col-md-4|Banco|'=>$busquedaBancos,
                'nu_cuenta|input|text|col-md-3|Número Cuenta|'=>array(),
                'st_cuenta|select|text|col-md-2|Estatus Cuenta|'=>$busquedaParaEstatus,
                'boton|button|text|col-md-1|-|'=>array(),
            );
            $cantidadDeClonacion=4;

        } catch (Throwable $th) {
            print_r($th);
        }
        return view('negocio.empresas-domicilio-create',
        compact('menu','submenu','scripts','botonesWizard','barra','tarjeta','formulariosCreate',
        'nombreFormulario','formulariosOcultos','formulariosAClonar','cantidadDeClonacion'));

    }
    public function fnValidarDomicilioCreate(Request $request){
        $retorno=json_encode(array());
        try {
            $contadorClonacion=$request->post('contador-clonacion');
            $codigoPersona=$request->post('cd_persona');
            $instanciaMoneda=new PersonaDomicilioBancarioModel;
            $retorno=$instanciaMoneda->fnCreate($request,$contadorClonacion,$codigoPersona);
        } catch (Throwable $th) {
            print_r($th);
        }
        return $retorno;
    }
}
