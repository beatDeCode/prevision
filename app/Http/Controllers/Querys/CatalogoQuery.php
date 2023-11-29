<?php

namespace App\Http\Controllers\Querys;

class CatalogoQuery{
    //Catalogo Moneda
    const buscarInformacionMonedas="
    select cd_moneda,de_moneda,de_siglas_moneda,case when st_moneda=1 then 'Activo' else 'Inactivo' end st_moneda, 1 updt, 1 delt
    from moneda  
    where 
        case when nvl(:de_moneda,'0')='0' then '0' else de_moneda end
        like case when nvl(:de_moneda,'0')='0' then '0' else '%'||:de_moneda||'%' end
       " ;
    const busquedaUpdateMoneda="
    select cd_moneda,de_moneda,de_siglas_moneda,st_moneda
    from moneda  
    where cd_moneda=:cd_moneda" ;

    const busquedaParaEstatus="
    select 1 value,'Activo' text
    from dual
    union all
    select 0 value,'Inactivo' text
    from dual" ;

    const busquedaSecuenciaMoneda="
        select moneda_seq.nextval secuencia from dual
    ";

    const busquedaSecuenciaContrato="
    select contrato_seq.nextval secuencia from dual
   ";

    const busquedaAreasTelefono="
        select '0424' value, '0424' text from dual
        union all
        select '0414' value, '0414' text from dual
        union all
        select '0412' value, '0412' text from dual
        union all
        select '0416' value, '0416' text from dual
        union all
        select '0426' value, '0426' text from dual
    ";

    //Tipo Documento
    const busquedaTipoDocumento="
       select cd_tipo_documento value, de_tipo_documento text
       from tipodocumento
    ";

    //Estados
    const busquedaEstados="
       select cd_estado value, de_estado text
       from estados
    ";

    //Parroquias
    const busquedaParroquias="
       select cd_parroquia value, de_parroquia text
       from parroquias
       where cd_municipio=:cd_municipio
    ";
    const busquedaParroquiasGeneral="
       select cd_parroquia value, de_parroquia text
       from parroquias
    ";

    //Municipios
    const busquedaMunicipios="
       select cd_municipio value, de_municipio text
       from municipios
       where cd_estado=:cd_estado
    ";

    const busquedaMunicipiosGeneral="
       select cd_municipio value, de_municipio text
       from municipios
    ";

   //Secuencias
   const busquedaSecuenciaPersonas="
        select personas_seq.nextval secuencia from dual
    ";

   const busquedaSecuenciaEmpresas="
      select empresas_seq.nextval secuencia from dual
   ";
   const busquedaSecuenciaPersonaDomiclio="
      select personadomiciliobancario_seq.nextval secuencia from dual
   ";

   //Bancos

   const busquedaBancos="
      select cd_banco value, de_banco text from bancos
   ";

   const busquedaTipoCuenta="
      select 'C' value, 'Corriente' text from dual
      union all
      select 'A' value, 'Ahorro' text from dual
   ";

   //Productos
   const busquedaProductos='select cd_producto value, de_producto text from productos';

   //Coberturas
   const busquedaCoberturas='select cd_cobertura value, de_cobertura text from coberturas
   where cd_producto=:cd_producto';

   //CoberturaDetalle

   const busquedaSumasAseguradas="
      select cd_cobertura_detalle value, de_cobertura_detalle text 
      from coberturadetalle cobe
      where cd_cobertura=:cd_cobertura
      order by mt_suma_asegurada";

   const busquedaGruposFamiliares="select cd_grupo_familiar value, de_grupo_familiar text from gruposfamiliares";

   const busquedaTipoCalculoPrima="
   select 1 value, 'Cálculo Por Tasa Riesgo' text from dual
   union all
   select 2 value, 'Cálculo Por Prima' text from dual";


   //Parentescos
   const busquedaParentescos='select cd_parentesco value, de_parentesco text from parentescos where cd_parentesco!=1';

   //Sexos

   const busquedaSexos='select cd_sexo value, de_sexo text from sexos ';

   //Planes Pago

   const busquedaPlanesPago='select cd_plan_pago value, de_plan_pago text from planespago';

   //Formas de pago

   const busquedaFormasPago="select 1 value, 'Efectivo' text from dual union all select 2 value, 'Domiciliacion' text from dual";

   //Intermediarios
   const busquedaIntermediarios="select 1 value, 'Directo' text from dual";
}
