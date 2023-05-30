<?php
require_once 'generadorIdPedido.php';
require_once 'generadorNumPedido.php';
require_once 'cuponDescuento.php';
class Venta
{
    private $mail;
    private $sabor;
    private $tipo;
    private $stock;
    private $vaso;
    private $numeroPedido;
    private $id;
    private $fecha;
    public function GuardarImagenVenta()
    {    
        $nombre_usuario = substr($this->mail, 0, strpos($this->mail, '@')); 
        $nombre_imagen =  $this->sabor . '_' . $this->tipo . '_' . $this->vaso . '_' . $nombre_usuario . '_' . date('Y-m-d_H-i-s') . '.jpg';
        $ruta_destino = 'C:/xampp/htdocs/PrimerParcial/ImagenesDeLaVenta/' . $nombre_imagen;
    
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) 
        {
            echo "La imagen se ha guardado correctamente como: " . $nombre_imagen;
        } else 
        {
            echo "Error al guardar la imagen.";
        }
    }


    public static function GuardarImagenDevolucion()
    {    

        $nombre_imagen =  date('Y-m-d_H-i-s') . '.jpg';
        $ruta_destino = 'C:/xampp/htdocs/PrimerParcial/ClienteEnojado/' . $nombre_imagen;
        $retorno=false;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) 
        {
            $retorno=true;
        }
        return $retorno;
    }

    public function __construct($mail, $sabor, $tipo, $stock, $vaso)
    {
        $this->numeroPedido =GeneradorNumeroPedido::generarNumeroPedido();
        $this->id = IdGeneratorPedido::generateId();
        $this->fecha = (new DateTime())->format('Y-m-d');
        $this->mail = $mail;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->stock = $stock;
        $this->vaso = $vaso;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getSabor()
    {
        return $this->sabor;
    }

    public function setSabor($sabor)
    {
        $this->sabor = $sabor;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getFecha()
    {
        return $this->fecha;
    }


    public function getNumeroPedido()
    {
        return $this->numeroPedido;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getVaso()
    {
        return $this->vaso;
    }

    public function setVaso($vaso)
    {
        $this->vaso = $vaso;
    }


    public static function ConvertirAJson($ventas)
    {
        $datos = array();
        foreach ($ventas as $venta) {
            $ventaDatos = array(
                "mail" => $venta->getMail(),
                "numeroPedido" => $venta->getNumeroPedido(),
                "sabor" => $venta->getSabor(),
                "tipo" => $venta->getTipo(),
                "stock" => intval($venta->getStock()),
                "vaso" => $venta->getVaso(),
                "fecha" => $venta->getFecha(),
            );
            $datos[] = $ventaDatos;
        }
        return json_encode($datos);
    }

public static function LeerJson($ruta)
{
    $data = file_get_contents($ruta);
    $ventasJson = json_decode($data, true);
    $ventas = array();

    if (is_array($ventasJson)) {
        foreach ($ventasJson as $ventaData) {
            $venta = new Venta(
                $ventaData['mail'],
                $ventaData['sabor'],
                $ventaData['tipo'],
                $ventaData['stock'],
                $ventaData['vaso']
            );
            array_push($ventas, $venta);
        }
    }

    return $ventas;
}

public static function GuardarJson($ventas)
{
    $archivo = "venta.json";
    $json = Venta::ConvertirAJson($ventas);
    $archivo = fopen($archivo, "w");
    fwrite($archivo, $json);
    fclose($archivo);
}
public static function ModificarVenta($numeroPedido, $email, $sabor, $tipo, $vaso, $cantidad)
{
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);
    $retorno = false;

    foreach ($VentasGuardadas as $indice => $venta) {
        if ($venta->getNumeroPedido() == $numeroPedido) {
            $venta->setSabor($sabor);
            $venta->setMail($email);
            $venta->setTipo($tipo);
            $venta->setVaso($vaso);
            $venta->setStock($cantidad);
            $retorno = true;
            break;
        }
    }
        Venta::GuardarJson($VentasGuardadas, $archivo);
    return $retorno;
}

public function __toString()
{
    return "Número de pedido: " . $this->numeroPedido . "\n" .
           "ID: " . $this->id . "\n" .
           "Fecha: " . $this->fecha . "\n" .
           "Correo electrónico: " . $this->mail . "\n" .
           "Sabor: " . $this->sabor . "\n" .
           "Tipo: " . $this->tipo . "\n" .
           "Stock: " . $this->stock . "\n" .
           "Vaso: " . $this->vaso . "\n";
}

public static function MostrarVentas($fecha){
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);

    foreach($VentasGuardadas as $venta){
        if($venta->getFecha() == $fecha){
         
           echo $venta->__toString();
        }
    }
}

public static function ExitVenta($numeroPedido){
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);
    $retorno = false;
    foreach($VentasGuardadas as $venta){
        if($venta->getNumeroPedido() == $numeroPedido){
            $retorno = true;
        }
    }
    return $retorno;
}



public static function MostrarVentasXUsuario($usuario){
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);

    foreach($VentasGuardadas as $venta){
        if($venta->getMail() == $usuario){
           echo $venta->__toString() . "\n" ;
        }
    }
}

public static function MostrarVentasXSabor($saborIngreasdo){
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);

    foreach($VentasGuardadas as $venta){
        if($venta->getSabor() == $saborIngreasdo){
           echo $venta->__toString() . "\n" ;
        }
    }
}
public static function MostrarVentasCucurucho(){
    $archivo = "venta.json";
    $VentasGuardadas = Venta::LeerJson($archivo);

    foreach($VentasGuardadas as $venta){
        if(strcasecmp($venta->getVaso(), "cucurucho") == 0){
           echo $venta->__toString() . "\n";
        }
    }
}

public static function DevolverVenta($numeroPedido, $motivoDevolucion){
    $cuponDescuento;
    $retorno = false;

    if(Venta::ExitVenta($numeroPedido)){
        if(Venta::GuardarImagenDevolucion()){
            $cuponDescuento = new CuponDescuento($numeroPedido, false);
            //echo($cuponDescuento->__toString());
            CuponDescuento::GuardarJson($cuponDescuento);
            $retorno = true;
        }
    }

    return $retorno;
}
}
?>
