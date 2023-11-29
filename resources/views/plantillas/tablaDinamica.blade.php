<div class="table-responsive">
    <table class="table table-striped display" id="tabla-{{$modelo}}" style="width:100%" >
    <thead>
    <tr>
        @if(sizeof($camposCabecera)>0)
            @foreach($camposCabecera as $campo)
                <th><center>{{explode('|',$campo)[1]}}</center></th>
            @endforeach

        @elseif(sizeof($camposCabecera)==0)
            <th><center>Información</center></th>
        @endif
    </tr>
    </thead>
    <tbody>
    <tr>
        @if(sizeof($camposCabecera)>0 && sizeof($valoresCuerpo)>0)
            @foreach($valoresCuerpo as $valor)
                @foreach($camposCabecera as $campo)
                    <td><center>{{$valor[explode('|',$campo)[0]] }}</center></td>
                @endforeach
            @endforeach
        @elseif(sizeof($camposCabecera)==0 && sizeof($valoresCuerpo)==0)
            <td><center>La tabla no contiene información</center></td>
        @endif
    </tr>
    </tbody>
</table>
</div>