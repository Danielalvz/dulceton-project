<?php
class DetalleVenta {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getDetallesVenta() {
        $select_all = "SELECT dv.*, v.fecha AS fecha_venta, p.nombre AS producto FROM detalleVenta dv
            INNER JOIN venta v ON dv.fo_venta = v.id_venta
            INNER JOIN producto p ON dv.fo_producto = p.id_producto
            ORDER BY v.fecha";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteDetalleVenta($id) {
        $delete_detalle = "DELETE FROM detalleVenta WHERE id_detalle_venta = $id";
        mysqli_query($this->connection, $delete_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El detalle de la venta ha sido eliminado";
        return $vec;
    }

    public function postDetalleVenta($params) {
        $insert_detalle = "INSERT INTO detalleVenta(cantidad, precio, fo_venta, fo_producto)
            VALUES ($params->cantidad, $params->precio, $params->fo_venta, $params->fo_producto)";
        mysqli_query($this->connection, $insert_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de venta guardado";
        return $vec;
    }

    public function updateDetalleVenta($id, $params) {
        $update_detalle = "UPDATE detalleVenta SET cantidad = $params->cantidad, precio = $params->precio,
            fo_venta = $params->fo_venta, fo_producto = $params->fo_producto WHERE id_detalle_venta = $id";
        mysqli_query($this->connection, $update_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de venta actualizado";
        return $vec;
    }

    public function getDetalleVenta($valor) {
        $select_detalle = "SELECT dv.*, v.fecha AS fecha_venta, p.nombre AS producto FROM detalleVenta dv
            INNER JOIN venta v ON dv.fo_venta = v.id_venta
            INNER JOIN producto p ON dv.fo_producto = p.id_producto
            WHERE dv.id_detalle_venta = $valor OR p.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
