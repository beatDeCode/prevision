function fnAlertaDeEspera(){
    var alerta=
    Swal.fire({
        html: ' <center><div class="loader-dots"></div></center> <br> <center><h5>Autenticando Credenciales...</h5></center>',
        showConfirmButton:false,
        allowOutsideClick: false
      });
    return alerta;
}
function fnToastAutenticacionFallida(mensaje){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'error',
        title: mensaje
      })
}

function fnSweetAlertParaValidar(formulario){
  var htmlConValoresValidacion='';
  for(var a=0;a<formulario.length;a++ ){
    var labelInput=$('label[id="'+formulario[a]['name']+'"]').html();
    var valorInput=fnRetornarValorFormulario(formulario[a]['name']);
      if(labelInput && formulario[a]['value']){

        htmlConValoresValidacion+=
        '<div class="form-group col-md-3" style="font-size:14px;">'+
          '<label for="exampleInputUsername1"><b>'+labelInput+'</b></label>'+
          fnChequeUndefined(valorInput)+'<hr>'+
          //'<input type="text" class="form-control" value="'+valorInput+'" disabled>'+
          '</div>'
        ;
      }
    
    
  } 
  return '<div class="row">'+htmlConValoresValidacion+'</div>';
}

function fnChequeUndefined(valor){
  var retorno= '<p style="color:red">E/C (Campo vacío)</p>' ;
  if(valor){
    retorno='<p>'+valor+'</p>';
  }
  return retorno;
};
function fnAlertDetalleFormulario(html,titulo){
  var alerta=
  Swal.fire({
      html: ' <center></div></center> <br> <center><h5>Detalle de '+titulo+' </h5></center> <hr><div class="container-fluid">'+html+'</div>',
      showConfirmButton:true,
      confirmButtonText:'Validar',
      showDenyButton:true,
      customClass:'swal-wide',
      denyButtonText:'Volver',
      allowOutsideClick: false
    });
  return alerta;
}

function fnRetornarValorFormulario(nombreInput){
  var retorno='';
  var valorSelect=$('select[name="'+nombreInput+'"] option:selected').html();
  var valorInput=$('input[name="'+nombreInput+'"]').val();
  if(valorSelect){
    retorno=valorSelect;
  }else{
    retorno=valorInput;
  }
  return retorno;
}

function fnAlertaDeEsperaTransccion(){
  var alerta=
  Swal.fire({
      html: ' <center><div class="loader-dots"></div></center> <br> <center><h5>Realizando Traansaci&oacute;n...</h5></center>',
      showConfirmButton:false,
      allowOutsideClick: false
    });
  return alerta;
}
function fnTransaccionConfirmada(titulo,mensaje){
  var alerta=
  Swal.fire({
    title: titulo,
    text: mensaje,
    icon: "success",
    showCancelButton: false,
    showConfirmButton:false,
  });
  return alerta;
}
