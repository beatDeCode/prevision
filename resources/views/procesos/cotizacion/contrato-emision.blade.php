<div id="fase4" style="display:none;">
    <!-- Fase 1-->
    <!-- Declaracion Variables-->
    <?php 
        $botonesWizard1=array(
            '3|1. Producto|none|linkedin|typcn typcn-user-outline',
            '3|2. Asegurados|none|dribbble|typcn typcn-credit-card',
            '3|3. Emisión|active|dribbble|typcn typcn-image',
        );

        $formulariosCreate1=array(
            'titulo1|hr|text|col-md-6|Datos Pagos'=>array(),
            'cd_intermediario|select|text|col-md-4|Intermediario'=>$busquedaIntermediarios,
            'cd_forma_pago|select|text|col-md-4|Forma de Pago'=>$busquedaFormasPago,

            'titulo2|hr|text|col-md-6|Domicilio Bancario'=>array(),
            'tp_documento_domicilio|select|text|col-md-3|Tipo Documento'=>$busquedaTipoDocumento,
            'nu_documento_domicilio|input|text|col-md-3|Número Documento'=>array(),
            'tp_cuenta|select|text|col-md-3|Tipo Cuenta'=>$busquedaTipoCuenta,
            'nu_cuenta|input|text|col-md-3|Numero Cuenta'=>array(),

            ) ;
        $cantidadDeClonacion1=0;
        $formulariosAClonar1=array();
        $nombreFormulario1='formulario-finanzas';
        $barra1=array('99|success');
    ?>
    <!-- Cierre Declaracion Variables-->

    <!-- Cuerpo Fase I-->
    @include('plantillas.cabeceraWizard',['barra'=>$barra1,'botonesWizard'=>$botonesWizard1])
    <br>
    <div class="container-fluid">
        <div class="badge" style="background-color: #7c90a7;color:white;text-align:left;">
            Datos Financieros   
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
                onclick="fnDevolverFase(4)">Volver</button>
                <button type="button" class="btn btn-sm" 
                style="background-color: #7c90a7;color: white;margin-bottom:15px;" 
                onclick="fnEmitir('formulario-finanzas')">Emitir</button>
                
            </center>
            
        
    </div>
    <!-- Cierre Cuerpo Fase I-->
</div>