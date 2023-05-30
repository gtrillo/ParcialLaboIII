<?php
class GeneradorNumeroPedido {
    private static $nextId = 100000;
    private static $deletedIds = [];

    public static function generarNumeroPedido() {
        if (!empty(self::$deletedIds)) {
            return array_shift(self::$deletedIds);
        }
        $numeroPedido = self::$nextId;
        self::$nextId++;
        if (self::$nextId > 999999) {
            self::$nextId = 100000; // Reiniciar el contador si alcanza el límite máximo
        }
        return $numeroPedido;
    }

    public static function eliminarNumeroPedido($numeroPedido) {
        self::$deletedIds[] = $numeroPedido;
    }
}
    ?>