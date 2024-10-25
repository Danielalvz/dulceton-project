<?php
class Ciudad {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarCiudades() {
        $ciudades = "SELECT c.*, d.nombre AS departamento FROM ciudad c
            INNER JOIN departamento d ON c.fo_dpto = d.id_departamento
            ORDER BY c.nombre";
        $res = mysqli_query($this->conexion, $ciudades);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarCiudad($id) {
        $eliminar_ciudad = "DELETE FROM ciudad WHERE id_ciudad = $id";
        mysqli_query($this->conexion, $eliminar_ciudad);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La ciudad ha sido eliminada";
        return $vec;
    }

    public function insertarCiudad($params) {
        $insertar_ciudad = "INSERT INTO ciudad(nombre, fo_dpto)
            VALUES ('$params->nombre', $params->fo_dpto)";
        mysqli_query($this->conexion, $insertar_ciudad);
        $vec = [];
        if (mysqli_query($this->conexion, $insertar_ciudad)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Ciudad guardada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar ciudad " . mysqli_error($this->conexion);
        }
        return $vec;
    }

    public function editarCiudad($id, $params) {
        $editar_ciudad = "UPDATE ciudad SET nombre = '$params->nombre', fo_dpto = $params->fo_dpto
            WHERE id_ciudad = $id";
        mysqli_query($this->conexion, $editar_ciudad);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Ciudad actualizada";
        return $vec;
    }

    public function buscarCiudad($valor) {
        $buscar_ciudad = "SELECT c.*, d.nombre AS departamento FROM ciudad c
            INNER JOIN departamento d ON c.fo_dpto = d.id_departamento
            WHERE c.nombre LIKE '%$valor%' OR d.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_ciudad);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }
}