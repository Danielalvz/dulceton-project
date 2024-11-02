<?php
class DetalleCompra {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarDetallesCompra() {
        $detalles_compra = "SELECT dc.*, c.fecha AS compra_fecha, p.nombre AS producto FROM detallecompra dc
            INNER JOIN compra c ON dc.fo_compras = c.id_compra
            INNER JOIN producto p ON dc.fo_producto = p.id_producto
            ORDER BY c.fecha";
        $res = mysqli_query($this->conexion, $detalles_compra);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarDetalleCompra($id) {
        $eliminar_detalle = "DELETE FROM detalleCompra WHERE id_detalle_compra = $id";
        mysqli_query($this->conexion, $eliminar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El detalle de la compra ha sido eliminado";
        return $vec;
    }

    public function insertarDetalleCompra($params) {
        $insertar_detalle = "INSERT INTO detalleCompra(cantidad, precio, fo_compras, fo_producto)
            VALUES ($params->cantidad, $params->precio, $params->fo_compras, $params->fo_producto)";
        mysqli_query($this->conexion, $insertar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de la compra guardado";
        return $vec;
    }

    public function editarDetalleCompra($id, $params) {
        $editar_detalle = "UPDATE 
            detalleCompra SET 
            cantidad = $params->cantidad, 
            precio = $params->precio, 
            fo_producto = $params->fo_producto 
            WHERE id_detalle_compra = $id";
        mysqli_query($this->conexion, $editar_detalle);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Detalle de la compra actualizado";
        return $vec;
    }

    public function buscarDetalleCompra($valor) {
        $buscar_detalle = "SELECT dc.*, c.fecha AS compra_fecha, p.nombre AS producto FROM detalleCompra dc
            INNER JOIN compra c ON dc.fo_compras = c.id_compra
            INNER JOIN producto p ON dc.fo_producto = p.id_producto
            WHERE c.fecha LIKE '%$valor%' OR p.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    
    public function buscarDetallesCompraPorId($id) {
        $buscar_detalle = "SELECT dc.*, c.fecha AS compra_fecha, p.nombre AS producto FROM detalleCompra dc
            INNER JOIN compra c ON dc.fo_compras = c.id_compra
            INNER JOIN producto p ON dc.fo_producto = p.id_producto
            WHERE c.id_compra = $id";
        $res = mysqli_query($this->conexion, $buscar_detalle);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    
}
?>
