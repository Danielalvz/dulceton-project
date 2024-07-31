<?php
class Cliente {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getClientes() {
        $select_all = "SELECT cl.*, ci.nombre AS ciudad FROM cliente cl
            INNER JOIN ciudad ci ON cl.fo_ciudad = ci.id_ciudad
            ORDER BY cl.nombre";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteCliente($id) {
        $delete_client = "DELETE FROM cliente WHERE id_cliente = $id";
        mysqli_query($this->connection, $delete_client);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El cliente ha sido eliminado";
        return $vec;
    }

    public function postCliente($params) {
        $insert_client = "INSERT INTO cliente(identificacion, nombre, direccion, telefono, email, fo_ciudad)
            VALUES ('$params->identificacion', '$params->nombre', '$params->direccion', '$params->telefono', '$params->email', 
            $params->fo_ciudad)";
        mysqli_query($this->connection, $insert_client);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Cliente guardado";
        return $vec;
    }

    public function updateCliente($id, $params) {
        $update_client = "UPDATE cliente SET identificacion = '$params->identificacion', nombre = '$params->nombre', direccion = '$params->direccion',
            telefono = '$params->telefono', email = '$params->email', fo_ciudad = $params->fo_ciudad WHERE id_cliente = $id";
        mysqli_query($this->connection, $update_client);
        $vec = [];
        if (mysqli_query($this->connection, $update_client)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Cliente actualizado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar el cliente: " . mysqli_error($this->connection);
        }
        return $vec;
    }

    public function getCliente($valor) {
        $select_client = "SELECT cl.*, ci.nombre AS ciudad FROM cliente cl
            INNER JOIN ciudad ci ON cl.fo_ciudad = ci.id_ciudad
            WHERE cl.identificacion LIKE '%$valor%' OR cl.nombre LIKE '%$valor%' OR ci.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_client);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
