<?php
require_once 'helado.php';
require_once 'venta.php';

class CuponDescuento {
    private $id;
    private $devolucionId;
    private $porcentajeDescuento = 10;
    private $estado;
    
    private static $nextId = 1;
    private static $deletedIds = [];

    public function __construct($devolucionId, $estado)
    {
        $this->id = CuponDescuento::generateId();
        $this->devolucionId = $devolucionId;
        $this->estado = $estado;
    }

    public static function generateId() {
        if (!empty(self::$deletedIds)) {
            return array_shift(self::$deletedIds);
        }
        $id = self::$nextId;
        self::$nextId++;
        if (self::$nextId > 1000) {
            self::$nextId = 1; // Reiniciar el contador si alcanza el límite máximo
        }
        return $id;
    }
    
    public static function deleteId($id) {
        self::$deletedIds[] = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDevolucionId()
    {
        return $this->devolucionId;
    }

    public function setDevolucionId($devolucionId)
    {
        $this->devolucionId = $devolucionId;
    }

    public function getPorcentajeDescuento()
    {
        return $this->porcentajeDescuento;
    }

    public function setPorcentajeDescuento()
    {
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado()
    {
        $this->estado = true; // cambia el estado del cupon a true
    }

    public function __toString()
    {
        return "Número de pedido: " . $this->devolucionId . "\n" .
            "ID: " . $this->id . "\n";
    }

    public static function ConvertirAJson($cupones)
    {
        $datos = array();
        foreach ($cupones as $cupon) {
            $cuponDatos = array(
                "devolucionId" => $cupon->getDevolucionId(),
                "id" => $cupon->getId(),
                "estado" => $cupon->getEstado(),
            );
            $datos[] = $cuponDatos;
        }
        return json_encode($datos);
    }

    public static function LeerJson($ruta)
    {
        $data = file_get_contents($ruta);
        $cuponesJson = json_decode($data, true);
        $cupones = array();

        if (is_array($cuponesJson)) {
            foreach ($cuponesJson as $cuponData) {
                $cupon = new CuponDescuento(
                    $cuponData['devolucionId'],
                    $cuponData['estado']
                );
                $cupon->setId($cuponData['id']);
                array_push($cupones, $cupon);
            }
        }

        return $cupones;
    }

    public static function GuardarJsonArray($cupones)
    {
        $archivo = "cupones.json";
        $json = CuponDescuento::ConvertirAJson($cupones);
        $archivo = fopen($archivo, "w");
        fwrite($archivo, $json);
        fclose($archivo);
    }

    public static function GuardarJson($cupon)
    {
        $archivo = "cupones.json";
        $cuponesGuardados = CuponDescuento::LeerJson($archivo);
        array_push($cuponesGuardados, $cupon);
        $json = CuponDescuento::ConvertirAJson($cuponesGuardados);
        $archivo = fopen($archivo, "w");
        fwrite($archivo, $json);
        fclose($archivo);
    }

}
?>
