<?php
class Cliente
{
    public $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function consultarClientes()
    {
        $clientes = "SELECT cl.*, ci.nombre AS ciudad FROM cliente cl
            INNER JOIN ciudad ci ON cl.fo_ciudad = ci.id_ciudad
            ORDER BY cl.nombre";
        $res = mysqli_query($this->conexion, $clientes);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        return $vec;
    }

    public function eliminarCliente($id)
    {
        // $eliminar_cliente = "DELETE FROM cliente WHERE id_cliente = $id";
        // mysqli_query($this->conexion, $eliminar_cliente);
        // $vec = [];
        // $vec['resultado'] = "OK";
        // $vec['mensaje'] = "El cliente ha sido eliminado";
        // return $vec;
        
        // Verificar si hay registros relacionados en la tabla venta
        $verificar_relaciones = "SELECT COUNT(*) as count FROM venta WHERE fo_cliente = $id";
        $resultado = mysqli_query($this->conexion, $verificar_relaciones);
        $fila = mysqli_fetch_assoc($resultado);

        // Si hay registros relacionados, no se puede eliminar
        if ($fila['count'] > 0) {
            return [
                'resultado' => 'Error',
                'mensaje' => 'No se puede eliminar el cliente porque está relacionado con otras ventas.'
            ];
        }

        // Intentar eliminar el cliente
        $eliminar_cliente = "DELETE FROM cliente WHERE id_cliente = $id";
        if (mysqli_query($this->conexion, $eliminar_cliente)) {
            return [
                'resultado' => 'OK',
                'mensaje' => 'El cliente ha sido eliminado.'
            ];
        } else {
            return [
                'resultado' => 'Error',
                'mensaje' => 'Error al eliminar el cliente: ' . mysqli_error($this->conexion)
            ];
        }
    }

    public function insertarCliente($params)
    {
        $insertar_cliente = "INSERT INTO cliente(identificacion, nombre, direccion, telefono, email, fo_ciudad)
            VALUES ('$params->identificacion', '$params->nombre', '$params->direccion', '$params->telefono', '$params->email', 
            $params->fo_ciudad)";
        $vec = [];
        if (mysqli_query($this->conexion, $insertar_cliente)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Producto guardado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al guardar el producto: " . mysqli_error($this->conexion);
        }
        return $vec;
    }

    public function editarCliente($id, $params)
    {
        $editar_cliente = "UPDATE cliente SET identificacion = '$params->identificacion', nombre = '$params->nombre', direccion = '$params->direccion',
            telefono = '$params->telefono', email = '$params->email', fo_ciudad = $params->fo_ciudad WHERE id_cliente = $id";
        mysqli_query($this->conexion, $editar_cliente);
        $vec = [];
        if (mysqli_query($this->conexion, $editar_cliente)) {
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "Cliente actualizado";
        } else {
            $vec['resultado'] = "Error";
            $vec['mensaje'] = "Error al actualizar el cliente: " . mysqli_error($this->conexion);
        }
        return $vec;
    }

    public function buscarCliente($valor)
    {
        $buscar_cliente = "SELECT cl.*, ci.nombre AS ciudad FROM cliente cl
            INNER JOIN ciudad ci ON cl.fo_ciudad = ci.id_ciudad
            WHERE cl.identificacion LIKE '%$valor%' OR cl.nombre LIKE '%$valor%' OR ci.nombre LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $buscar_cliente);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>