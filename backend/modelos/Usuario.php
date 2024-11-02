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
         // Verificar si hay registros relacionados en la tabla venta
        $verificar_ventas = "SELECT COUNT(*) as count FROM venta WHERE fo_usuario = $id"; 
        $resultado_ventas = mysqli_query($this->conexion, $verificar_ventas);
        $fila_ventas = mysqli_fetch_assoc($resultado_ventas);

        // Verificar si hay registros relacionados en la tabla compra
        $verificar_compras = "SELECT COUNT(*) as count FROM compra WHERE fo_usuario = $id"; 
        $resultado_compras = mysqli_query($this->conexion, $verificar_compras);
        $fila_compras = mysqli_fetch_assoc($resultado_compras);

        // Si hay registros relacionados en ventas o compras, no se puede eliminar
        if ($fila_ventas['count'] > 0 || $fila_compras['count'] > 0) {
            return [
                'resultado' => 'Error',
                'mensaje' => 'No se puede eliminar el usuario porque está relacionado con otras ventas o compras.'
            ];
        }

        // Intentar eliminar el usuario
        $eliminar_usuario = "DELETE FROM usuario WHERE id_usuario = $id";
            if (mysqli_query($this->conexion, $eliminar_usuario)) {
                return [
                    'resultado' => 'OK',
                    'mensaje' => 'El usuario ha sido eliminado.'
                ];
            } else {
                return [
                    'resultado' => 'Error',
                    'mensaje' => 'Error al eliminar el usuario: ' . mysqli_error($this->conexion)
                ];
            }
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

    public function buscarUsuarioPorCorreoYClave($email, $password) {
        // Generar el hash SHA-1 de la clave en PHP
        $hashedPassword = sha1($password);

        $buscar_usuario = "SELECT 
            u.*, tu.cargo AS tipo_usuario 
            FROM usuario u
            INNER JOIN tipousuario tu ON u.fo_tipo_usuario = tu.id_tipo_usuario
            WHERE u.email = '$email' AND u.password = '$hashedPassword'";

            
        $res = mysqli_query($this->conexion, $buscar_usuario);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        
        if ($vec == []) {
            $vec[0] = array("validar" => "no valida");
        } else {
            $vec[0]['validar'] = "valida";
        }

        return $vec;
    }
}
?>
