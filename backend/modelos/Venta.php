<?php
class Venta {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarVentas() {
        $ventas = "SELECT 
            v.id_venta AS id_venta,
            v.fecha AS fecha,
            v.iva AS iva,
            v.fo_cliente AS fo_cliente,
            v.fo_usuario AS fo_usuario,
            c.nombre AS cliente,
            u.usuario AS usuario
            FROM 
            venta v
            JOIN cliente c ON v.fo_cliente = c.id_cliente
            JOIN usuario u ON v.fo_usuario = u.id_usuario
            ORDER BY v.fecha";
        $res = mysqli_query($this->conexion, $ventas);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarVenta($id) {
        $eliminar_venta = "DELETE FROM venta WHERE id_venta = $id";
        mysqli_query($this->conexion, $eliminar_venta);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La venta ha sido eliminada";
        return $vec;
    }

    public function insertarVenta($params) {
        $insertar_venta = "INSERT INTO venta(fecha, iva, fo_cliente, fo_usuario)
            VALUES ('$params->fecha', $params->iva, $params->fo_cliente, $params->fo_usuario)";
        mysqli_query($this->conexion, $insertar_venta);

        $ultimo_ID = mysqli_insert_id($this->conexion);

        $obtener_venta = "SELECT v.id_venta as id_venta, v.iva, cl.nombre AS cliente, u.usuario AS usuario FROM venta v
            INNER JOIN cliente cl ON v.fo_cliente = cl.id_cliente
            INNER JOIN usuario u ON v.fo_usuario = u.id_usuario
            WHERE v.id_venta = '$ultimo_ID'";

        $query_venta = mysqli_query($this->conexion, $obtener_venta);
        $row = mysqli_fetch_row($query_venta);
        $vec = [
            'id_venta' => $row[0],
            'iva' => $row[1],
            'cliente' => $row[2],
            'usuario' => $row[3],
        ];
        return $vec;
    }

    public function editarVenta($id, $params) {
        $editar_venta = "UPDATE venta SET fecha = '$params->fecha', iva = $params->iva, fo_cliente = $params->fo_cliente,
            fo_usuario = $params->fo_usuario WHERE id_venta = $id";
        mysqli_query($this->conexion, $editar_venta);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Venta actualizada";
        return $vec;
    }

    public function buscarVenta($valor) {
        $buscar_venta = "SELECT v.*, c.nombre AS cliente, u.usuario AS usuario FROM venta v
            INNER JOIN cliente c ON v.fo_cliente = c.id_cliente
            INNER JOIN usuario u ON v.fo_usuario = u.id_usuario
            WHERE v.id_venta LIKE '%$valor%' OR c.nombre LIKE '%$valor%' OR u.usuario LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_venta);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
