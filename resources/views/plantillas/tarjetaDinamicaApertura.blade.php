<?php 
        $tarjetaElementos=explode('|',$tarjeta[0]);
?>
<div class="card" id="tarjeta-{{$tarjetaElementos[0]}}">
    <div class="badge" style="background-color:#184069;color:white;">
        {{$tarjetaElementos[1]}}
    </div>
    <br>