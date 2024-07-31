<?php
class Proveedor {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getProveedores() {
        $select_all = "SELECT pr.*, ci.nombre AS ciudad FROM proveedor pr
            INNER JOIN ciudad ci ON pr.fo_ciudad = ci.id_ciudad
            ORDER BY pr.nombre";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteProveedor($id) {
        $delete_provider = "DELETE FROM proveedor WHERE id_proveedor = $id";
        mysqli_query($this->connection, $delete_provider);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El proveedor ha sido eliminado";
        return $vec;
    }

    public function postProveedor($params) {
        $insert_provider = "INSERT INTO proveedor(razon_social, nombre, direccion, telefono, email, fo_ciudad)
            VALUES ('$params->razon_social', '$params->nombre', '$params->direccion', '$params->telefono', '$params->email', 
            $params->fo_ciudad)";
        mysqli_query($this->connection, $insert_provider);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Proveedor guardado";
        return $vec;
    }

    public function updateProveedor($id, $params) {
        $update_provider = "UPDATE proveedor SET razon_social = '$params->razon_social', nombre = '$params->nombre', direccion = '$params->direccion',
            telefono = '$params->telefono', email = '$params->email', fo_ciudad = $params->fo_ciudad WHERE id_proveedor = $id";
        mysqli_query($this->connection, $update_provider);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Proveedor actualizado";
        return $vec;
    }

    public function getProveedor($valor) {
        $select_provider = "SELECT pr.*, ci.nombre AS ciudad FROM proveedor pr
            INNER JOIN ciudad ci ON pr.fo_ciudad = ci.id_ciudad
            WHERE pr.razon_social LIKE '%$valor%' OR pr.nombre LIKE '%$valor%' OR ci.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_provider);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
