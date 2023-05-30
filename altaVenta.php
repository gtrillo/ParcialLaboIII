<?php
require_once 'helado.php';
require_once 'venta.php';

$mail = $_POST['mail'];
$sabor = $_POST['sabor'];
$tipo = $_POST['tipo'];
$stock = $_POST['stock'];
$vaso = $_POST['vaso'];

echo("entre");
if (Helado::ExisteHelado($sabor, $tipo)) {
    
    $venta = new Venta($mail, $sabor, $tipo, $stock,$vaso);
    Helado::DescontarStock($sabor, $tipo, $stock);
    Venta::GuardarJson($venta);
    echo "la venta se ha generado correctamente muchas gracias!";
    $venta->GuardarImagenVenta();
} else {
    echo "No se puede realizar el pedido. La pizza seleccionada no existe.";
}
?>
