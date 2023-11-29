$('select[name="cd_estado"').on('change',function(){
    var busqueda='busquedaMunicipios';
    var tokenLaravel=$('input[name="_token"]').val();
    var estado=$('select[name="cd_estado"] option:selected').val();
    var selectMunicipio=$('select[name="cd_municipio"]');
    var formulario=[];
    formulario.push({name:'tp_query',value:1});
    formulario.push({name:'query',value:busqueda});
    formulario.push({name:'cd_estado',value:estado});
    $.ajax({
        url:'/prevision.general.querys',
        type:'POST',
        cache:false,
        headers: {'X-CSRF-TOKEN': tokenLaravel},
        data:formulario
    }).done(function(response){
        selectMunicipio.find('option').remove().end();
        selectMunicipio.append($('<option>', {value:'', text:''}));
        var JSONParse=JSON.parse(response);
        if(JSONParse.httpResponse==200){
            var valoresOption=JSONParse.message.content;
            console.log(valoresOption);
            for(var a=0;a<valoresOption.length;a++){
               
                selectMunicipio.append($('<option>', {value:valoresOption[a]['value'], text:valoresOption[a]['text']}));
            }
            
        }
    });
});

$('select[name="cd_municipio"').on('change',function(){
    var busqueda='busquedaParroquias';
    var tokenLaravel=$('input[name="_token"]').val();
    var municipio=$('select[name="cd_municipio"] option:selected').val();
    var selectParroquia=$('select[name="cd_parroquia"]');
    var formulario=[];
    formulario.push({name:'tp_query',value:1});
    formulario.push({name:'query',value:busqueda});
    formulario.push({name:'cd_municipio',value:municipio});
    $.ajax({
        url:'/prevision.general.querys',
        type:'POST',
        cache:false,
        headers: {'X-CSRF-TOKEN': tokenLaravel},
        data:formulario
    }).done(function(response){
        selectParroquia.find('option').remove().end();
        var JSONParse=JSON.parse(response);
        if(JSONParse.httpResponse==200){
            var valoresOption=JSONParse.message.content;
            selectParroquia.append($('<option>', {value:'', text:''}));
            for(var a=0;a<valoresOption.length;a++){
                selectParroquia.append($('<option>', {value:valoresOption[a]['value'], text:valoresOption[a]['text']}));
            }
            
        }
    });
});