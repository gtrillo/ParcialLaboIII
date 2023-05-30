<?php
/*B- (1 pt.) HeladeriaAlta.php: (por POST) se ingresa Sabor, Precio, Tipo (“Agua” o “Crema”), Vaso (“Cucurucho”,
“Plástico”), Stock(unidades).
Se guardan los datos en en el archivo de texto heladeria.json, tomando un id autoincremental como
identificador(emulado) .Sí el nombre y tipo ya existen , se actualiza el precio y se suma al stock existente.
completar el alta con imagen del helado, guardando la imagen con el sabor y tipo como identificación en la
carpeta /ImagenesDeHelados/2023. */
require_once 'helado.php';

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$vaso = $_POST['vaso'];
$stock = $_POST['stock'];


$nuevoHelado = new Helado($sabor, $precio, $tipo, $vaso, $stock);




if(Helado::actualizarHelado($nuevoHelado)){
    echo ("El helado ya existe se han actualizado precios y cantidades"); 
    $nuevoHelado->GuardarImagenVenta(); 
}else{
    echo ("Helado dado de alta correctamente"); 
    Helado::GuardarJson($nuevoHelado);
    $nuevoHelado->GuardarImagenVenta(); 
}



?>
