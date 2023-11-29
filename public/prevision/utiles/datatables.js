function fnConfiguracionDataTable(){
    var vDatatable={
        "lengthChange": true,
        "bInfo": false,
        "searching":false,
        "language": {
          "emptyTable": "No existen registros para mostrar",
          "search":"Filtar por palabra:",
          "paginate": {
              "previous": "Anterior",
              "next":"Siguiente"
            }
        },
        "bAutoWidth": false,
        "ordering": true,
        "pageLength": 6,
        "columnDefs":[
            {targets: '_all',className: 'dt-body-center'}
        ]
        
    };
    return vDatatable;
}
function fnTablaDinamica(){
    
    var tokenLaravel=$('input[name="_token"]').val();
    var nombreDivTabla=$('input[name="nombre-div"]').val();
    var nombreTabla=$('input[name="nombre-tabla"]').val();
    var camposTabla=$('input[name="campos-tabla"]').val();
    var indicesTabla=$('input[name="indices-tabla"]').val();
    var queryBusqueda=$('input[name="query-tabla"]').val();
    var tpquery=$('input[name="tipo-query"]').val();
    var formularioTabla=$('input[name="formulario-tabla"]').val();
    var clavePrincipal=$('input[name="clave-principal"]').val();
    var formulario=$('form[name="'+formularioTabla+'"]').serializeArray();
    formulario.push({'name':'query','value':queryBusqueda});
    formulario.push({'name':'tp_query','value':tpquery});

    var valoresCabecera=camposTabla.split(',');
    var tabla=fnConstruccionCabeceraTabla(valoresCabecera,nombreTabla);
    $.ajax({
        url:'/prevision.general.querys',
        type:'POST',
        cache:false,
        headers: {'X-CSRF-TOKEN': tokenLaravel},
        data:formulario
    }).done(function(response){
        var JSONParse=JSON.parse(response);

        if(JSONParse.httpResponse==200){
            var divTabla=$('div[id="'+nombreDivTabla+'"]');
            divTabla.html('');
            divTabla.append(tabla);
            var configuracionDataTable=$('table[id="'+nombreTabla+'"]');
            var datatable=configuracionDataTable.DataTable(fnConfiguracionDataTable());
            var valoresCuerpo=JSONParse.message.content;
            var valoresIndiceTabla=indicesTabla.split(',');
            var elementosDatatable=[];
            console.log(valoresCuerpo);
            for(var a=0;a<valoresCuerpo.length;a++){
                for(var b=0;b<valoresIndiceTabla.length;b++){
                    elementosDatatable.push(valoresCuerpo[a][valoresIndiceTabla[b]]);
                }
                var botonActualizar='';
                var botonEliminar="";
                if(valoresCuerpo[a]['updt']==1){
                    botonActualizar=
                    '<button type="button" class="btn btn-info btn-icon" onclick="fnRedigirirLink(\''+valoresCuerpo[a][clavePrincipal]+'\',1)">'+
                        '<i class="typcn typcn-th-menu"></i>'+
                    '</button>';
                }
                if(valoresCuerpo[a]['delt']==1){
                    botonEliminar=
                    '<button type="button" class="btn btn-success btn-icon" onclick="fnRedigirirLink(\''+valoresCuerpo[a][clavePrincipal]+'\',2)">'+
                        '<i class="typcn typcn-times"></i>'+
                    '</button>';
                }
                elementosDatatable.push(botonActualizar+' '+botonEliminar);
                datatable.row.add(elementosDatatable)
                    .draw(false);
                elementosDatatable=[];
            }
        }else{
            fnToastAutenticacionFallida('Hubo un error al procesa la consulta...');
        }
    }).fail(function(a,b,c){
        fnToastAutenticacionFallida('Existe un error en el servidor..');
        console.log(a,b,c);
    });
}

function fnConstruccionCabeceraTabla(valoresCabecera,nombreTabla){
    var cabecera='';
    for(var a=0;a<valoresCabecera.length;a++){
        cabecera+='<th style="font-size:12px;"><center>'+valoresCabecera[a]+'</center></th>';
    }
    var tabla=
    '<div class="table table-responsive" style="font-size:12px;">'+
    '<table class="table table-striped display" style="width:100%" id="'+nombreTabla+'" >'+
        '<thead>'+
        '<tr>'+
            cabecera+
        '</tr>'+
        '</thead>'+
    '</table>'+
    '</div>';
    return tabla;
}

function fnRedigirirLink(clavePrincipal,transaccion){
    if(transaccion==1){
        var linkUpdate=$('input[name="link-update"]').val();
        setInterval(
            window.location.replace(linkUpdate+'/'+clavePrincipal),
            750
            );
    }
}

function fnCargarDataTablesSinData(){
    var nombreDivTabla=$('input[name="nombre-div"]').val();
    var nombreTabla=$('input[name="nombre-tabla"]').val();
    console.log(nombreTabla,nombreDivTabla);
    var tabla=fnConstruccionCabeceraTabla(['Informaci&oacute;n'],nombreTabla);
    var divTabla=$('div[id="'+nombreDivTabla+'"]');
    divTabla.html('');
    divTabla.append(tabla);
    var configuracionDataTable=$('table[id="'+nombreTabla+'"]');
    var datatable=configuracionDataTable.DataTable(fnConfiguracionDataTable());
    datatable.row.add(['No existe informaci&oacute;n para mostrar.']).draw(false);
}
fnCargarDataTablesSinData();

