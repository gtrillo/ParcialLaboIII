<?php
/*B- (1 pt.) HeladeriaAlta.php: (por POST) se ingresa Sabor, Precio, Tipo (“Agua” o “Crema”), Vaso (“Cucurucho”,
“Plástico”), Stock(unidades).
Se guardan los datos en en el archivo de texto heladeria.json, tomando un id autoincremental como
identificador(emulado) .Sí el nombre y tipo ya existen , se actualiza el precio y se suma al stock existente.
completar el alta con imagen del helado, guardando la imagen con el sabor y tipo como identificación en la
carpeta /ImagenesDeHelados/2023. */
include 'generadorId.php';
class Helado
{
    private $id;
    private $sabor;
    private $precio;
    private $tipo;
    private $vaso;
    private $stock;



    public function GuardarImagenVenta()
    {    
        $nombre_imagen =  $this->tipo . '_' . $this->sabor . '.jpg';
        $ruta_destino = 'C:/xampp/htdocs/SimulacroPrimerParcial/ImagenesDeHelados/' . $nombre_imagen;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) 
        {
            echo "La imagen se ha guardado correctamente como: " . $nombre_imagen;
        } else 
        {
            echo "Error al guardar la imagen.";
        }
    }


    public function __construct($sabor, $precio, $tipo, $vaso, $stock)
    {
        $this->id = IdGenerator::generateId();
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->vaso = $vaso;
        $this->stock = $stock;
    }

    public static function ConvertirAJson($helados)
{
    $datos = array();
    foreach ($helados as $helado) {
        $heladoDatos = array(
            "id" => $helado->getId(),
            "sabor" => $helado->getSabor(),
            "precio" => (float) $helado->getPrecio(),
            "tipo" => $helado->getTipo(),
            "vaso" => $helado->getVaso(),
            "stock" => (int) $helado->getStock()
        );
        $datos[] = $heladoDatos;
    }
    return json_encode($datos);
}

public static function LeerJson($ruta)
{
    $data = file_get_contents($ruta);
    $heladosJson = json_decode($data, true);
    $helados = array();

    if (is_array($heladosJson)) {
        foreach ($heladosJson as $heladoData) {
            $helado = new Helado(
                $heladoData['sabor'],
                $heladoData['precio'],
                $heladoData['tipo'],
                $heladoData['vaso'],
                $heladoData['stock']
            );
            array_push($helados, $helado);
        }
    }

    return $helados;
}

    public static function GuardarJson($helado)
    {
        $archivo = "heladeria.json";
        $heladosGuardados = Helado::LeerJson($archivo);
        array_push($heladosGuardados, $helado);
        $json = Helado::ConvertirAJson($heladosGuardados);
        $archivo = fopen($archivo, "w");
        fwrite($archivo, $json);
        fclose($archivo);
    }

    public static function GuardarJsonArray($helados)
    {
        $archivo = "heladeria.json";
        $json = Helado::ConvertirAJson($helados);
        $archivo = fopen($archivo, "w");
        fwrite($archivo, $json);
        fclose($archivo);
    }


    public function getId()
    {
        return $this->id;
    }

    public function getSabor()
    {
        return $this->sabor;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getVaso()
    {
        return $this->vaso;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setSabor($sabor)
    {
        $this->sabor = $sabor;
    }


    public function Equals($helado){
        return !strcasecmp($this->tipo, $helado->tipo) && !strcasecmp($this->sabor, $helado->sabor);
    }
    
    public static function actualizarHelado(Helado $nuevoHelado) {
        $ruta = "heladeria.json";
        $helados = Helado::LeerJson($ruta);
        $retorno = false;
    
        $id = Helado::BuscarHelado($helados, $nuevoHelado);
        if ($id != -1) {
            $heladoEncontrado = $helados[$id];
            $heladoEncontrado->stock += $nuevoHelado->stock;
            $heladoEncontrado->precio = $nuevoHelado->precio;
            Helado::GuardarJsonArray($helados);
            $retorno = true;
        }
    
        return $retorno;
    }
    
    public static function BuscarHelado(array $heladosExistentes, Helado $helado) {
        for ($i = 0; $i < count($heladosExistentes); $i++) {
            if ($helado->Equals($heladosExistentes[$i])) {
                // Retorno el índice
                return $i;
            }
        }
        return -1;
    }

    public static function ExisteHelado($sabor, $tipo)
    {
        $ruta = "heladeria.json";
        $helados = Helado::LeerJson($ruta);
        $retorno = -1;
    
        foreach ($helados as $helado) {
            if ($helado->sabor == $sabor && $helado->tipo == $tipo) {
                $retorno = 1;
                break;
            }
            if ($helado->sabor == $sabor) {
                $existeSabor = 0;
                break;
            }
            if ($helado->tipo == $tipo) {
                $existeTipo = -1;
                break;
            }
        }

    
        return $retorno;
    }

    public static function DescontarStock($sabor, $tipo, $cantidad) {
        $ruta = "heladeria.json";
        $helados = Helado::LeerJson($ruta);
    
        foreach ($helados as $helado) {
            if ($helado->sabor == $sabor && $helado->tipo == $tipo) {
                $helado->stock -= $cantidad;
            }
        }
    
        Helado::GuardarJsonArray($helados);
    }
    


}
?>
