<div id="fase1">
    <!-- Fase 1-->
    <!-- Declaracion Variables-->
    <?php 
        $botonesWizard1=array(
            '3|1. Producto|active|linkedin|typcn typcn-user-outline',
            '3|2. Asegurados|none|dribbble|typcn typcn-credit-card',
            '3|3. Emisión|none|dribbble|typcn typcn-image',
        );
        $formulariosCreate1=array(
            'cd_producto|select|text|col-md-4|Producto'=>$busquedaProductos,
            'cd_cobertura|select|text|col-md-4|Cobertura|Empresa'=>array(),
            'mt_suma_asegurada|select|text|col-md-4|Monto a Riesgo'=>array(),
            'cd_grupo_familiar|select|text|col-md-4|Grupo Familiar'=>$busquedaGruposFamiliares,
            'cd_plan_pago|select|text|col-md-4|Plan de Pago'=>$busquedaPlanesPago,
            'cd_tipo_calculo|select|text|col-md-4|Tipo de Cáculo'=>$busquedaTipoCalculoPrima,
            'div_mt_prima|div|text|col-md-4|Pr'=> array(),
            ) ;
        $cantidadDeClonacion1=0;
        $formulariosAClonar1=array();
        $nombreFormulario1='formulario-producto';
        $barra1=array('33|success');
    ?>
    <!-- Cierre Declaracion Variables-->

    <!-- Cuerpo Fase I-->
    @include('plantillas.cabeceraWizard',['barra'=>$barra1,'botonesWizard'=>$botonesWizard1])
    <br>
    <div class="container-fluid">
        <div class="badge" style="background-color: #7c90a7;color:white;text-align:left;">
            Datos del Producto
        </div>
        <hr class="hr-none">
        @include('plantillas.formularioCreate',[
            'formulariosCreate'=>$formulariosCreate1,
            'nombreFormulario'=>$nombreFormulario1,
            'formulariosAClonar'=>$formulariosAClonar1,
            'cantidadDeClonacion'=>$cantidadDeClonacion1 ])
        <hr class="hr-none">
            <center>
                <button type="button" class="btn btn-sm" 
                style="background-color: #7c90a7;color: white;margin-bottom:15px;" 
                onclick="fnMoverFase2('formulario-producto')">Siguiente</button>
                
            </center>
            <!--
            <center>
                <button type="button" class="btn btn-sm" 
                style="background-color: #7c90a7;color: white;margin-bottom:15px;" 
                onclick="fnGenerarPdf()">pdf</button>
                
            </center>
            -->
            
        
    </div>
    <!-- Cierre Cuerpo Fase I-->
</div>