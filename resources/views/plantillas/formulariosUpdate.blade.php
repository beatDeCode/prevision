<div class="container-fluid">
<hr>
<form onsubmit="return false;" name="{{$nombreFormulario}}">
    <div class="row">
    @csrf()
    @if(sizeof($formulariosUpdate)>0)
            @foreach(array_keys($formulariosUpdate) as $key)
                <?php $input=explode('|',$key); ?>
                @if($input[1]=='input')
                    
                    @if($input[2]!='hidden')
                    <div class="{{$input[3]}}">
                        <div class="form-group">
                            <label for="{{$input[0]}}" id="{{$input[0]}}">{{$input[4]}}</label>
                            <input type="{{$input[2]}}" class="form-control" placeholder="" aria-label="Username" 
                            name="{{$input[0]}}" id="{{$input[0]}}" value="{{$input[5]}}">
                            <center><div class="badge badge-outline-warning" style="margin-top:5px;font-size:11px;display:none;" id="div-{{$input[0]}}" ></div></center>
                            
                        </div>
                    </div>
                    @elseif($input[2]=='hidden')
                        <input type="{{$input[2]}}" class="form-control" placeholder="" aria-label="Username" 
                        name="{{$input[0]}}" id="{{$input[0]}}" value="{{$input[5]}}">
                    @endif
                    
                
                @endif
                @if($input[1]=='select')
                    <div class="{{$input[3]}}">
                    <div class="form-group">
                        <label for="{{$input[0]}}" id="{{$input[0]}}">{{$input[4]}}</label>
                        <select class="form-control " id="{{$input[0]}}" name="{{$input[0]}}" style="padding: 14px;">
                        <option value=""></option>
                            @foreach($formulariosUpdate[$key] as $option)
                                @if($option['value']==$input[5])
                                    <option value="{{$option['value']}}" selected>{{$option['text']}}</option>
                                @elseif($option['value']!=$input[5])
                                    <option value="{{$option['value']}}">{{$option['text']}}</option>
                                @endif
                                
                                
                            @endforeach
                        </select>
                        <br>
                        <center><div class="badge badge-outline-warning" style="margin-top:1px;font-size:11px;display:none;" id="div-{{$input[0]}}"></div></center>
                    </div>
                    </div>

                @endif
            @endforeach
    @endif
    </div>
    
        <div class="row">
            <div class="col-md-12">
                <center>
                <button type="button" class="btn btn-info btn-sm" onclick="fnValidarFormularioUpdate()" >Buscar</button>
                <a  class="btn btn-success btn-sm" href="{{$linkVolver}}" >Volver</a>
                </center>
            </div>
            
        </div>
    
</form>
</div>