<?php

namespace App\Http\Controllers\Querys;

class AutenticacionQuery{

    const validarCredencialesUsuario='
    select 
        count(1) cuenta,
        cd_usuario,
        (select cd_rol
        from usuariorol usro where cd_usuario=usua.cd_usuario)cd_rol,
        (select (select upper(de_rol) from roles where cd_rol=usro.cd_rol) 
        from usuariorol usro where cd_usuario=usua.cd_usuario) de_rol,
        (select nm_completo from personas where cd_persona=usua.cd_persona) nm_completo
    from usuarios usua
    where upper(cd_usuario)=:cd_usuario
    and de_clave=:de_clave
    group by cd_usuario,cd_persona
    ';

    const menusPadrePorUsuario='
    select * from (
        select
            (select de_menu from menus where cd_menu=s1.cd_menu_padre) de_menu,
            (select cd_menu from menus where cd_menu=s1.cd_menu_padre) cd_menu,
            (select de_icono_menu from menus where cd_menu=s1.cd_menu_padre) de_icono_menu,
            (select cd_orden_menu from menus where cd_menu=s1.cd_menu_padre)cd_orden_menu
        from (
            select
                cd_menu_padre,count(1)
            from usuariorol usro ,menurol mero, menus menu
            where usro.cd_rol=mero.cd_rol
            and mero.cd_menu=menu.cd_menu
            and cd_usuario=:cd_usuario
            group by cd_menu_padre
        )s1
    )s2
    order by cd_orden_menu
    ';

    const menusPorUsuario='
    select
        menu.cd_menu,menu.de_menu,menu.de_enlace_menu
    from usuariorol usro ,menurol mero, menus menu
    where usro.cd_rol=mero.cd_rol
    and mero.cd_menu=menu.cd_menu
    and cd_menu_padre=:cd_menu_padre
    and cd_usuario=:cd_usuario
    ';



       
    
}
