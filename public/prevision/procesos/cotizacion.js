function fnValidarVacios(formulario){
    var contadorErrores=0;
    var valoresFormulario=$('form[name="'+formulario+'"]').serializeArray();
    if(valoresFormulario.length>0){
        for(var a=0;a<valoresFormulario.length;a++){
            var select=$('select[name="'+valoresFormulario[a]['name']+'"]');
            var input=$('input[name="'+valoresFormulario[a]['name']+'"]');
            if(select.length==1){
                var valorSelect=$('select[name="'+valoresFormulario[a]['name']+'"] option:selected');
                var div=$('div[id="error'+valoresFormulario[a]['name']+'"]');
                if(valorSelect.val()){
                    div.hide();
                }else{
                    div.show();
                    div.html('');
                    div.append('El campo está vacío.');
                    contadorErrores+=1;
                }
            }
            if(input.length==1){
                var valorInput=$('input[name="'+valoresFormulario[a]['name']+'"]');
                var div=$('div[id="error'+valoresFormulario[a]['name']+'"]');
                if(valorInput.val()){
                    div.hide();
                }else{
                    div.show();
                    div.html('');
                    div.append('El campo está vacío.');
                    contadorErrores+=1;
                    
                }
            }
        }
    }
    return contadorErrores;
}
function fnDevolverFase(fase){
    if(fase==2){
        $('#fase2').hide();
        $('#fase1').show();
        
    }
    if(fase==3){
        $('#fase3').hide();
        $('#fase2').show();
    }
    if(fase==4){
        $('#fase4').hide();
        $('#fase3').show();
    }
}
function fnMoverFase2(formulario){
    var validacionFase1=fnValidarVacios(formulario);
    console.log(validacionFase1);
    if(validacionFase1==0){
        var fase1=$('div[id="fase1"]');
        fase1.hide(500);
        var fase2=$('div[id="fase2"]');
        fase2.fadeIn('slow');
    }
    
}
function fnCrearCotizacion(){
    var tokenLaravel=$('input[name="_token"]').val();
    var contadorDeClonacion=$('input[name="contador-clonacion"]').val();
    var cedulaTitular=$('input[name="nu_documento"]').val();
    var tipoDocumento=$('select[name="tp_documento"] option:selected').val();
    var nm_persona1=$('input[name="nm_persona1"]').val();
    var ap_persona1=$('input[name="ap_persona1"]').val();
    var mt_suma_asegurada=$('select[name="mt_suma_asegurada"] option:selected').val();
    var cd_producto=$('select[name="cd_producto"] option:selected').val();
    var cd_grupo_familiar=$('select[name="cd_grupo_familiar"] option:selected').val();
    var cd_plan_pago=$('select[name="cd_plan_pago"] option:selected').val();
    var valoresFormulario=$('input[name="valores-formulario"]').val();
    var tipoCalculo=$('select[name="cd_tipo_calculo"] option:selected').val();
    var mt_prima=0;
    if($('input[name="mt_prima"]')){
        mt_prima=$('input[name="mt_prima"]').val();
    }   
    var valoresDesglosados=valoresFormulario.split(',');
    var formulario=[];
    formulario.push({name:'nu_documento',value:cedulaTitular});
    formulario.push({name:'tp_documento',value:tipoDocumento});
    formulario.push({name:'nm_persona1',value:nm_persona1});
    formulario.push({name:'ap_persona1',value:ap_persona1});
    formulario.push({name:'cd_producto',value:cd_producto});
    formulario.push({name:'mt_suma_asegurada',value:mt_suma_asegurada});
    formulario.push({name:'cd_grupo_familiar',value:cd_grupo_familiar});
    formulario.push({name:'cd_plan_pago',value:cd_plan_pago});
    formulario.push({name:'ca_clonacion',value:contadorDeClonacion});
    formulario.push({name:'cd_tipo_calculo',value:tipoCalculo});
    formulario.push({name:'mt_prima',value:mt_prima});
    for(var a=0;a<valoresDesglosados.length;a++){
        if(valoresDesglosados[a]=='boton'){
            
        }else{
            var select=$('select[name="'+valoresDesglosados[a]+'"]');
            var input=$('input[name="'+valoresDesglosados[a]+'"]');
            if(input.length==1){
                var valorInput=$('input[name="'+valoresDesglosados[a]+'"]').val();
                formulario.push({name:valoresDesglosados[a],value:valorInput});
            }
            if(select.length==1){
                var valorSelect=$('select[name="'+valoresDesglosados[a]+'"] option:selected').val();
                formulario.push({name:valoresDesglosados[a],value:valorSelect});
            }
        }
    }
    for(var b=0;b<contadorDeClonacion;b++){
        for(var c=0;c<valoresDesglosados.length;c++){
            if(valoresDesglosados[c]=='boton'){
                
            }else{
                var select=$('select[name="'+valoresDesglosados[c]+''+b+'"]');
                var input=$('input[name="'+valoresDesglosados[c]+'"]');
                if(input.length==1){
                    var valorInput=$('input[name="'+valoresDesglosados[c]+''+b+'"]').val();
                    formulario.push({name:valoresDesglosados[c]+''+b,value:valorInput});
                }
                if(select.length==1){
                    var valorSelect=$('select[name="'+valoresDesglosados[c]+''+b+'"] option:selected').val();
                    formulario.push({name:valoresDesglosados[c]+''+b,value:valorSelect});
                }
            }
        }
    }
    $.ajax({
        url:'/prevision.procesos.cartera.generar-cotizacion',
        type:'POST',
        cache:false,
        headers: {'X-CSRF-TOKEN': tokenLaravel},
        data:formulario
    }).done(function(response){
        var JSONParse=JSON.parse(response);
        if(JSONParse.httpResponse==200){
            var valoresCotizacion=JSONParse.message.content;
            var valorArea=$('select[name="nu_area"] option:selected').text();
            var valorTelefono=$('input[name="nu_telefono"]').val();
            var valorCorreo=$('input[name="de_correo"]').val();
            var tipoCalculo=$('select[name="cd_tipo_calculo"] option:selected').val();
            var cobertura=$('select[name="cd_cobertura"] option:selected').text();
            var planpago=$('select[name="cd_plan_pago"] option:selected').text();
            var siglas=valoresCotizacion[0]['siglas_moneda'];
            var cabecera1=
            '<td style="font-size:11px;background-color:#e9ecef;text-align:left;">'+
                '<b>Cliente</b>:'+valoresCotizacion[0]['nm_completo']+' '+valoresCotizacion[0]['nu_documento']+'<br/>'+
                '<b>Telefono</b>: '+valorArea+valorTelefono+'<br/>'+
                '<b>Correo</b>:'+valorCorreo+'<br/>'+
            '</td>';
            
            var coberturaDetalle=valoresCotizacion[0]['de_cobertura_detalle'];
            var cabecera2=
            '<td style="font-size:11px;background-color:#e9ecef;text-align:left;">'+
                '<b>Producto</b>: '+valoresCotizacion[0]['producto']+'<br />'+
                '<b>Cobertura</b>: '+cobertura+' / <b>Monto a Riesgo</b>:'+coberturaDetalle+'<br/>'+
                '<b>Grupo Familiar</b>:'+valoresCotizacion[0]['grupo_familiar']+'<br/>'+
                '<b>Plan de Pago</b>: '+planpago+'<br/>'+
            '</td>';
            
            var contenidoCabecera=cabecera1+cabecera2;
            var contenidoTitular='';
            var contenidoAsegurados='';
            var base=0;
            for(var a=0;a<valoresCotizacion.length;a++){
                base+=parseFloat(valoresCotizacion[a]['mt_prima_plan']);
                if(a==0){
                    var contenidoTitular=
                    '<tr class="details" style="font-size:11px;text-align:center;">'+
                        '<td><center>'+valoresCotizacion[a]['parentesco']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['nm_completo']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['nu_documento']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['es_adicional']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['mt_prima']+' '+siglas+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['mt_prima_plan']+' '+siglas+'</center></td>'+
                    '<tr/>'
                    ;
                }
                if(a>0){
                    contenidoAsegurados+=
                    '<tr class="details" style="font-size:11px;text-align:center;">'+
                        '<td><center>'+valoresCotizacion[a]['parentesco']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['nm_completo']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['nu_documento']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['es_adicional']+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['mt_prima']+''+siglas+'</center></td>'+
                        '<td><center>'+valoresCotizacion[a]['mt_prima_plan']+''+siglas+'</center></td>'+
                        
                    '</tr>';
                }
            }
            var subTotal=base*(0.16);
            var total=base+subTotal;
            var baseConDecimales=base.toFixed(3);
            var subTotalConDecimales=subTotal.toFixed(3);
            var totalConDecimales=total.toFixed(3);
            var contenidoTotal=
            '<tr class="item last">'+
            '<td colspan="4"></td>'+
            '<td style="text-align:center;font-size:11px;"><b>Total Prima Base</b></td>'+
            '<td style="text-align:center;font-size:11px;background-color: #e9ecef;"><b>'+baseConDecimales.replace('.',',')+' '+siglas+'</b></td>'+
            '</tr>'+
            '<tr class="item last">'+
            '<td colspan="4"></td>'+
            '<td style="text-align:center;font-size:11px;"><b>Sub Total (16%) I.V.A</b></td>'+
            '<td style="text-align:center;font-size:11px;background-color: #e9ecef;"><b>'+subTotalConDecimales.replace('.',',')+' '+siglas+'</b></td>'+
            '</tr>'+
            '<tr class="item last">'+
            '<td colspan="4"></td>'+
            '<td style="text-align:center;font-size:11px;"><b>Total</b></td>'+
            '<td style="text-align:center;font-size:11px;background-color: #e9ecef;"><b>'+ totalConDecimales.replace('.',',')+' '+siglas+'</b></td>'+
            '</tr>';
            var detalleFactura=contenidoTitular+contenidoAsegurados;
            var tablaFactura=fnArmarFactura(contenidoCabecera,detalleFactura,contenidoTotal);
            var div=$('div[id="factura"]');
            div.html('');
            div.append(tablaFactura);
        }
    }).fail(function(a,c,b){
        console.log(a,b,c);
    });

}
function fnArmarFactura(contenidoCabecera,contenidDetalle,total){
    var factura=
    '<div class="invoice-box">'+
	'<table cellpadding="0" cellspacing="0" >'+
		'<tr class="top">'+
			'<td colspan="6">'+
				'<table>'+
				'<tr>'+
                    '<td class="title" style="font-size:11px;">'+
                        '<img src="/images/prevision-loginv1.png"style="width: 100%; max-width: 150px"/>'+
                    '</td>'+

                    '<td style="font-size:11px;">'+
                        'Caracas, 10/11/2023 <br />'+
                        'Prevision Funeraria (ASOPROINFU)<br/>'+
                    '</td>'+
				'</tr>'+
			    '<tr>'+
                    contenidoCabecera+
				'</tr>'+
				'</table>'+
			'</td>'+
		'</tr>'+
		'<tr class="information" >'+
			'<td colspan="6" style="font-size:11px;">'+
				'<center><b>Detalle de la Cotización</b><center>'+
			'</td>'+
		'</tr>'+
		'<tr class="heading" style="font-size:11px;text-align:center;">'+
			'<td>Parentesco</td>'+
			'<td>Nombre</td>'+
			'<td>Documento </td>'+
            '<td>¿Es Adicional?</td>'+
			'<td>Cuota </td>'+
            '<td>Cuota Por Plan Pago</td>'+
            
		'</tr>'+
        contenidDetalle+
        total+
	'</table>'+
	'</div>';
    return factura;
    
}
function fnArregloBorrarErrores(contadorDeClonacion){
    var limpiarError1=$('div[id="errornu_documento"]');
    var limpiarError2=$('div[id="errornu_documento_asegurado"]');
    limpiarError1.html('');
    limpiarError2.html('');
    for(var b=0;b<contadorDeClonacion;b++){
        var limpiarError3=$('div[id="errornu_documento_asegurado"'+b+']');
        limpiarError3.html('');
    }
}
function fnMoverFase3(formulario){
    var tokenLaravel=$('input[name="_token"]').val();
    var validacionFase2=fnValidarVacios(formulario);
    var contadorDeClonacion=$('input[name="contador-clonacion"]').val();
    var auxiliarValiacionFase2=parseInt(validacionFase2) - (36-(parseInt(contadorDeClonacion)*5));
    try {
        //fnValidarDocumento();
        calcularEdad();
        fnValidarTelefono();
        if(auxiliarValiacionFase2<=0){
            var formulario=[];
            var documentoTitular=$('input[name="nu_documento"]').val();
            var producto=$('select[name="cd_producto"] option:selected').val();
            formulario.push({name:'ca_clonacion',value:contadorDeClonacion});
            formulario.push({name:'nu_documento',value:documentoTitular});
            formulario.push({name:'cd_producto',value:producto});
            
            if(contadorDeClonacion>=0){
                var documentoAsegurado=$('input[name="nu_documento_asegurado"]').val();
                formulario.push({name:'nu_documento_asegurado',value:documentoAsegurado});
                if(contadorDeClonacion>0){
                    for(var a=0;a<contadorDeClonacion;a++){
                        var documentoAseguradoExtra=$('input[name="nu_documento_asegurado'+a+'"]').val();
                        formulario.push({name:'nu_documento_asegurado'+a ,value:documentoAseguradoExtra});
                    }
                }
            }
            $.ajax({
                url:'/prevision.procesos.cartera.valida-asegurados',
                type:'POST',
                cache:false,
                headers: {'X-CSRF-TOKEN': tokenLaravel},
                data:formulario
            }).done(function(response){
                console.log(response);
                var JSONParse=JSON.parse(response);
                if(JSONParse.httpResponse==200){
                    var contenido=JSONParse.message.content;
                    var contadorErrores1=0;
                    if(contenido.length>0){
                        for(var a=0;a<contenido.length;a++){
                            if(contenido[a]['cuenta']==1){
                                contadorErrores1+=1;
                                var div=$('div[id="error'+contenido[a]['value']+'"]');
                                div.html('');
                                div.append(contenido[a]['error']);
                                div.show();
                            }
                        }
                    }
                    if(contadorErrores1==0){
                        var fase1=$('div[id="fase2"]');
                        fase1.hide(500);
                        var fase2=$('div[id="fase3"]');
                        fase2.fadeIn('slow');
                        fnCrearCotizacion();
                    }
                    
                    
                }
            }).fail(function(a,b,c){
                console.log(a,b,c);
            });
           
        }
    } catch (error) {
        console.log(error);
    }
}

function fnValidarTelefono(){
    var documento=$('input[name="nu_telefono"]').val();
    var div=$('div[id="errornu_telefono"]');
    if(documento.length==7){
        div.hide();
    }else{
        div.show();
        div.html('');
        div.append('El número debe posee solo 7 caracteres');
        throw "Error Telefono";
    }
}
function calcularEdad(){
    var feNacimiento=$('input[name="fe_nacimiento"]').val();
    var formatoFecha = new Date(feNacimiento);
    var diferenciaFechas = Date.now() - formatoFecha.getTime();
    var formatoDiferenciaFechas = new Date(diferenciaFechas); 
    var anio = formatoDiferenciaFechas.getUTCFullYear();
    var edad = Math.abs(anio - 1970);
    var div=$('div[id="errorfe_nacimiento"]');
    if(edad > 18){
        div.hide();
    }else{
        div.show();
        div.html('');
        div.append('El titular no puede ser menor de edad.');
        throw "Error Edad";
    }
}
function fnValidarFechaNacimiento(){
    var tokenLaravel=$('input[name="_token"]').val();
    var fechaNacimiento=$('input[name="fe_nacimiento"]').val();;
    var busqueda='busquedaEdadEntreFechas';
    var formulario=[];
    formulario.push({name:'tp_query',value:2});
    formulario.push({name:'query',value:busqueda});
    formulario.push({name:'fe_nacimiento',value:fechaNacimiento});
    if(fechaNacimiento){
        $.ajax({
            url:'/prevision.general.querys',
            type:'POST',
            cache:false,
            headers: {'X-CSRF-TOKEN': tokenLaravel},
            data:formulario
        }).done(function(response){
            var JSONParse=JSON.parse(response);
            if(JSONParse.httpResponse==200){
                var div=$('div[id="errorfe_nacimiento"]');
                if(parseInt(JSONParse.message.content[0].text) > 18){
                    div.hide();
                }else{
                    div.show();
                    div.html('');
                    div.append('El titular no puede ser menor de edad.');
                    throw "Error Edad";
                }
                
            }
        }).fail(function(a,c,b){
            console.log(a,b,c);
        });
    }
}

function fnValidarDocumento(){
    var tokenLaravel=$('input[name="_token"]').val();
    var documento=$('input[name="nu_documento"]').val();;
    var busqueda='busquedaValidacionDocumento';
    var formulario=[];
    formulario.push({name:'tp_query',value:2});
    formulario.push({name:'query',value:busqueda});
    formulario.push({name:'nu_documento',value:documento});
    if(documento){
        $.ajax({
            url:'/prevision.general.querys',
            type:'POST',
            cache:false,
            headers: {'X-CSRF-TOKEN': tokenLaravel},
            data:formulario
        }).done(function(response){
            console.log(response);
            var JSONParse=JSON.parse(response);
            if(JSONParse.httpResponse==200){
                var div=$('div[id="errornu_documento"]');
                if(JSONParse.message.content[0].text=='0'){
                    div.hide();
                }else{
                    div.show();
                    div.html('');
                    div.append(JSONParse.message.content[0].text);
                    throw "Error Documento";
                }
                
            }
        }).fail(function(a,c,b){
            console.log(a,b,c);
        });
    }
    
}
function fnEsconderDomicilio(){
    $('div[id="nu_documento_domicilio"]').css('display','none');
    $('div[id="tp_documento_domicilio"]').css('display','none');
    $('div[id="tp_cuenta"]').css('display','none');
    $('div[id="nu_cuenta"]').css('display','none');
    $('div[id="titulo2"]').css('display','none');
}
fnEsconderDomicilio();
$('select[name="cd_forma_pago"]').on('change',function(){
    var formaPago=$('select[name="cd_forma_pago"] option:selected').val();
    console.log(formaPago);
    if(formaPago){
        if(formaPago==1){
            $('div[id="tp_documento_domicilio"]').css('display','none');
            $('div[id="nu_documento_domicilio"]').css('display','none');
            $('div[id="tp_cuenta"]').css('display','none');
            $('div[id="nu_cuenta"]').css('display','none');
            $('div[id="titulo2"]').css('display','none');
        }
        if(formaPago==2){
            $('div[id="titulo2"]').css('display','inline');
            $('div[id="nu_documento_domicilio"]').css('display','inline');
            $('div[id="tp_documento_domicilio"]').css('display','inline');
            $('div[id="tp_cuenta"]').css('display','inline');
            $('div[id="nu_cuenta"]').css('display','inline');
            
        }
    }
});
function fnMoverFase4(){
    var fase1=$('div[id="fase3"]');
    fase1.hide(500);
    var fase2=$('div[id="fase4"]');
    fase2.fadeIn('slow');
}
/*
function fnFase4(formulario){
    var intermediario=$('select[name="cd_intermediario"] option:selected').val();
    var formaPago=$('select[name="cd_forma_pago"] option:selected').val();
    var contador=0;
    var div1=$('div[id="errorcd_forma_pago"]');
    if(formaPago){
        div1.hide();
    }else{
        
        div1.html('');
        div1.append('El campo está vacío');
        div1.show();
        contador+=1;
    }
    var div2=$('div[id="errorcd_intermediario"]');
    if(intermediario){
        div2.hide();
    }else{
        div2.show();
        div2.html('');
        div2.append('El campo está vacío');
        contador+=1;
    }
    if(contador>0){

    } else{
        var factura=$('div[id="factura"]').html();
        var ventanaConfirmacion=
        fnAlertDetalleFormulario(factura+'<br>¿Está seguro que desea Emitir la Poliza?','Transacción',);
        ventanaConfirmacion.then((response) =>{
            if(response.isConfirmed){
                fnTransaccionConfirmada('Transaccion','Se ha emitido la Póliza.');
                setInterval(function(){
                    window.location.replace('/prevision.procesos.cartera.cotizacion');
                },3000);
            }
        });
    }

}*/

$('select[name="cd_tipo_calculo"]').on('change',function(){
    var valorSeleccionado=$('select[name="cd_tipo_calculo"] option:selected').val();
    var html=
        '<div class="4" id="mt_prima">'+
            '<div class="form-label-group outline" >'+
                '<input type="number" id="mt_prima" name="mt_prima" '+
                'class="form-control shadow-none" placeholder="Colocar Prima" '+
                'style="height:47px;font-size:13px;" />'+

                '<span><label for="mt_prima" id="mt_prima">Monto Prima</label></span>'+
            '</div>'+
            '<div id="errormt_prima" style="font-size:11px;display:none;color:red;"></div>'+
        '</div>';
    var div=$('div[id="div_mt_prima"]');
    
    if(valorSeleccionado==2){
        div.html('');
        div.append(html);
    }else{
        div.html('');
    }
});
function validarFormularioArray(array){
    var contador=0;
    for(var a=0;a<array.length;a++){
        var indice=array[a]['value'];
        var div=$('div[id="error'+indice+'"]')
        if(array[a]['text']){
            div.hide();
        }else{
            div.show();
            div.html('');
            div.append('El campo est&aacute; vac&iacute;o');
            contador+=1;
        }
    }
    return contador;
}
function fnEmitir(){
    var formulario=[];
    var intermediario=$('select[name="cd_intermediario"]').val();
    var formaPago=$('select[name="cd_forma_pago"]').val(); 
    formulario.push({value:'cd_intermediario',text:intermediario});
    formulario.push({value:'cd_forma_pago',text:formaPago});
    
    var cantidadErrores=
    validarFormularioArray(formulario);
    if(cantidadErrores==0){
        
        if(formaPago==2 ){
            var tipoDocumentoDomiclio=$('select[name="tp_documento_domicilio"] option:selected').val();
            var documentoDomiclio=$('input[name="nu_documento_domicilio"]').val();
            var tipoCuenta=$('select[name="tp_cuenta"] option:selected').val(); 
            var cuenta=$('input[name="nu_cuenta"]').val(); 
            var div=$('div[id="errornu_cuenta"]');
            if(cuenta.length!=20){
                div.show();
                div.html('');
                div.append('La cuenta debe poseer 20 d&iacute;gitos.');
            }else{
                formulario.push({value:'tp_documento_domicilio',text:tipoDocumentoDomiclio});
                formulario.push({value:'nu_documento_domicilio',text:documentoDomiclio});
                formulario.push({value:'tp_cuenta',text:tipoCuenta});
                formulario.push({value:'nu_cuenta',text:cuenta});
                var formularioRequest=[];
                var tokenLaravel=$('input[name="_token"]').val();
                div.hide();
                busqueda='busquedaCodigoVerificadorBanco';
                formularioRequest.push({name:'tp_query',value:2});
                formularioRequest.push({name:'query',value:busqueda});
                formularioRequest.push({name:'nu_cuenta',value:cuenta});
                $.ajax({
                    url:'/prevision.general.querys',
                    type:'POST',
                    cache:false,
                    headers: {'X-CSRF-TOKEN': tokenLaravel},
                    data:formularioRequest
                }).done(function(response){
                    var JSONParse=JSON.parse(response);
                    var contenido=JSONParse.message.content;
                    if(contenido[0]['cuenta']==0){
                        var div=$('div[id="errornu_cuenta"]');
                        div.show();
                        div.html('');
                        div.append('La cuenta no pertenece a ning&uacute;n Banco.');  
                    }else{
                        fnGuardarContrato();
                    }
                }).fail(function(a,b,c){
                    console.log(a,b,c);
                });
            }
        }else{
            fnGuardarContrato();
        }
            
        

    }
    

}
function fnGuardarContrato(){
    var solicitud=[];
    var cantidadDeClonacion=0;
    cantidadDeClonacion=$('input[name="contador-clonacion"]').val();
    solicitud.push( {name:'nm_persona1',value: $('input[name="nm_persona1"]').val() });
    solicitud.push( {name:'ap_persona1',value: $('input[name="ap_persona1"]').val() });
    solicitud.push( {name:'tp_documento',value: $('select[name="tp_documento"] option:selected').val() });
    solicitud.push( {name:'nu_documento',value: $('input[name="nu_documento"]').val() });
    solicitud.push( {name:'fe_nacimiento',value: $('input[name="fe_nacimiento"]').val() });
    solicitud.push( {name:'cd_sexo',value: $('select[name="cd_sexo"] option:selected').val() });
    solicitud.push( {name:'cd_estado',value: $('select[name="cd_estado"] option:selected').val() });
    solicitud.push( {name:'cd_municipio',value: $('select[name="cd_municipio"] option:selected').val() });
    solicitud.push( {name:'cd_parroquia',value: $('select[name="cd_parroquia"] option:selected').val() });
    solicitud.push( {name:'de_direccion',value: $('input[name="de_direccion"]').val() });
    solicitud.push( {name:'nu_area',value: $('select[name="nu_area"] option:selected').val() });
    solicitud.push( {name:'nu_telefono',value: $('input[name="nu_telefono"]').val() });
    solicitud.push( {name:'de_correo',value: $('input[name="de_correo"]').val() });
    solicitud.push( {name:'ca_clonacion',value: cantidadDeClonacion });

    solicitud.push( {name:'cd_producto',value: $('select[name="cd_producto"] option:selected').val() });
    solicitud.push( {name:'cd_cobertura',value: $('select[name="cd_cobertura"] option:selected').val() });
    solicitud.push( {name:'cd_cobertura_detalle',value: $('select[name="cd_cobertura_detalle"] option:selected').val() });
    solicitud.push( {name:'cd_plan_pago',value: $('select[name="cd_plan_pago"] option:selected').val() });
    solicitud.push( {name:'cd_grupo_familiar',value: $('select[name="cd_grupo_familiar"] option:selected').val() });
    solicitud.push( {name:'cd_tipo_calculo',value: $('select[name="cd_tipo_calculo"] option:selected').val() });

    solicitud.push( {name:'nm_persona1_asegurado',value: $('input[name="nm_persona1_asegurado"]').val() });
    solicitud.push( {name:'tp_documento_asegurado',value: $('select[name="tp_documento_asegurado"] option:selected').val() });
    solicitud.push( {name:'nu_documento_asegurado',value: $('input[name="nu_documento_asegurado"]').val() });
    solicitud.push( {name:'cd_sexo_asegurado',value: $('select[name="cd_sexo_asegurado"] option:selected').val() });
    solicitud.push( {name:'fe_nacimiento_asegurado',value: $('input[name="fe_nacimiento_asegurado"]').val() });
    solicitud.push( {name:'cd_parentesco_asegurado',value: $('select[name="cd_parentesco_asegurado"] option:selected').val() });
    var tokenLaravel=$('input[name="_token"]').val();
    console.log(cantidadDeClonacion);
    if(cantidadDeClonacion>0){
        for(var a=0;a<cantidadDeClonacion;a++){
            solicitud.push( {name:'cd_parentesco_asegurado'+a,value: $('select[name="cd_parentesco_asegurado'+a+'"]option:selected').val() });
            solicitud.push( {name:'nm_persona1_asegurado'+a,value: $('input[name="nm_persona1_asegurado'+a+'"]').val() });
            solicitud.push( {name:'tp_documento_asegurado'+a,value: $('select[name="tp_documento_asegurado'+a+'"]option:selected').val() });
            solicitud.push( {name:'nu_documento_asegurado'+a,value: $('input[name="nu_documento_asegurado'+a+'"]').val() });
            solicitud.push( {name:'cd_sexo_asegurado'+a,value: $('select[name="cd_sexo_asegurado'+a+'"] option:selected').val() });
            solicitud.push( {name:'fe_nacimiento_asegurado'+a,value: $('input[name="fe_nacimiento_asegurado'+a+'"]').val() });
        }
    }
    var formaPago=$('select[name="cd_forma_pago"] option:selected').val();
    solicitud.push( {name:'cd_forma_pago',value: formaPago});
    solicitud.push( {name:'cd_intermediario',value: $('select[name="cd_intermediario"] option:selected').val() });
    if(formaPago==2){
        solicitud.push( {name:'tp_cuenta',value: $('select[name="tp_cuenta"] option:selected').val() });
        solicitud.push( {name:'nu_cuenta',value: $('input[name="nu_cuenta"]').val() });
        solicitud.push( {name:'nu_documento_domicilio',value: $('input[name="nu_documento_domicilio"]').val() });
        solicitud.push( {name:'tp_documento_domicilio',value: $('select[name="tp_documento_domicilio"] option:selected').val() });
    }
    $.ajax({
        url:'/prevision.procesos.cartera.emision-contrato',
        type:'POST',
        cache:false,
        headers: {'X-CSRF-TOKEN': tokenLaravel},
        data:solicitud
    }).done(function(response){
        console.log(response);
        var JSONParse=JSON.parse(response);
        var contenido=JSONParse.message.content;
    }).fail(function(a,b,c){
        console.log(a,b,c);
    });


}

function fnGenerarPdf(){
    var b64 = 'asdasdasd'; //base64PDF
    var bin = atob(b64);
    console.log('File Size:', Math.round(bin.length / 1024), 'KB');
    console.log('PDF Version:', bin.match(/^.PDF-([0-9.]+)/)[1]);
    console.log('Create Date:', bin.match(/<xmp:CreateDate>(.+?)<\/xmp:CreateDate>/)[1]);
    console.log('Modify Date:', bin.match(/<xmp:ModifyDate>(.+?)<\/xmp:ModifyDate>/)[1]);
    console.log('Creator Tool:', bin.match(/<xmp:CreatorTool>(.+?)<\/xmp:CreatorTool>/)[1]);

    var obj = document.createElement('object');
    obj.style.width = '100%';
    obj.style.height = '100%';
    obj.type = 'application/pdf';
    obj.title = 'Reporte';
    obj.data = 'data:application/pdf;base64,' + b64;
    document.body.appendChild(obj); 
    var ventanaPDF=window.open(
        '',
        "win",
        'width=1000,height=1000,screenX=500,screenY=0,menubar=no'
    );
    ventanaPDF.document.title = "Emision de La Poliza"
    ventanaPDF.document.body.appendChild(obj);
}
/*
function fnGenerarPdficticio(){
    var factura=$('div[id="factura"]').html();
    var ventanaConfirmacion=
    fnAlertDetalleFormulario(factura+'<br>¿Está seguro que desea Emitir la Poliza?','Transacción',);
    ventanaConfirmacion.then((response) =>{
        if(response.isConfirmed){
            fnTransaccionConfirmada('Transaccion','Se ha emitido la Póliza.');
            setInterval(function(){
                console.log('prueba');
                //window.location.replace('/prevision.procesos.cartera.cotizacion');
            },10000);
            console.log(factura);
            const winUrl = URL.createObjectURL(
                new Blob([factura], { type: "text/html" })
            );
            const win = window.open(
                winUrl,
                "win",
                'width=800,height=400,screenX=200,screenY=200'
            );
        }
    });

    
}*/
