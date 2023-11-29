<form onsubmit="return false;" name="formulario-{{$modelo}}">
    @if(sizeof($formularios)>0)
        <div class="row">
        @foreach($formularios as $formulario)
            <!-- Si el formulario es input-->
            @if($formulario['input']=='text' ||
                $formulario['input']=='date'||
                $formulario['input']=='number'
            )
                <div class="col-md-{{$formulario['columnas']}}">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Colocar {{$formulario['titulo']}}" aria-label="Username" name="{{$formulario['nombre']}}">
                    </div>
                </div>
            @endif

            <!-- Si el formulario es select-->
            @if($formulario['input']=='select')
            <div class="col-md-{{$formulario['columnas']}}">
                <div class="form-group">
                    <label for="exampleFormControlSelect3">Small select</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3">
                        <option value=""></option>
                        @foreach($formulario['opciones'] as $opcion)
                        <option value="{{$opcion['value']}}">{{$opcion['text']}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="col-md-2">
            <button type="button" class="btn btn-info" onclick="{{$funcionJsDeBusqueda}}" >Buscar</button>
        </div>
    @endif
</form>

<!--<button type="button" class="btn btn-primary btn-rounded btn-icon" onclick="{{$funcionJsDeBusqueda}}">
            <i class="typcn typcn-home-outline"></i>
        </button>  -->