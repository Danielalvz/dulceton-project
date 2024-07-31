<?php
class Categoria {
    public $connection;
    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function getCategorias() {
        $select_all = 'SELECT * FROM categoria ORDER BY nombre';
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteCategoria($id) {
        $delete_category ="DELETE FROM categoria WHERE id_categoria = $id";
        mysqli_query($this -> connection, $delete_category);
         $vec = [];
        //  $vec['resultado'] = "OK";
        //  $vec['mensaje'] = "La categoria ha sido eliminada";
        if (mysqli_affected_rows($this->connection) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "La categoria ha sido eliminada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al eliminar la categoria";
        }
         return $vec;
    }

    public function postCategoria($params) {
        $insert_category = "INSERT INTO categoria(nombre) VALUES ('$params->nombre')";
        mysqli_query($this -> connection, $insert_category);
        $vec = [];
        if (mysqli_affected_rows($this->connection) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Categoria guardada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar la categoria";
        }
        return $vec;
    }

    public function updateCategoria($id, $params) {
        $update_category = "UPDATE categoria SET nombre = '$params->nombre' WHERE id_categoria = $id";
        mysqli_query($this -> connection, $update_category);
        $vec = [];
        if (mysqli_affected_rows($this->connection) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Categoria actualizada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar la categoria";
        }
        return $vec;
    }

    public function getCategoria($dato) {
        $select_category = "SELECT * FROM categoria WHERE nombre like '%$dato%'";
        $res = mysqli_query($this -> connection, $select_category);
        $vec = [];
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>