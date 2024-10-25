<?php
class Usuario {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarUsuarios() {
        $usuarios = "SELECT u.*, tu.cargo AS tipo_usuario FROM usuario u
            INNER JOIN tipousuario tu ON u.fo_tipo_usuario = tu.id_tipo_usuario
            ORDER BY u.usuario";
        $res = mysqli_query($this->conexion, $usuarios);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarUsuario($id) {
        $eliminar_usuario = "DELETE FROM usuario WHERE id_usuario = $id";
        mysqli_query($this->conexion, $eliminar_usuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El usuario ha sido eliminado";
        return $vec;
    }

    public function insertarUsuario($params) {
        $insertar_usuario = "INSERT INTO usuario(usuario, password, email, telefono, fo_tipo_usuario)
            VALUES ('$params->usuario', '$params->password', '$params->email', '$params->telefono', $params->fo_tipo_usuario)";
        mysqli_query($this->conexion, $insertar_usuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Usuario guardado";
        return $vec;
    }

    public function editarUsuario($id, $params) {
        $editar_usuario = "UPDATE usuario SET usuario = '$params->usuario', password = '$params->password', email = '$params->email',
            telefono = '$params->telefono', fo_tipo_usuario = $params->fo_tipo_usuario WHERE id_usuario = $id";
        mysqli_query($this->conexion, $editar_usuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Usuario actualizado";
        return $vec;
    }

    public function buscarUsuario($valor) {
        $buscar_usuario = "SELECT u.*, tu.cargo AS tipo_usuario FROM usuario u
            INNER JOIN tipousuario tu ON u.fo_tipo_usuario = tu.id_tipo_usuario
            WHERE u.usuario LIKE '%$valor%' OR u.email LIKE '%$valor%' OR tu.cargo LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_usuario);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
