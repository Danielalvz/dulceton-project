<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Compra.php");

    $control = isset($_GET['control']) ? $_GET['control'] : '';
    $compra = new Compra($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/CompraController.php?control=listar
            $vec = $compra->getCompras();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/CompraController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"fecha": "2024-07-30", "iva": 19.00, "fo_proveedor": 1, "fo_usuario": 2}';
            $params = json_decode($json);
            $vec = $compra->postCompra($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/CompraController.php?control=eliminar&id=2
            $id = $_GET['id'];
            $vec = $compra->deleteCompra($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/CompraController.php?control=editar&id=3
            //$json = file_get_contents('php://input');
            $json = '{"fecha": "2024-07-31", "iva": 21.00, "fo_proveedor": 2, "fo_usuario": 3}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $compra->updateCompra($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/CompraController.php?control=buscar&dato=a
            $dato = $_GET['dato'];
            $vec = $compra->getCompra($dato);
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
