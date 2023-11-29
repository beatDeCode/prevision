@include('celestial-template.header')
@include('celestial-template.navbar')
@include('celestial-template.sidebar')
<div class="main-panel">
    <div class="content-wrapper" style="font-size:14px;">
        @include('plantillas.tarjetaDinamicaApertura')
        
        <!--FASE 1 -->
        <div class="fase1">
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
                <div class="col-md-1 offset-md-11">
                    <button type="button" class="btn btn-sm" 
                    style="background-color: #7c90a7;color: white;" 
                    onclick="fnValidarProducto()">Asegurados</button>
                </div>
            </div>
        </div>
        <!-- CIERRE FASE 1 -->

        <!--FASE 2 -->
        <div class="fase2">
            @include('plantillas.cabeceraWizard',['barra'=>$barra2,'botonesWizard'=>$botonesWizard2])
            <br>
            <div class="container-fluid">
                <div class="badge" style="background-color: #7c90a7;color:white;text-align:left;">
                    Datos del asegurado
                </div>
                <hr class="hr-none">
                @include('plantillas.formularioCreate',[
                    'formulariosCreate'=>$formulariosCreate2,
                    'nombreFormulario'=>$nombreFormulario2,
                    'formulariosAClonar'=>$formulariosAClonar2,
                    'cantidadDeClonacion'=>$cantidadDeClonacion2])
                <hr class="hr-none">
                
            </div>
        </div>
        <!-- CIERRE FASE 2 -->
        

        @include('plantillas.formulariosOcultos',
                ['formulariosOcultos'=>$formulariosOcultos] 
            )
        <br>
        @include('plantillas.tarjetaDinamicaCierre')
    </div>
</div>
@include('celestial-template.footer')