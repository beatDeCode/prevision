@include('celestial-template.header')
@include('celestial-template.navbar')
@include('celestial-template.sidebar')
<div class="main-panel">
<div class="content-wrapper" style="font-size:14px;">
@include('plantillas.tarjetaDinamicaApertura')

    @include('procesos.cotizacion.contrato-producto')
    @include('procesos.cotizacion.contrato-adicionales')
    @include('procesos.cotizacion.contrato-detalle-cotizacion')
    @include('procesos.cotizacion.contrato-emision')
@include('plantillas.tarjetaDinamicaCierre')
</div>
</div>
@include('celestial-template.footer')