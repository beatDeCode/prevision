/*function fnClonarInputs(){
    var divClonarInputs=$('div[id="area-clonacion"]');
    divClonarInputs.css('display','contents');
    var inputContadorClonacion=$('input[name="contador-clonacion"]');
    var valorContadorClonacion=inputContadorClonacion.val();
    var nombreFormulario=$('input[name="nombre-formulario"]').val();
    var formulario=$('form[name="'+nombreFormulario+'"]').serializeArray();
    if(formulario.length>0){
        for(var a=0;a<formulario.length;a++){
            if( (formulario[a]['name']).substr(0,5).includes("clone") ){
            }else{
                if( (formulario[a]['name']).substr(0,6).includes("_token") ){

                }else{
                    var formAClonar=$('div[id="clone-'+formulario[a]['name']+'"]');
                    divClonarInputs.append(formAClonar.clone());
                    $('div[id="area-clonacion"]  div[id="clone-'+formulario[a]['name']+'"]').each(function(){
                        $(this).attr('id',$(this).attr('id')+''+valorContadorClonacion);
                    });
                    $('div[id="area-clonacion"] label[id="'+formulario[a]['name']+'"]').each(function(){
                        $(this).attr('id','clone'+$(this).attr('id')+''+valorContadorClonacion);
                    });
                    $('div[id="area-clonacion"] input[name="'+formulario[a]['name']+'"]').each(function(){
                        $(this).attr('name','clone'+$(this).attr('name')+''+valorContadorClonacion);
                    });
                    $('div[id="area-clonacion"] select[name="'+formulario[a]['name']+'"]').each(function(){
                        $(this).attr('name', 'clone'+$(this).attr('name')+''+valorContadorClonacion);
                    });
                }
                
            }
            
        }
        inputContadorClonacion.val(parseInt(valorContadorClonacion)+1);
    }
} */

function fnClonarInputs(){
    var nombreFormulario=$('input[name="nombre-formulario"]').val();
    var inputContadorClonacion=$('input[name="contador-clonacion"]'); 
    var valorContadorClonacion=inputContadorClonacion.val();
    var formulario=$('form[name="'+nombreFormulario+'"]').serializeArray();
    console.log(formulario);
    for(var a=0;a<formulario.length;a++){
        if(formulario[a]['name']!='_token' && formulario[a]['name']!='cd_persona'){
            var divOculto=$('div[id="'+formulario[a]['name']+''+valorContadorClonacion+'"]');
            divOculto.show();
        }
    }
    $('div[id="boton'+valorContadorClonacion+'"]').show();
    inputContadorClonacion.val(parseInt(valorContadorClonacion)+1);

}

function fnQuitarUltimoForm(){
    var inputContadorClonacion=$('input[name="contador-clonacion"]'); 
    var valoresFormulario=$('input[name="valores-formulario"]').val();
    var valorContadorClonacion=inputContadorClonacion.val();
    console.log(valorContadorClonacion);
    var valoresDesglosados=valoresFormulario.split(',');
    for(var a=0;a<valoresDesglosados.length;a++){
        
        var divOculto=$('div[id="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        divOculto.hide();
        var input=$('input[name="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        var select=$('select[name="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        if(input){
            input.val('');
        }
        if(select){
            select.val('');
        }
    }
    inputContadorClonacion.val(parseInt(valorContadorClonacion)-1);
}

function fnClonarInputsFase(fase){
    var nombreFormulario=$('input[name="nombre-formulario'+fase+'"]').val();
    var inputContadorClonacion=$('input[name="contador-clonacion"]'); 
    var valorContadorClonacion=inputContadorClonacion.val();
    var formulario=$('form[name="'+nombreFormulario+'"]').serializeArray();
    for(var a=0;a<formulario.length;a++){
        if(formulario[a]['name']!='_token' && formulario[a]['name']!='cd_persona'){
            var divOculto=$('div[id="'+formulario[a]['name']+''+valorContadorClonacion+'"]');
            divOculto.show();
        }
    }
    $('div[id="boton'+valorContadorClonacion+'"]').show();
    inputContadorClonacion.val(parseInt(valorContadorClonacion)+1);

}
function fnQuitarUltimoFormFase(fase){
    var inputContadorClonacion=$('input[name="contador-clonacion"]'); 
    var valoresFormulario=$('input[name="valores-formulario'+fase+'"]').val();
    var valorContadorClonacion=inputContadorClonacion.val();
    var valoresDesglosados=valoresFormulario.split(',');
    for(var a=0;a<valoresDesglosados.length;a++){
        var divOculto=$('div[id="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        divOculto.hide();
        var input=$('input[name="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        var select=$('select[name="'+valoresDesglosados[a]+''+(parseInt(valorContadorClonacion)-1)+'"]');
        if(input){
            input.val('');
        }
        if(select){
            select.val('');
        }
    }
    inputContadorClonacion.val(parseInt(valorContadorClonacion)-1);
}