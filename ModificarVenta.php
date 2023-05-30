<?php
require_once 'helado.php';
require_once 'venta.php';

parse_str(file_get_contents('php://input'), $_PUT);

$numeroPedido = $_POST['numeroPedido'];
$email = $_POST['email'];
$sabor = $_POST['sabor'];
$vaso = $_POST['vaso'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];


if (Venta::ModificarVenta($numeroPedido, $email, $sabor, $tipo, $vaso, $cantidad)) {
    echo("Venta modificada con éxito");
} else {
    echo("El número de pedido no existe");
}
?>
