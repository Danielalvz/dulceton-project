<?php
class Usuario {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getUsuarios() {
        $select_all = "SELECT u.*, tu.cargo AS tipo_usuario FROM usuario u
            INNER JOIN tipousuario tu ON u.fo_tipo_usuario = tu.id_tipo_usuario
            ORDER BY u.usuario";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteUsuario($id) {
        $delete_user = "DELETE FROM usuario WHERE id_usuario = $id";
        mysqli_query($this->connection, $delete_user);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El usuario ha sido eliminado";
        return $vec;
    }

    public function postUsuario($params) {
        $insert_user = "INSERT INTO usuario(usuario, password, email, telefono, fo_tipo_usuario)
            VALUES ('$params->usuario', '$params->password', '$params->email', '$params->telefono', $params->fo_tipo_usuario)";
        mysqli_query($this->connection, $insert_user);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Usuario guardado";
        return $vec;
    }

    public function updateUsuario($id, $params) {
        $update_user = "UPDATE usuario SET usuario = '$params->usuario', password = '$params->password', email = '$params->email',
            telefono = '$params->telefono', fo_tipo_usuario = $params->fo_tipo_usuario WHERE id_usuario = $id";
        mysqli_query($this->connection, $update_user);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Usuario actualizado";
        return $vec;
    }

    public function getUsuario($valor) {
        $select_user = "SELECT u.*, tu.cargo AS tipo_usuario FROM usuario u
            INNER JOIN tipousuario tu ON u.fo_tipo_usuario = tu.id_tipo_usuario
            WHERE u.usuario LIKE '%$valor%' OR u.email LIKE '%$valor%' OR tu.cargo LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_user);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
