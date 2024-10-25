<?php
class Departamento {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarDepartamentos() {
        $departamentos = "SELECT * FROM departamento ORDER BY nombre";
        $res = mysqli_query($this->conexion, $departamentos);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarDepartamento($id) {
        $eliminar_dpto = "DELETE FROM departamento WHERE id_departamento = $id";
        mysqli_query($this->conexion, $eliminar_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El departamento ha sido eliminado";
        return $vec;
    }

    public function insertarDepartamento($params) {
        $insertar_dpto = "INSERT INTO departamento(nombre) VALUES ('$params->nombre')";
        mysqli_query($this->conexion, $insertar_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Departamento guardado";
        return $vec;
    }

    public function editarDepartamento($id, $params) {
        $editar_dpto = "UPDATE departamento SET nombre = '$params->nombre' WHERE id_departamento = $id";
        mysqli_query($this->conexion, $editar_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Departamento actualizado";
        return $vec;
    }

    public function buscarDepartamento($valor) {
        $buscar_dpto = "SELECT * FROM departamento WHERE nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_dpto);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
