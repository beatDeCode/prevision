<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use Session;

class Autenticacion extends Controller{

    public function fnValidarCredenciales(Request $request){
        $retorno=0;
        $objetoRespuesta=array();
        try {
            $usuario=strtoupper(
                trim($request->post('cd_usuario'),' ')
            );
            $clave=hash('sha256',
                trim($request->post('de_clave'),' ')
            );
            $instanciaAuditoria=new Auditoria;
            $respuestaValidacion=$instanciaAuditoria->fnBusquedaParametrizada(
                'validarCredencialesUsuario',
                array('cd_usuario'=>$usuario, 'de_clave'=>$clave),0
            );

            if(sizeof($respuestaValidacion)>0){
                Session::put('user', 
                    [   'cd_usuario'=>$respuestaValidacion[0]['cd_usuario'],
                        'cd_rol'=>$respuestaValidacion[0]['cd_rol'],
                        'nm_completo'=>$respuestaValidacion[0]['nm_completo'],
                        'de_rol'=>$respuestaValidacion[0]['de_rol'],
                    ]);
                $retorno=$respuestaValidacion[0]['cuenta'];
            } 
            $objetoRespuesta=array(
                'httpResponse'=>200,
                'message'=>array(
                    'validate'=>$retorno,
                    'content'=>'El usuario ha sido validado con éxito.',
                    'object'=>array(),
                ),
                'error'=>0,
            );

        } catch (Exception $th) {
            $objetoRespuesta=array(
                'httpResponse'=>400,
                'message'=>array(
                    'validate'=>0,
                    'content'=>$th->getMessage(),
                    'object'=>array(),
                ),
                'error'=>1
            );
        }
        return json_encode($objetoRespuesta);
        
    }
    public static 
    function fnDesplegarSideBarPorUsuario(){
        $vRetorno='';
        $cdUsuario=Session::get('user')['cd_usuario'];
        $sidebarParaUsuario='';
        try {
            /*
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="typcn typcn-briefcase menu-icon"></i>
                    <span class="menu-title">UI Elements</span>
                    <i class="typcn typcn-chevron-right menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="/pages/ui-features/buttons.html">Buttons</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/pages/ui-features/dropdowns.html">Dropdowns</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/pages/ui-features/typography.html">Typography</a></li>
                    </ul>
                    </div>
                </li>*/
            
            $liApertura='<li class="nav-item" id="ui-prin$idMenu$">';
            $liCierre='</li>';
            $menuPadre='
                <a class="nav-link" data-toggle="collapse" href="#ui-prev$idMenu$" aria-expanded="false" aria-controls="ui-prev$idMenu$" id="ui-prev$idMenu$">
                    <i class="typcn $iconoMenu$"></i>
                    <span class="menu-title">$nombreMenu$</span>
                    <i class="typcn typcn-chevron-right menu-arrow"></i>
                </a>';
            $aperturaMenuHijo='
                <div class="collapse" id="ui-prev$idMenu$">
                <ul class="nav flex-column sub-menu">
            ';
            $menuHijo='
                <li class="nav-item"><a id="ui-menu$idMenu$" class="nav-link" href="$enlaceMenu$">$nombreMenuHijo$</a></li>
            ';
            $cierreMenuHijo='
                </ul>
                </div>
            ';
            $parametrosBusqueda=array(
                'cd_usuario'=>$cdUsuario
            );
            $instanciaAuditoria=new Auditoria;
            $BusquedaMenusPadrePorUsuario=$instanciaAuditoria
                ->fnBusquedaParametrizada(
                    'menusPadrePorUsuario',
                    $parametrosBusqueda,0
                    
            );
            foreach($BusquedaMenusPadrePorUsuario as $menuPadrePorUsuario){
                $sidebarParaUsuario.=str_replace('$idMenu$',
                $menuPadrePorUsuario['cd_menu'],
                $liApertura);

                $reemplazoID=str_replace('$idMenu$',
                    $menuPadrePorUsuario['cd_menu'],
                    $menuPadre);

                $reemplazoIcono=str_replace('$iconoMenu$',
                    $menuPadrePorUsuario['de_icono_menu'],
                    $reemplazoID);

                $reemplazoNombre=str_replace('$nombreMenu$',
                    $menuPadrePorUsuario['de_menu'],
                    $reemplazoIcono);
                $sidebarParaUsuario.=$reemplazoNombre;

                $reemplazoAperturaMenuHijo=str_replace('$idMenu$',
                    $menuPadrePorUsuario['cd_menu'],
                    $aperturaMenuHijo);
                $sidebarParaUsuario.=$reemplazoAperturaMenuHijo;
                $parametrosBusqueda=array(
                    'cd_usuario'=>$cdUsuario,
                    'cd_menu_padre'=> $menuPadrePorUsuario['cd_menu']
                );

                $busquedaMenusHijos=$instanciaAuditoria
                    ->fnBusquedaParametrizada(
                        'menusPorUsuario',
                        $parametrosBusqueda,0
                        
                    );

                foreach($busquedaMenusHijos as $menuHijoPorUsuario){
                    $reemplazoNombreMenuHijo=str_replace('$nombreMenuHijo$',
                        $menuHijoPorUsuario['de_menu'],
                        $menuHijo);
                    $reemplazoEnlaceMenuHijo=str_replace('$enlaceMenu$',
                        $menuHijoPorUsuario['de_enlace_menu'],
                        $reemplazoNombreMenuHijo);
                    $reemplazoCdMenuHijo=str_replace('$idMenu$',
                        $menuHijoPorUsuario['cd_menu'],
                        $reemplazoEnlaceMenuHijo);

                    $sidebarParaUsuario.=$reemplazoCdMenuHijo;
                }
                $sidebarParaUsuario.=$cierreMenuHijo;
                $sidebarParaUsuario.=$liCierre;
                
            }
        } catch (Throwable $th) {
            print_r($th);
        }
        return($sidebarParaUsuario);
    }
    function fnVistaPrincipal(){
        $menu=1;
        $submenu=3;
        $scripts=array();
        return view('welcome',compact('menu','submenu','scripts'));
    }
    function fnIndice(){
        return view('autenticacion.login');
    }
    
}
