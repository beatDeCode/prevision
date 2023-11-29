@include('celestial-template.header')
@include('celestial-template.navbar')
@include('celestial-template.sidebar')
<div class="main-panel">
    <div class="content-wrapper" style="font-size:14px;">
        @include('plantillas.tarjetaDinamicaApertura')
        @include('plantillas.cabeceraWizard')
        <br>
        <div class="container-fluid">
            <div class="badge" style="background-color: #7c90a7;color:white;text-align:left;">
                    Formulario de Datos Personales
            </div>
            <hr class="hr-none">
            @include('plantillas.formularioCreate')
            <hr class="hr-none">
        </div>
        @include('plantillas.formulariosOcultos',
                ['formulariosOcultos'=>$formulariosOcultos] 
            )
        <br>
        @include('plantillas.tarjetaDinamicaCierre')
    </div>
</div>
@include('celestial-template.footer')