@if(sizeof($formulariosOcultos)>0)
    @foreach($formulariosOcultos as $formulario)
        <?php $valoresFormulario=explode('|',$formulario);?>
        <input type="hidden" name="{{$valoresFormulario[0]}}" value="{{$valoresFormulario[1]}}">
    @endforeach
@endif