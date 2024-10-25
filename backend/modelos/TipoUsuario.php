<?php
class Tipousuario {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarTipoUsuarios() {
        $tipo_usuarios = "SELECT * FROM tipousuario ORDER BY cargo";
        $res = mysqli_query($this->conexion, $tipo_usuarios);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarTipoUsuario($id) {
        $eliminar_tipousuario = "DELETE FROM tipousuario WHERE id_tipo_usuario = $id";
        mysqli_query($this->conexion, $eliminar_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El tipo de usuario ha sido eliminado";
        return $vec;
    }

    public function insertarTipoUsuario($params) {
        $insertar_tipousuario = "INSERT INTO tipousuario(cargo) VALUES ('$params->cargo')";
        mysqli_query($this->conexion, $insertar_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Tipo de usuario guardado";
        return $vec;
    }

    public function editarTipoUsuario($id, $params) {
        $editar_tipousuario = "UPDATE tipousuario SET cargo = '$params->cargo' WHERE id_tipo_usuario = $id";
        mysqli_query($this->conexion, $editar_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Tipo de usuario actualizado";
        return $vec;
    }

    public function buscarTipoUsuario($valor) {
        $buscar_tipousuario = "SELECT * FROM tipousuario WHERE cargo LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_tipousuario);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
