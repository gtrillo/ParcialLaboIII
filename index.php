<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['accion'])) {
        $accion = $_GET['accion'];
        switch ($accion) {
            case 'consulta':
                include 'consultaVentas.php';
                break;
        }
    } 
} elseif ($method === 'POST' || $method === 'PUT') {
    if (isset($_POST['accion']) || isset($_POST['_method'])) {
        $accion = isset($_POST['_method']) ? $_POST['_method'] : $_POST['accion'];

        if ($accion === 'modificacion') {
            include 'ModificarVenta.php';
        } else {
            switch ($accion) {
                case 'alta':
                    include 'HeladeriaAlta.php';
                    break;
                case 'validacion':
                    // Código para el caso de validación
                    break;
                case 'venta':
                    include 'altaVenta.php';
                    break;
                case 'devolucion':
                    include 'DevolverHelado.php';
                    break;    
            }
        }
    }
}
?>
