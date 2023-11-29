function fnValidarCredenciales(){
    var tokenLaravel=$('input[name="_token"]').val();
    var formulario=$('form[name="form-login"]').serializeArray();
    
    fnAlertaDeEspera();
    
    if(fnValidarInputVacio(formulario) > 0){
        console.log(formulario);
        var objetoPeticion={
            url:'/prevision.autenticacion.valida-credenciales',
            type:'POST',
            cache:false,
            headers: {'X-CSRF-TOKEN': tokenLaravel},
            data:formulario
        };
        
        $.ajax(
            objetoPeticion
        ).done(function(response){
            var jsonDecode=JSON.parse(response);
            console.log(jsonDecode);
            if(jsonDecode['httpResponse']==200){
                if(jsonDecode['message']['validate']==1){
                    setInterval(
                    window.location.replace('/prevision.principal'),
                    750
                    );
                }else{
                    fnToastAutenticacionFallida('Autenticacion Fallida...');
                }
            }else{
                fnToastAutenticacionFallida('Existe un error en el servidor..');
            }
        }).fail(function(a,b,c){
            fnToastAutenticacionFallida('Existe un error en el servidor..');
            console.log(a,b,c);
        });
    }else{
        swal.close();
        console.log('El formulario debe contener valores');
    }

}