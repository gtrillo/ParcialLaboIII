<?php
require_once 'venta.php';
$fecha = $_GET['fecha'];

$usuario = $_GET['usuario'];
$saborIngresado = $_GET['saborIngresado'];

echo("VENTAS POR FECHA INGRESADA\n");
Venta::MostrarVentas($fecha);

echo("VENTAS POR USUARIO INGRESADO\n");
Venta::MostrarVentasXUsuario($usuario);

echo("VENTAS POR USUARIO SABOR INGRESADO\n");
Venta::MostrarVentasXSabor($saborIngresado);

echo("VENTAS SOLO DE CUCURUCHO\n");
Venta::MostrarVentasCucurucho();
?>