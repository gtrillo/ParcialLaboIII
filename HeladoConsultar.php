<?php
require_once 'helado.php';
$sabor = $_POST['sabor'];
$tipo = $_POST['tipo'];

if(Helado:: ExisteHelado($sabor,$tipo) == 1){
    echo("existe");
}else if (Helado:: ExisteHelado($sabor,$tipo) == 0){
    echo("existe gusto");
}else if (Helado:: ExisteHelado($sabor,$tipo) == 0){
    echo("existe tipo");
}else{
    echo("no existe");
}

?>