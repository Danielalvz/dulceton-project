<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/DetalleCompra.php");

    $control = isset($_GET['control']) ? $_GET['control'] : '';
    $detalleCompra = new DetalleCompra($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/DetalleCompraController.php?control=listar
            $vec = $detalleCompra->getDetallesCompra();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/DetalleCompraController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"cantidad": 10, "precio": 5000.00, "fo_compras": 1, "fo_producto": 2}';
            $params = json_decode($json);
            $vec = $detalleCompra->postDetalleCompra($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/DetalleCompraController.php?control=eliminar&id=2
            $id = $_GET['id'];
            $vec = $detalleCompra->deleteDetalleCompra($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/DetalleCompraController.php?control=editar&id=2
            //$json = file_get_contents('php://input');
            $json = '{"cantidad": 20, "precio": 6000.00, "fo_compras": 1, "fo_producto": 3}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $detalleCompra->updateDetalleCompra($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/DetalleCompraController.php?control=buscar&dato=2
            $dato = $_GET['dato'];
            $vec = $detalleCompra->getDetalleCompra($dato);
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
