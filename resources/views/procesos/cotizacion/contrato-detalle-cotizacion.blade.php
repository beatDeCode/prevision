<div id="fase3" style="display:none;">
    <!-- Fase 1-->
    <!-- Declaracion Variables-->
    <?php 
        $botonesWizard3=array(
            '3|1. Producto|active|dribbble|typcn typcn-user-outline',
            '3|2. Asegurados|none|dribbble|typcn typcn-credit-card',
            '3|3. Emisión|none|linkedin|typcn typcn-image',
        );
        $formulariosCreate3=array() ;
        $cantidadDeClonacion3=0;
        $formulariosAClonar3=array();
        $nombreFormulario3='formulario-cotizacion';
        $barra3=array('99|success');
    ?>
    <!-- Cierre Declaracion Variables-->

    <!-- Cuerpo Fase I-->
    @include('plantillas.cabeceraWizard',['barra'=>$barra3,'botonesWizard'=>$botonesWizard3])
    <br>
    <div class="container-fluid">
		<div id="factura">

		</div>
        <hr class="hr-none">
        <center>
            <button type="button" class="btn btn-sm" 
                style="background-color: #7c90a7;color: white;margin-bottom:15px;" 
                onclick="fnDevolverFase(3)">Volver</button>
            <button type="button" class="btn btn-sm" 
            style="background-color: #7c90a7;color: white;margin-bottom:15px;" 
            onclick="fnMoverFase4('formulario-producto')">Siguiente</button>
        </center>
    </div>
    <!-- Cierre Cuerpo Fase I-->
</div>