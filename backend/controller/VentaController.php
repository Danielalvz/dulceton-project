<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Venta.php");

    $control = $_GET['control'];
    $venta = new Venta($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/VentaController.php?control=listar
            $vec = $venta->getVentas();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/VentaController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"fecha": "2024-07-30", "iva": 19.00, "fo_cliente": 1, "fo_usuario": 1}';
            $params = json_decode($json);
            $vec = $venta->postVenta($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/VentaController.php?control=eliminar&id=2
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $vec = $venta->deleteVenta($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/VentaController.php?control=editar&id=2
            //$json = file_get_contents('php://input');
            $json = '{"fecha": "2024-07-31", "iva": 21.00, "fo_cliente": 3, "fo_usuario": 1}';
            $params = json_decode($json);
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $vec = $venta->updateVenta($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/VentaController.php?control=buscar&dato=a
            $dato = isset($_GET['dato']) ? $_GET['dato'] : '';
            $vec = $venta->getVenta($dato);
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
