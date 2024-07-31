<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once ("../connection.php");
require_once ("../model/DetalleVenta.php");

$control = isset($_GET['control']) ? $_GET['control'] : '';
$detalleVenta = new DetalleVenta($connection);

$vec = [];

switch ($control) {
    case 'listar':
        // URL: http://localhost:8080/dulceton-sena/backend/controller/DetalleVentaController.php?control=listar
        $vec = $detalleVenta->getDetallesVenta();
        break;
    case 'insertar':
        // URL: http://localhost:8080/dulceton-sena/backend/controller/DetalleVentaController.php?control=insertar
        //$json = file_get_contents('php://input');
        $json = '{"cantidad": 10, "precio": 15000.00, "fo_venta": 1, "fo_producto": 2}';
        $params = json_decode($json);
        $vec = $detalleVenta->postDetalleVenta($params);
        break;
    case 'eliminar':
        // URL: http://localhost:8080/dulceton-sena/backend/controller/DetalleVentaController.php?control=eliminar&id=1
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $vec = $detalleVenta->deleteDetalleVenta($id);
        break;
    case 'editar':
        // URL: http://localhost:8080/dulceton-sena/backend/controller/DetalleVentaController.php?control=editar&id=3
        //$json = file_get_contents('php://input');
        $json = '{"cantidad": 15, "precio": 16000.00, "fo_venta": 1, "fo_producto": 2}';
        $params = json_decode($json);
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $vec = $detalleVenta->updateDetalleVenta($id, $params);
        break;
    case 'buscar':
        // URL: http://localhost:8080/dulceton-sena/backend/controller/DetalleVentaController.php?control=buscar&dato=1
        $dato = isset($_GET['dato']) ? $_GET['dato'] : '';
        $vec = $detalleVenta->getDetalleVenta($dato);
        break;
    default:
        $vec = [
            'resultado' => 'Error',
            'mensaje' => 'Acción no definida'
        ];
        break;
}

header('Content-Type: application/json');
echo json_encode($vec);
?>
