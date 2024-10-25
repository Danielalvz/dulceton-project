<?php
class Categoria {
    public $conexion;
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    public function consultarCategorias() {
        $consultar_todo = 'SELECT * FROM categoria ORDER BY nombre';
        $res = mysqli_query($this->conexion, $consultar_todo);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarCategoria($id) {
        $eliminar_categoria ="DELETE FROM categoria WHERE id_categoria = $id";
        mysqli_query($this -> conexion, $eliminar_categoria);
         $vec = [];
        //  $vec['resultado'] = "OK";
        //  $vec['mensaje'] = "La categoria ha sido eliminada";
        if (mysqli_affected_rows($this->conexion) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "La categoria ha sido eliminada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al eliminar la categoria";
        }
         return $vec;
    }

    public function insertarCategoria($params) {
        $insertar_categoria = "INSERT INTO categoria(nombre) VALUES ('$params->nombre')";
        mysqli_query($this -> conexion, $insertar_categoria);
        $vec = [];
        if (mysqli_affected_rows($this->conexion) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Categoria guardada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar la categoria";
        }
        return $vec;
    }

    public function editarCategoria($id, $params) {
        $editar_categoria = "UPDATE categoria SET nombre = '$params->nombre' WHERE id_categoria = $id";
        mysqli_query($this -> conexion, $editar_categoria);
        $vec = [];
        if (mysqli_affected_rows($this->conexion) > 0) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Categoria actualizada";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar la categoria";
        }
        return $vec;
    }

    public function buscarCategoria($dato) {
        $buscar_categoria = "SELECT * FROM categoria WHERE nombre like '%$dato%'";
        $res = mysqli_query($this -> conexion, $buscar_categoria);
        $vec = [];
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>