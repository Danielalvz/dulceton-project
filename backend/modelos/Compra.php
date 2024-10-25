<?php
class Compra {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarCompras() {
        $compras = "SELECT c.*, p.nombre AS proveedor, u.usuario AS usuario FROM compra c
            INNER JOIN proveedor p ON c.fo_proveedor = p.id_proveedor
            INNER JOIN usuario u ON c.fo_usuario = u.id_usuario
            ORDER BY c.fecha";
        $res = mysqli_query($this->conexion, $compras);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarCompra($id) {
        $eliminar_compra = "DELETE FROM compra WHERE id_compra = $id";
        mysqli_query($this->conexion, $eliminar_compra);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La compra ha sido eliminada";
        return $vec;
    }

    public function insertarCompra($params) {
        $insertar_compra = "INSERT INTO compra(fecha, iva, fo_proveedor, fo_usuario)
            VALUES ('$params->fecha', $params->iva, $params->fo_proveedor, $params->fo_usuario)";
        mysqli_query($this->conexion, $insertar_compra);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Compra guardada";
        return $vec;
    }

    public function editarCompra($id, $params) {
        $editar_compra = "UPDATE compra SET fecha = '$params->fecha', iva = $params->iva, fo_proveedor = $params->fo_proveedor,
            fo_usuario = $params->fo_usuario WHERE id_compra = $id";
        mysqli_query($this->conexion, $editar_compra);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Compra actualizada";
        return $vec;
    }

    public function buscarCompra($valor) {
        $buscar_compra = "SELECT c.*, p.nombre AS proveedor, u.usuario AS usuario FROM compra c
            INNER JOIN proveedor p ON c.fo_proveedor = p.id_proveedor
            INNER JOIN usuario u ON c.fo_usuario = u.id_usuario
            WHERE c.id_compra LIKE '%$valor%' OR p.nombre LIKE '%$valor%' OR u.usuario LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_compra);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
