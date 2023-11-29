@include('celestial-template.header')
@include('celestial-template.navbar')
@include('celestial-template.sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        @include('plantillas.tarjetaDinamica',
            ['columnas'=>$columnas,
             'titulo'=>$titulo,
             'descripcion'=>$descripcion])

            @csrf()
            @include('plantillas.formulariosOcultos',
                ['formulariosOcultos'=>$formulariosOcultos] 
            )
            @include('plantillas.formularioCreate',
                ['formulariosCreate'=>$formulariosCreate] 
            )
            <div class="col-md-10 offset-md-1">
             </div>

        @include('plantillas.tarjetaDinamicaCierre')

    </div>
</div>
@include('celestial-template.footer')