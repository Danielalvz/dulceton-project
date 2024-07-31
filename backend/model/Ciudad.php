<?php
class Ciudad {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getCiudades() {
        $select_all = "SELECT c.*, d.nombre AS departamento FROM ciudad c
            INNER JOIN departamento d ON c.fo_dpto = d.id_departamento
            ORDER BY c.nombre";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteCiudad($id) {
        $delete_city = "DELETE FROM ciudad WHERE id_ciudad = $id";
        mysqli_query($this->connection, $delete_city);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La ciudad ha sido eliminada";
        return $vec;
    }

    public function postCiudad($params) {
        $insert_city = "INSERT INTO ciudad(nombre, fo_dpto)
            VALUES ('$params->nombre', $params->fo_dpto)";
        mysqli_query($this->connection, $insert_city);
        $vec = [];
        if (mysqli_query($this->connection, $insert_city)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Ciudad guardada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar ciudad " . mysqli_error($this->connection);
        }
        return $vec;
    }

    public function updateCiudad($id, $params) {
        $update_city = "UPDATE ciudad SET nombre = '$params->nombre', fo_dpto = $params->fo_dpto
            WHERE id_ciudad = $id";
        mysqli_query($this->connection, $update_city);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Ciudad actualizada";
        return $vec;
    }

    public function getCiudad($valor) {
        $select_city = "SELECT c.*, d.nombre AS departamento FROM ciudad c
            INNER JOIN departamento d ON c.fo_dpto = d.id_departamento
            WHERE c.nombre LIKE '%$valor%' OR d.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_city);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }
}