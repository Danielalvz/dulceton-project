<?php
class Proveedor {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consultarProveedores() {
        $proveedores = "SELECT pr.*, ci.nombre AS ciudad FROM proveedor pr
            INNER JOIN ciudad ci ON pr.fo_ciudad = ci.id_ciudad
            ORDER BY pr.nombre";
        $res = mysqli_query($this->conexion, $proveedores);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarProveedor($id) {
        $eliminar_proveedor = "DELETE FROM proveedor WHERE id_proveedor = $id";
        mysqli_query($this->conexion, $eliminar_proveedor);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El proveedor ha sido eliminado";
        return $vec;
    }

    public function insertarProveedor($params) {
        $insertar_proveedor = "INSERT INTO proveedor(razon_social, nombre, direccion, telefono, email, fo_ciudad)
            VALUES ('$params->razon_social', '$params->nombre', '$params->direccion', '$params->telefono', '$params->email', 
            $params->fo_ciudad)";
        mysqli_query($this->conexion, $insertar_proveedor);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Proveedor guardado";
        return $vec;
    }

    public function editarProveedor($id, $params) {
        $editar_proveedor = "UPDATE proveedor SET razon_social = '$params->razon_social', nombre = '$params->nombre', direccion = '$params->direccion',
            telefono = '$params->telefono', email = '$params->email', fo_ciudad = $params->fo_ciudad WHERE id_proveedor = $id";
        mysqli_query($this->conexion, $editar_proveedor);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Proveedor actualizado";
        return $vec;
    }

    public function buscarProveedor($valor) {
        $buscar_proveedor = "SELECT pr.*, ci.nombre AS ciudad FROM proveedor pr
            INNER JOIN ciudad ci ON pr.fo_ciudad = ci.id_ciudad
            WHERE pr.razon_social LIKE '%$valor%' OR pr.nombre LIKE '%$valor%' OR ci.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_proveedor);
        $vec = [];
        
        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
