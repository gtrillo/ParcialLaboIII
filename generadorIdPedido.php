<?php
class IdGeneratorPedido {

    private static $nextId = 1;
    private static $deletedIds = [];

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
}
?>