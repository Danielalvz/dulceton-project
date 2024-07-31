<?php
class Producto {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getProductos() {
        $select_all = "SELECT p .* , c.nombre AS categoria, pr.nombre AS proveedor FROM producto p
            INNER JOIN categoria c ON p.fo_categoria = c.id_categoria
            INNER JOIN proveedor pr ON p.fo_proveedor = pr.id_proveedor
            ORDER BY p.nombre";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteProducto($id) {
        $delete_product = "DELETE FROM producto WHERE id_producto = $id";
        mysqli_query($this->connection, $delete_product);
        $vec = [];
        if (mysqli_query($this->connection, $delete_product)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "El producto ha sido eliminado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al eliminar el producto: " . mysqli_error($this->connection);
        }
        return $vec;
    }

    public function postProducto($params) {
        $insert_product = "INSERT INTO producto(codigo, nombre, fo_categoria, valor_compra, valor_venta, stock, venta_al_publico, fo_proveedor)
            VALUES ('$params->codigo', '$params->nombre', $params->fo_categoria, $params->valor_compra,
            $params->valor_venta, $params->stock, $params->venta_al_publico, $params->fo_proveedor)";
        $vec = [];
        if (mysqli_query($this->connection, $insert_product)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Producto guardado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar el producto: " . mysqli_error($this->connection);
        }
        return $vec;
    }

    public function updateProducto($id, $params) {
        $update_product = "UPDATE producto SET codigo = '$params->codigo', nombre = '$params->nombre', fo_categoria = $params->fo_categoria,
            valor_compra = $params->valor_compra, valor_venta = $params->valor_venta, stock = $params->stock, venta_al_publico = $params->venta_al_publico,
            fo_proveedor = $params->fo_proveedor WHERE id_producto = $id";
        mysqli_query($this->connection, $update_product);
        $vec = [];
        if (mysqli_query($this->connection, $update_product)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Producto actualizado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar el producto: " . mysqli_error($this->connection);
        }
        return $vec;
    }

    public function getProducto($valor) {
        $select_product = "SELECT p .* , c.nombre AS categoria, pr.nombre AS proveedor FROM producto p
            INNER JOIN categoria c ON p.fo_categoria = c.id_categoria
            INNER JOIN proveedor pr ON p.fo_proveedor = pr.id_proveedor
             WHERE p.codigo LIKE '%$valor%' 
                          OR p.nombre LIKE '%$valor%' 
                          OR c.nombre LIKE '%$valor%' 
                          OR pr.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_product);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>