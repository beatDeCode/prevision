<div class="{{$input[3]}}" id="clone-{{$input[0]}}">
                        <div class="form-group">
                            <label for="{{$input[0]}}" id="{{$input[0]}}">{{$input[4]}}</label>
                            <input type="{{$input[2]}}" class="form-control" placeholder="" aria-label="Username" 
                            name="{{$input[0]}}" id="{{$input[0]}}">
                            <center><div class="badge badge-outline-warning" style="margin-top:18px;font-size:11px;display:none;" id="div-{{$input[0]}}" ></div></center>
                        </div>
                    </div>
                    <div class="{{$input[3]}}" id="clone-{{$input[0]}}">
                    <div class="form-group">
                        <label for="{{$input[0]}}" id="{{$input[0]}}" >{{$input[4]}}</label>
                        <select class="form-control " id="{{$input[0]}}" name="{{$input[0]}}" style="padding: 14px;">
                            <option value=""></option>
                            @foreach($formulariosCreate[$key] as $option)
                                <option value="{{$option['value']}}">{{$option['text']}}</option>
                            @endforeach
                        </select>
                        <br>
                        <center><div class="badge badge-outline-warning" style="margin-top:1px;font-size:11px;display:none;" id="div-{{$input[0]}}"></div></center>
                    </div>
                    </div>


                    
    <div class="row">
        <div id="area-clonacion">
    </div>
       
    </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @if($nombreFormulario=='formulario-contrato')
                    <center>
                    <a  class="btn btn-info btn-sm" href="/prevision.procesos.contrato.domicilio.create" >Siguiente</a>
                    </center>
                @endif
                @if($nombreFormulario=='formulario-contrato-dom')
                    <center>
                    <a  class="btn btn-info btn-sm" href="/prevision.procesos.contrato.garantias.create" >Siguiente</a>
                    </center>
                @endif
                @if($nombreFormulario=='formulario-garantias')
                    <center>
                    <a  class="btn btn-info btn-sm" href="/prevision.procesos.contrato.adicionales.create" >Siguiente</a>
                    </center>
                @endif
                @if($nombreFormulario=='formulario-adicionales')
                    <center>
                    <a  class="btn btn-info btn-sm" href="/prevision.procesos.contrato.factura.create" >Siguiente</a>
                    </center>
                @endif
                @if($nombreFormulario!='formulario-contrato' && $nombreFormulario!='formulario-contrato' && $nombreFormulario!='formulario-contrato-dom'
                && $nombreFormulario!='formulario-garantias'&& $nombreFormulario!='formulario-adicionales' )
                    <center>
                        <button type="button" class="btn btn-success btn-sm" onclick="fnValidarFormularioUpdate()" >Registrar</button>
                        @if($linkVolver)
                            <a  class="btn btn-info btn-sm" href="{{$linkVolver}}" >Volver</a>
                        @endif
                    </center>
                @endif
                
            </div>
            
        </div>
    
</form>
<input type="hidden" name="contador-clonacion" value="0">


<div class="{{$input[3]}}" id="{{$input[0]}}">
<div class="form-group">
    <div class="form-check">
    <label class="form-check-label" for="{{$input[0]}}" id="{{$input[0]}}">
        <input type="checkbox" class="form-check-input" style="margin:10px;" name="{{$input[0]}}" id="{{$input[0]}}">
    <i class="input-helper"></i>{{$input[4]}}</label>
    <center><div class="badge badge-outline-warning" style="margin-top:1px;font-size:11px;display:none;" id="div-{{$input[0]}}"></div></center>
    </div>
</div>
</div>


                <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="height:30;border-radius:8px;" id="basic-addon1">{{$input[4]}}</span>
                            </div>
                            <input type="{{$input[2]}}" class="form-control" name="{{$input[0]}}" aria-label="Username" aria-describedby="basic-addon1"
                            style="height:30;font-size:13px;border-radius:8px;"
                            >
                            
                        </div>

                        <div class="form-label-group outline">
                            <input type="{{$input[2]}}" id="{{$input[0]}}" name="{{$input[0]}}"
                            class="form-control shadow-none" placeholder="{{$input[4]}}" />
                            <span><label for="{{$input[0]}}">{{$input[4]}}</label></span>
                        </div>