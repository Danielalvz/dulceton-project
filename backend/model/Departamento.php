<?php
class Departamento {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getDepartamentos() {
        $select_all = "SELECT * FROM departamento ORDER BY nombre";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteDepartamento($id) {
        $delete_dpto = "DELETE FROM departamento WHERE id_departamento = $id";
        mysqli_query($this->connection, $delete_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El departamento ha sido eliminado";
        return $vec;
    }

    public function postDepartamento($nombre) {
        $insert_dpto = "INSERT INTO departamento(nombre) VALUES ('$nombre')";
        mysqli_query($this->connection, $insert_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Departamento guardado";
        return $vec;
    }

    public function updateDepartamento($id, $nombre) {
        $update_dpto = "UPDATE departamento SET nombre = '$nombre' WHERE id_departamento = $id";
        mysqli_query($this->connection, $update_dpto);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Departamento actualizado";
        return $vec;
    }

    public function getDepartamento($valor) {
        $select_dpto = "SELECT * FROM departamento WHERE nombre LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_dpto);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
