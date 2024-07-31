<?php
class DetalleCompra {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getDetallesCompra() {
        $select_all = "SELECT dc.*, c.fecha AS compra_fecha, p.nombre AS producto FROM detallecompra dc
            INNER JOIN compra c ON dc.fo_compras = c.id_compra
            INNER JOIN producto p ON dc.fo_producto = p.id_producto
            ORDER BY c.fecha";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteDetalleCompra($id) {
        $delete_detalle = "DELETE FROM detalleCompra WHERE id_detalle_compra = $id";
        mysqli_query($this->connection, $delete_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El detalle de la compra ha sido eliminado";
        return $vec;
    }

    public function postDetalleCompra($params) {
        $insert_detalle = "INSERT INTO detalleCompra(cantidad, precio, fo_compras, fo_producto)
            VALUES ($params->cantidad, $params->precio, $params->fo_compras, $params->fo_producto)";
        mysqli_query($this->connection, $insert_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de la compra guardado";
        return $vec;
    }

    public function updateDetalleCompra($id, $params) {
        $update_detalle = "UPDATE detalleCompra SET cantidad = $params->cantidad, precio = $params->precio,
            fo_compras = $params->fo_compras, fo_producto = $params->fo_producto WHERE id_detalle_compra = $id";
        mysqli_query($this->connection, $update_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de la compra actualizado";
        return $vec;
    }

    public function getDetalleCompra($valor) {
        $select_detalle = "SELECT dc.*, c.fecha AS compra_fecha, p.nombre AS producto FROM detalleCompra dc
            INNER JOIN compra c ON dc.fo_compras = c.id_compra
            INNER JOIN producto p ON dc.fo_producto = p.id_producto
            WHERE c.fecha LIKE '%$valor%' OR p.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
