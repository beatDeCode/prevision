<div class="container-fluid">
<form onsubmit="return false;" name="{{$nombreFormulario}}">
    <div class="row">
    @csrf()
        @if(sizeof($formulariosCreate)>0)
            @foreach(array_keys($formulariosCreate) as $key)
                <?php $input=explode('|',$key); ?>
                @if($input[1]=='input' )
                    @if($input[2]!='hidden')

                    <div class="{{$input[3]}}" id="{{$input[0]}}">
                        <div class="form-label-group outline">
                            <input type="{{$input[2]}}" id="{{$input[0]}}" name="{{$input[0]}}"
                            class="form-control shadow-none" placeholder="{{$input[4]}}" style="height:47px;font-size:13px;" />
                            <span><label for="{{$input[0]}}" id="{{$input[0]}}">{{$input[4]}}</label></span>
                        </div>
                        <div id="error{{$input[0]}}" style="font-size:11px;display:none;color:red;"></div>
                    </div>
                    @elseif($input[2]=='hidden')
                        <input type="{{$input[2]}}" class="form-control" placeholder="" aria-label="Username" 
                        name="{{$input[0]}}" id="{{$input[0]}}" value="{{$input[5]}}">
                    @endif
                @endif

                @if($input[1]=='select')
                <div class="{{$input[3]}}" id="{{$input[0]}}" >

                    <div class="form-label-group outline">
                        <select class="custom-select" id="{{$input[0]}}" name="{{$input[0]}}" style="height:47px;font-size:13px;">
                            <option value=""></option>
                            @foreach($formulariosCreate[$key] as $option)
                                <option value="{{$option['value']}}">{{$option['text']}}</option>
                            @endforeach
                        </select>
                        <span><label for="{{$input[0]}}" id="{{$input[0]}}" >{{$input[4]}}</label></span>
                    </div>
                    <div id="error{{$input[0]}}" style="font-size:11px;display:none;color:red;"></div>
                </div>
                @endif
                @if($input[1]=='checkbox')
                <div class="{{$input[3]}}" id="{{$input[0]}}">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span><label id="{{$input[0]}}" class="input-group-text" style="height:30;border-radius:8px;margin-top:10px;" id="basic-addon1">{{$input[4]}}</label></span>
                    </div>
                    <input type="{{$input[1]}}" class="form-control" name="{{$input[0]}}" aria-label="Username" aria-describedby="basic-addon1"
                        style="height:20;font-size:13px;border-radius:8px;margin-top:10px;"
                    >
                </div>
                <div id="error{{$input[0]}}" style="font-size:11px;display:none;color:red;"></div>
                </div>
                @endif
                @if($input[1]=='div')
                    <div class="{{$input[3]}}" id="{{$input[0]}}" >
                    </div>
                @endif

                @if($input[1]=='hr')
                    
                    <div class="col-md-12" style="margin-top:10px;" id="{{$input[0]}}">
                        <div class="badge" style="background-color: #7c90a7;color:white;text-align:left;">
                            {{$input[4]}}
                        </div>
                        <hr class="hr-none">
                    </div>
                @endif
            @endforeach
        @endif
        @if($cantidadDeClonacion>0)
            
            @for($a=0;$a<$cantidadDeClonacion;$a++)
                @foreach(array_keys($formulariosAClonar) as $key)
                    <?php $input=explode('|',$key); ?>
                    @if($input[1]=='input' )
                        @if($input[2]!='hidden')

                        <div class="{{$input[3]}}" id="{{$input[0].''.$a}}" style="display:none;">
                            <div class="form-label-group outline">
                                <input type="{{$input[2]}}" id="{{$input[0].''.$a}}" name="{{$input[0].''.$a}}"
                                class="form-control shadow-none" placeholder="{{$input[4]}}" style="height:47px;font-size:13px;" />
                                <span><label for="{{$input[0].''.$a}}" id="{{$input[0].''.$a}}">{{$input[4]}}</label></span>
                            </div>
                            <div id="error{{$input[0].''.$a}}" style="font-size:11px;display:none;color:red;"></div>
                        </div>
                        @endif
                    @endif

                    @if($input[1]=='select')
                    <div class="{{$input[3]}}" id="{{$input[0].''.$a}}" style="display:none;" >

                        <div class="form-label-group outline">
                            <select class="custom-select" id="{{$input[0].''.$a}}" name="{{$input[0].''.$a}}" style="height:47px;font-size:13px;">
                                <option value=""></option>
                                @foreach($formulariosAClonar[$key] as $option)
                                    <option value="{{$option['value']}}">{{$option['text']}}</option>
                                @endforeach
                            </select>
                            <span><label for="{{$input[0].''.$a}}" id="{{$input[0].''.$a}}" >{{$input[4]}}</label></span>
                        </div>
                        <div id="error{{$input[0].''.$a}}" style="font-size:11px;display:none;color:red;"></div>
                    </div>
                    @endif
                    

                    @if($input[1]=='button')
                    <div class="{{$input[3]}}" id="{{$input[0].''.$a}}" style="display:none;">
                        <button type="button" class="btn btn-sm" style="background-color: #7c90a7;color: white;margin-top:10px;" onclick="fnQuitarUltimoForm({{$a}})">Quitar</button>
                    </div>
                    @endif
                @endforeach
            @endfor
        @endif
        <input type="hidden" value="0" name="contador-clonacion">
    </div>
    </form>
</div>