<?php
class Tipousuario {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getTipoUsuarios() {
        $select_all = "SELECT * FROM tipousuario ORDER BY cargo";
        $res = mysqli_query($this->connection, $select_all);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function deleteTipoUsuario($id) {
        $delete_tipousuario = "DELETE FROM tipousuario WHERE id_tipo_usuario = $id";
        mysqli_query($this->connection, $delete_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El tipo de usuario ha sido eliminado";
        return $vec;
    }

    public function postTipoUsuario($cargo) {
        $insert_tipousuario = "INSERT INTO tipousuario(cargo) VALUES ('$cargo')";
        mysqli_query($this->connection, $insert_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Tipo de usuario guardado";
        return $vec;
    }

    public function updateTipoUsuario($id, $cargo) {
        $update_tipousuario = "UPDATE tipousuario SET cargo = '$cargo' WHERE id_tipo_usuario = $id";
        mysqli_query($this->connection, $update_tipousuario);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Tipo de usuario actualizado";
        return $vec;
    }

    public function getTipoUsuario($valor) {
        $select_tipousuario = "SELECT * FROM tipousuario WHERE cargo LIKE '%$valor%'";
        $res = mysqli_query($this->connection, $select_tipousuario);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
