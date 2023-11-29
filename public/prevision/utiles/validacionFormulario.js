function fnValidarInputVacio(formulario){
    var contador=0;
    var retorno=false;
    for(var a=0;a<formulario.length;a++){
        if(formulario[a]['value']){
            contador=+1;
        }
    }
    if(contador>0){
        retorno=true;
    }
    return contador;
}

function fnValidarFormularioUpdate(){
    var nombreFormulario=$('input[name="nombre-formulario"]').val();
    var transicion=$('input[name="transicion"]');
    var urlPrincipal=$('input[name="url-principal"]').val();
    var formularioUpdate=$('form[name="'+nombreFormulario+'"]').serializeArray();
    var urlValidacionUpdate=$('input[name="url-validacion"]').val();
    var tokenLaravel=$('input[name="_token"]').val();
    var contenidoHtml=fnSweetAlertParaValidar(formularioUpdate);
    var sweetAlert=fnAlertDetalleFormulario(contenidoHtml,'Transacción');
    sweetAlert.then((response) =>{
        if(response.isConfirmed){
            if(formularioUpdate.length>0){
                fnAlertaDeEsperaTransccion();
                $.ajax({
                    url:urlValidacionUpdate,
                    type:'POST',
                    data:formularioUpdate,
                    cache:false,
                    headers: {'X-CSRF-TOKEN': tokenLaravel}

                }).done(function(response){
                    
                    var JSONParse=JSON.parse(response);
                    if(JSONParse.httpResponse==200){
                        swal.close();
                        if(transicion){
                            setInterval(function(){
                                window.location.replace(urlPrincipal+'/'+JSONParse.message.content),
                                1000
                            });
                        }else{
                            fnTransaccionConfirmada('Transaccion',JSONParse.message.content);
                            setInterval(function(){
                                window.location.replace(urlPrincipal),
                                1000
                            });
                        }
                        
                    }else{
                        for(var c=0;c<formularioUpdate.length;c++){
                            $('div[id="error'+formularioUpdate[c]['name']+'"]').hide();
                            var divMensje=$('div[id="error'+formularioUpdate[c]['name']+'"]');
                            divMensje.html('');
                        }
                        swal.close();
                        var erroresResponse=JSONParse.message.content;
                        var clavesPrincipalesErrores=Object.keys(erroresResponse);
                        for(var a=0;a<clavesPrincipalesErrores.length;a++){
                            var indiceError=clavesPrincipalesErrores[a];
                            var mensajesError=erroresResponse[indiceError];                            
                            for(var b=0;b<mensajesError.length;b++){
                                console.log(indiceError);
                                $('div[id="error'+indiceError+'"]').css('display','flex');
                                var divMensje=$('div[id="error'+indiceError+'"]');
                                divMensje.html('');
                                divMensje.append(mensajesError[b]);
                            }
                        }

                    }
                }).fail(function(a,b,c){
                    console.log(a,b,c);
                });
            }
        }
    });
    
}

