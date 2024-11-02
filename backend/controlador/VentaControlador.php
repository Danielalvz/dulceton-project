<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

    require_once ("../conexion.php");
    require_once ("../modelos/Venta.php");

    $control = $_GET['control'];
    $venta = new Venta($conexion);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controlador/VentaControlador.php?control=listar
            $vec = $venta->consultarVentas();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controlador/VentaControlador.php?control=insertar
            $json = file_get_contents('php://input');
            // $json = '{"fecha": "2024-10-06", "iva": 19.00, "fo_cliente": 1, "fo_usuario": 1}';
            $params = json_decode($json);
            $vec = $venta->insertarVenta($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controlador/VentaControlador.php?control=eliminar&id=2
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $vec = $venta->eliminarVenta($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controlador/VentaControlador.php?control=editar&id=2
            $json = file_get_contents('php://input');
            // $json = '{"fecha": "2024-07-31", "iva": 21.00, "fo_cliente": 3, "fo_usuario": 1}';
            $params = json_decode($json);
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $vec = $venta->editarVenta($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controlador/VentaControlador.php?control=buscar&dato=a
            $dato = isset($_GET['dato']) ? $_GET['dato'] : '';
            $vec = $venta->buscarVenta($dato);
            break;
        default:
            $vec = [
                'resultado' => 'Error',
                'mensaje' => 'Acción no reconocida'
            ];
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
