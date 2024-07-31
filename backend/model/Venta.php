<?php
class Venta {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getVentas() {
        $select_all = "SELECT v.*, c.nombre AS cliente, u.usuario AS usuario FROM venta v
            INNER JOIN cliente c ON v.fo_cliente = c.id_cliente
            INNER JOIN usuario u ON v.fo_usuario = u.id_usuario
            ORDER BY v.fecha";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteVenta($id) {
        $delete_venta = "DELETE FROM venta WHERE id_venta = $id";
        mysqli_query($this->connection, $delete_venta);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La venta ha sido eliminada";
        return $vec;
    }

    public function postVenta($params) {
        $insert_venta = "INSERT INTO venta(fecha, iva, fo_cliente, fo_usuario)
            VALUES ('$params->fecha', $params->iva, $params->fo_cliente, $params->fo_usuario)";
        mysqli_query($this->connection, $insert_venta);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Venta guardada";
        return $vec;
    }

    public function updateVenta($id, $params) {
        $update_venta = "UPDATE venta SET fecha = '$params->fecha', iva = $params->iva, fo_cliente = $params->fo_cliente,
            fo_usuario = $params->fo_usuario WHERE id_venta = $id";
        mysqli_query($this->connection, $update_venta);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Venta actualizada";
        return $vec;
    }

    public function getVenta($valor) {
        $select_venta = "SELECT v.*, c.nombre AS cliente, u.usuario AS usuario FROM venta v
            INNER JOIN cliente c ON v.fo_cliente = c.id_cliente
            INNER JOIN usuario u ON v.fo_usuario = u.id_usuario
            WHERE v.id_venta LIKE '%$valor%' OR c.nombre LIKE '%$valor%' OR u.usuario LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_venta);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
