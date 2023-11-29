@include('celestial-template.header')
@include('celestial-template.navbar')
@include('celestial-template.sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        @include('plantillas.tarjetaDinamica',
            ['columnas'=>$columnas,
             'titulo'=>$titulo,
             'descripcion'=>$descripcion])
             <div class="row">
                <div class="col-md-12 offset-md-8">
                @include('plantillas.formularioBusqueda',
                    ['formularios'=>$formularios]
                )

                </div>
             </div>
            @csrf()

             @include('plantillas.formulariosOcultos',
                ['formulariosOcultos'=>$formulariosOcultos] 
             )
             
            <div class="col-md-10 offset-md-1">
                <div id="div-empresas" class="row">

                </div>
            </div>
            <hr>
           <div class="col-md-12">
           <center>
                <a  class="btn btn-success" href="{{$linkCreate}}" >Registrar Empresa</a>
            </center>
           </div>

           

        @include('plantillas.tarjetaDinamicaCierre')

    </div>
</div>
@include('celestial-template.footer')