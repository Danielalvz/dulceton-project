<?php
class Producto
{
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarProductos()  {
        $productos = "SELECT p .* , c.nombre AS categoria, pr.nombre AS proveedor FROM producto p
            INNER JOIN categoria c ON p.fo_categoria = c.id_categoria
            INNER JOIN proveedor pr ON p.fo_proveedor = pr.id_proveedor
            ORDER BY p.nombre";
        $res = mysqli_query($this->conexion, $productos);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarProducto($id) {
        // $eliminar_detallecompra = "DELETE FROM detallecompra WHERE fo_producto = $id";
        // mysqli_query($this->conexion, $eliminar_detallecompra);

        // $eliminar_detalleventa = "DELETE FROM detalleventa WHERE fo_producto = $id";
        // mysqli_query($this->conexion, $eliminar_detalleventa);

        // Comprobar si hay registros relacionados en otras tablas
        $verificar_detalle_compra = "SELECT COUNT(*) as count FROM detallecompra WHERE fo_producto = $id";
        $resultado_compra = mysqli_query($this->conexion, $verificar_detalle_compra);
        $fila_compra = mysqli_fetch_assoc($resultado_compra);

        $verificar_detalle_venta = "SELECT COUNT(*) as count FROM detalleventa WHERE fo_producto = $id";
        $resultado_venta = mysqli_query($this->conexion, $verificar_detalle_venta);
        $fila_venta = mysqli_fetch_assoc($resultado_venta);

        // Si hay registros relacionados, no se puede eliminar
        if ($fila_compra['count'] > 0 || $fila_venta['count'] > 0) {
            return [
                'resultado' => 'Error',
                'mensaje' => 'No se puede eliminar el producto porque está relacionado con otros registros.'
            ];
        }

        // Intentar eliminar el producto
        $eliminar_producto = "DELETE FROM producto WHERE id_producto = $id";
        if (mysqli_query($this->conexion, $eliminar_producto)) {
            return [
                'resultado' => 'OK',
                'mensaje' => 'El producto ha sido eliminado.'
            ];
        } else {
            return [
                'resultado' => 'Error',
                'mensaje' => 'Error al eliminar el producto: ' . mysqli_error($this->conexion)
            ];
        }
    }

    public function insertarProducto($params) {
        $insertar_producto = "INSERT INTO producto(codigo, nombre, fo_categoria, valor_compra, valor_venta, stock, venta_al_publico, fo_proveedor)
            VALUES ('$params->codigo', '$params->nombre', $params->fo_categoria, $params->valor_compra,
            $params->valor_venta, $params->stock, $params->venta_al_publico, $params->fo_proveedor)";
        $vec = [];
        if (mysqli_query($this->conexion, $insertar_producto)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Producto guardado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar el producto: " . mysqli_error($this->conexion);
        }
        return $vec;
    }

    public function editarProducto($id, $params) {
        $editar_producto = "UPDATE producto SET codigo = '$params->codigo', nombre = '$params->nombre', fo_categoria = $params->fo_categoria,
            valor_compra = $params->valor_compra, valor_venta = $params->valor_venta, stock = $params->stock, venta_al_publico = $params->venta_al_publico,
            fo_proveedor = $params->fo_proveedor WHERE id_producto = $id";
        mysqli_query($this->conexion, $editar_producto);
        $vec = [];
        if (mysqli_query($this->conexion, $editar_producto)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Producto actualizado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar el producto: " . mysqli_error($this->conexion);
        }
        return $vec;
    }

    public function buscarProducto($valor)  {
        $buscar_producto = "SELECT p .* , c.nombre AS categoria, pr.nombre AS proveedor FROM producto p
            INNER JOIN categoria c ON p.fo_categoria = c.id_categoria
            INNER JOIN proveedor pr ON p.fo_proveedor = pr.id_proveedor
             WHERE p.codigo LIKE '%$valor%' 
                          OR p.nombre LIKE '%$valor%' 
                          OR c.nombre LIKE '%$valor%' 
                          OR pr.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_producto);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>