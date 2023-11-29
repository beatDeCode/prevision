select * from (
select
    count (1),
    pcer.nu_poliza,
    trunc(sysdate) fe_campania,
    eco.FE_ANULACION operador,
    reci.cd_recibo,
    extract( month from (select max(fe_valor) 
    from SIR.POLIZACERTIFICADOMOVCTA pcre, SIR.POLIZACERTIFICADORECIBOMOVCTA pcrm
    where pcre.CD_AREA = pcrm.CD_AREA
    and pcre.CD_ENTIDAD = pcrm.CD_ENTIDAD
    and pcre.NU_CERTIFICADO = pcrm.NU_CERTIFICADO
    and pcre.NU_POLIZA = pcrm.NU_POLIZA
    and pcrm.CD_RECIBO=reci.cd_recibo
    )) mes,
    
    case when st_recibo=1 then 'Pendiente' else 'Pagado'end estatus,
    reci.MT_RECIBO,
    (select to_char(pcen.FE_REGISTRO,'dd/mm/yyyy') from polizacertificadoendoso pcen
    where nu_poliza=pcer.nu_poliza
    and cd_area=pcer.cd_area
    and cd_entidad=pcer.cd_entidad
    and nu_certificado=pcer.nu_certificado
    and nu_endoso=pcer.nu_ultimo_endoso) fe_operacion,
    to_char((select max(fe_valor) 
    from SIR.POLIZACERTIFICADOMOVCTA pcre, SIR.POLIZACERTIFICADORECIBOMOVCTA pcrm
    where pcre.CD_AREA = pcrm.CD_AREA
    and pcre.CD_ENTIDAD = pcrm.CD_ENTIDAD
    and pcre.NU_CERTIFICADO = pcrm.NU_CERTIFICADO
    and pcre.NU_POLIZA = pcrm.NU_POLIZA
    and pcrm.CD_RECIBO=reci.cd_recibo
    ),'dd/mm/yyyy')fe_cobro
    
   
from 
polizacertificado pcer, 
ECOSISTEMAS.POLIZAFECHA eco,
sir.recibo reci,
SIR.POLIZACERTIFICADOMOVCTA pcre

where eco.NU_POLIZA = pcer.NU_POLIZA
and pcer.ST_CERTIFICADO=1
and reci.CD_AREA = pcer.CD_AREA
and reci.NU_POLIZA = pcer.NU_POLIZA
and reci.cd_entidad=pcer.cd_entidad
and reci.ST_RECIBO in (4)
and pcre.CD_AREA = reci.CD_AREA
and pcre.CD_ENTIDAD = reci.CD_ENTIDAD
and pcre.NU_CERTIFICADO = reci.NU_CERTIFICADO
and pcre.NU_POLIZA = reci.NU_POLIZA
and fe_valor between :fea and :feb
group by 
pcer.nu_poliza,
    eco.FE_ANULACION,
    reci.cd_recibo,
    st_recibo,
    reci.MT_RECIBO,
    pcer.nu_poliza,
    pcer.cd_area,
    pcer.cd_entidad,
    pcer.nu_certificado,
    pcer.nu_ultimo_endoso,
    reci.fe_desde
union all
select
    1 a, 
    pcer.nu_poliza,
    trunc(sysdate) fe_campania,
    eco.FE_ANULACION operador,
    reci.cd_recibo,
    extract( month from reci.fe_desde) mes,
    case when st_recibo=1 then 'Pendiente' else 'Pagado'end estatus,
    reci.MT_RECIBO,
    (select to_char(pcen.FE_REGISTRO,'dd/mm/yyyy') from polizacertificadoendoso pcen
    where nu_poliza=pcer.nu_poliza
    and cd_area=pcer.cd_area
    and cd_entidad=pcer.cd_entidad
    and nu_certificado=pcer.nu_certificado
    and nu_endoso=pcer.nu_ultimo_endoso) fe_operacion,
    '' fe_cobro
    
   
from 
polizacertificado pcer, 
ECOSISTEMAS.POLIZAFECHA eco,
sir.recibo reci
where eco.NU_POLIZA = pcer.NU_POLIZA
and pcer.ST_CERTIFICADO=1
and reci.CD_AREA = pcer.CD_AREA
and reci.NU_POLIZA = pcer.NU_POLIZA
and reci.cd_entidad=pcer.cd_entidad
and reci.ST_RECIBO in (1)
and reci.fe_desde between to_date('01/01/2023','dd/mm/yyyy') and :feb
)
order by nu_poliza,cd_recibo
;




