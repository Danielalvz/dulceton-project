<?php
class DetalleVenta {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarDetallesVenta() {
        $detalles_venta = "SELECT dv.*, v.fecha AS fecha_venta, p.nombre AS producto FROM detalleVenta dv
            INNER JOIN venta v ON dv.fo_venta = v.id_venta
            INNER JOIN producto p ON dv.fo_producto = p.id_producto
            ORDER BY v.fecha";
        $res = mysqli_query($this->conexion, $detalles_venta);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarDetalleVenta($id) {
        $eliminar_detalle = "DELETE FROM detalleVenta WHERE id_detalle_venta = $id";
        mysqli_query($this->conexion, $eliminar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El detalle de la venta ha sido eliminado";
        return $vec;
    }

    public function insertarDetalleVenta($params) {
        $insertar_detalle = "INSERT INTO detalleVenta(cantidad, precio, fo_venta, fo_producto)
            VALUES ($params->cantidad, $params->precio, $params->fo_venta, $params->fo_producto)";
        mysqli_query($this->conexion, $insertar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de venta guardado";
        return $vec;
    }

    public function editarDetalleVenta($id, $params) {
        $editar_detalle = "UPDATE 
            detalleVenta SET 
            cantidad = $params->cantidad, 
            precio = $params->precio,
            fo_producto = $params->fo_producto 
            WHERE id_detalle_venta = $id";
        mysqli_query($this->conexion, $editar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de venta actualizado";
        return $vec;
    }

    public function buscarDetalleVenta($valor) {
        $buscar_detalle = "SELECT dv.*, v.fecha AS fecha_venta, p.nombre AS producto FROM detalleVenta dv
            INNER JOIN venta v ON dv.fo_venta = v.id_venta
            INNER JOIN producto p ON dv.fo_producto = p.id_producto
            WHERE dv.id_detalle_venta = $valor OR p.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    public function buscarDetallesVentaPorId($id) {
        $buscar_detalle = "SELECT dv.*, v.fecha AS fecha_venta, p.nombre AS producto FROM detalleVenta dv
            INNER JOIN venta v ON dv.fo_venta = v.id_venta
            INNER JOIN producto p ON dv.fo_producto = p.id_producto
            WHERE v.id_venta = $id";
        $res = mysqli_query($this->conexion, $buscar_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
