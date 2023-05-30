<?php
require_once 'helado.php';
require_once 'venta.php';
$numeroPedido = $_POST['numeroPedido'];
$motivoDevolucion = $_POST['motivoDevolucion'];

if(Venta::DevolverVenta($numeroPedido,$motivoDevolucion)){
    echo("Se ha generado una nueva devolucion");
}

?>