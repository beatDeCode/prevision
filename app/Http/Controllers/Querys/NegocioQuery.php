<?php

namespace App\Http\Controllers\Querys;

use App\Http\Controllers\Controller;

class NegocioQuery{
    const busquedaInformacionEmpresas="
    select 
        pers.NM_COMPLETO,
        pers.tp_documento||'-'||pers.nu_documento nu_documento,
        pers.FE_REGISTRO,
        empr.CD_ASOPROINFU,
        empr.CD_EMPRESA,
        empr.IN_ASOPROINFU,
        empr.ST_EMPRESA,
        1 updt,
        1 chck,
        1 delt
    from empresas empr,
    personas pers
    where empr.CD_PERSONA = pers.CD_PERSONA
    and
    case when nvl(:nu_documento,'0')='0' then '0' else nu_documento end
    like case when nvl(:nu_documento,'0')='0' then '0' else '%'||:nu_documento||'%' end 
    ";

    const busquedaUpdateEmpresas='
    select 
        pers.cd_persona,
        pers.nm_completo,
        pers.tp_documento,
        pers.nu_documento,
        empr.cd_empresa,
        empr.in_asoproinfu,
        empr.cd_asoproinfu,
        empr.st_empresa,
        pete.nu_area,
        pete.nu_telefono,
        peco.de_correo,
        pedi.cd_estado,
        pedi.cd_municipio,
        pedi.cd_parroquia,
        pedi.de_direccion
        
    from empresas empr,
    personas pers,
    personatelefono pete,
    personacorreo peco,
    personadireccion pedi
    where empr.cd_persona=:cd_empresa
    and empr.CD_PERSONA = pers.CD_PERSONA
    and pete.cd_persona=pers.cd_persona
    and peco.cd_persona=pers.cd_persona
    and pedi.cd_persona=pers.cd_persona
   
    ';

    const busquedaValidacionDocumento=
    "select case when cuenta>0 then 'El documento '||:nu_documento||' ya posee una poliza ' else '0' end text
    from (
    select count(1) cuenta
    from personas
    where nu_documento=:nu_documento)";

    const busquedaEdadEntreFechas="
        select trunc(months_between(trunc(sysdate),to_date(:fe_nacimiento,'yyyy/mm/dd'))/12) text from dual
    ";
    const procesoCotizacionPorPrima="
    select 
        (select de_cobertura_detalle from coberturadetalle
        where cd_cobertura_detalle=:mt_suma_asegurada
        ) de_cobertura_detalle,
        (select de_parentesco from parentescos
        where cd_parentesco=:cd_parentesco)parentesco,
        tasa_riesgo,
        (select de_plan_pago from planespago
                where cd_plan_pago=:cd_plan_pago) plan_pago,
        case when es_calcuble=1
        then 
            round(to_number(:mt_prima),3)
        else 0 end mt_prima,
        mt_suma_asegurada,
        nvl(case when es_calcuble=1
        then   
            round(to_number(:mt_prima)/
            (select ca_recibos from planpagodetalle
                where cd_plan_pago=:cd_plan_pago),3)
        else 0 end,0) mt_prima_plan,
        siglas_moneda,
        :tp_documento||'-'||:nu_documento nu_documento,
        :nm_persona1||' '||:ap_persona1 nm_completo,
        (select de_grupo_familiar from gruposfamiliares
        where cd_grupo_familiar=:cd_grupo_familiar)grupo_familiar,
        (select de_producto from productos
        where cd_producto=:cd_producto)producto,
        es_adicional
        from (
            select 
            case when cuenta>0
            then case when :cd_parentesco=1 then 1 else 0 end else 1 end es_calcuble,
            case when cuenta>0
            then 'No' else 'Si' end es_adicional,
            case when cuenta>0
            then
                case when :cd_parentesco=1
                then
                    (select po_tasa_riesgo from productotasariesgo
                    where cd_producto=:cd_producto
                    and cd_grupo_familiar=:cd_grupo_familiar)
                else
                    0
                end
            else
                1.78
            end
            tasa_riesgo,
            (select mt_suma_asegurada from coberturadetalle
            where cd_cobertura_detalle=:mt_suma_asegurada
            )mt_suma_asegurada,
            '$' siglas_moneda
        from (
            select 
                (select count(1) from grupofamiliarparentesco
            where cd_parentesco=:cd_parentesco
            and cd_grupo_familiar=:cd_grupo_familiar) cuenta
            from dual
        )a1
    )a2  
    ";
    const procesoCotizacion="
    select 
        (select de_cobertura_detalle from coberturadetalle
        where cd_cobertura_detalle=:mt_suma_asegurada
        )   de_cobertura_detalle,
        (select de_parentesco from parentescos
        where cd_parentesco=:cd_parentesco)parentesco,
        tasa_riesgo,
        (select de_plan_pago from planespago
                where cd_plan_pago=:cd_plan_pago) plan_pago,
        case when es_calcuble=1
        then 
            round(((tasa_riesgo*mt_suma_asegurada)/100),3)
        else 0 end mt_prima,
        mt_suma_asegurada,
        nvl(case when es_calcuble=1
        then   
            round(((tasa_riesgo*mt_suma_asegurada)/100)/
            (select ca_recibos from planpagodetalle
                where cd_plan_pago=:cd_plan_pago),3)
        else 0 end,0) mt_prima_plan,
        siglas_moneda,
        :tp_documento||'-'||:nu_documento nu_documento,
        :nm_persona1||' '||:ap_persona1 nm_completo,
        (select de_grupo_familiar from gruposfamiliares
        where cd_grupo_familiar=:cd_grupo_familiar)grupo_familiar,
        (select de_producto from productos
        where cd_producto=:cd_producto)producto,
        es_adicional,
        :mt_prima mt_prima_aux
        from (
            select 
            case when cuenta>0
            then case when :cd_parentesco=1 then 1 else 0 end else 1 end es_calcuble,
            case when cuenta>0
            then 'No' else 'Si' end es_adicional,
            case when cuenta>0
            then
                case when :cd_parentesco=1
                then
                    (select po_tasa_riesgo from productotasariesgo
                    where cd_producto=:cd_producto
                    and cd_grupo_familiar=:cd_grupo_familiar)
                else
                    0
                end
            else
                1.78
            end
            tasa_riesgo,
            (select mt_suma_asegurada from coberturadetalle
            where cd_cobertura_detalle=:mt_suma_asegurada
            )mt_suma_asegurada,
            (select
            (select de_siglas_moneda from moneda where cd_moneda=code.cd_moneda) 
            from coberturadetalle code
            where cd_cobertura_detalle=:mt_suma_asegurada
            )siglas_moneda
        from (
            select 
                (select count(1) from grupofamiliarparentesco
            where cd_parentesco=:cd_parentesco
            and cd_grupo_familiar=:cd_grupo_familiar) cuenta
            from dual
        )a1
    )a2
    ";

    const busquedaDocumentoContrato="
        select :cd_input value, cuenta, 
            case when cuenta>0 then
            'El Documento '|| :nu_documento || ' Posee una póliza vigente.'
            else '' end error from (
            select count(1) cuenta
            from personas pers, contrato cont
            where cd_persona_asegurada=pers.cd_persona
            and pers.nu_documento=:nu_documento
            and cont.cd_producto=:cd_producto
        )
    ";

    const busquedaCodigoVerificadorBanco='select count(1) cuenta from bancos where cd_verificador=substr( :nu_cuenta ,1,4)';

    const busquedaInformacionContrato='
    select 
        (select ca_recibos from planpagodetalle ppde where ppde.cd_plan_pago=ccen.CD_PLAN_PAGO ) ca_recibo,
        (select nu_meses_recibo from planpagodetalle ppde where ppde.cd_plan_pago=ccen.CD_PLAN_PAGO ) nu_meses_recibo,
        round((
        ((select mt_suma_asegurada from coberturadetalle where cd_cobertura_detalle=ccen.cd_cobertura_detalle ) *
        (select po_tasa_riesgo from productotasariesgo where cd_producto=ccen.cd_producto and cd_grupo_familiar=ccen.cd_grupo_familiar) )
        /100
        )/(select ca_recibos from planpagodetalle ppde where ppde.cd_plan_pago=ccen.CD_PLAN_PAGO ),2) mt_prima_recibo,
        ccer.nu_certificado,
        ccer.cd_producto,
        ccen.nu_endoso,
        ccer.nu_contrato
    from prevision.contrato cont, PREVISION.CONTRATOCERTIFICADO ccer, PREVISION.CONTRATOCERTIFICADOENDOSO ccen
    where cont.nu_contrato=:cd_contrato
    and cont.CD_EMPRESA = ccer.CD_EMPRESA
    and cont.CD_PRODUCTO = ccer.CD_PRODUCTO
    and cont.NU_CONTRATO = ccer.NU_CONTRATO
    and ccer.CD_EMPRESA = ccen.CD_EMPRESA
    and ccer.NU_CERTIFICADO = ccen.NU_CERTIFICADO
    and ccer.NU_CONTRATO = ccen.NU_CONTRATO
    and ccer.NU_ULTIMO_ENDOSO=ccen.NU_ENDOSO';
}
