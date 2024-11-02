<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../conexion.php");
require_once("../modelos/DetalleCompra.php");

$control = isset($_GET['control']) ? $_GET['control'] : '';
$detalleCompra = new DetalleCompra($conexion);

$vec = [];

switch ($control) {
    case 'listar':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=listar
        $vec = $detalleCompra->consultarDetallesCompra();
        break;
    case 'insertar':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=insertar
        $json = file_get_contents('php://input');
        // $json = '{"cantidad": 11, "precio": 5000.00, "fo_compras": 1, "fo_producto": 2}';
        $params = json_decode($json);
        $vec = $detalleCompra->insertarDetalleCompra($params);
        break;
    case 'eliminar':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=eliminar&id=2
        $id = $_GET['id'];
        $vec = $detalleCompra->eliminarDetalleCompra($id);
        break;
    case 'editar':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=editar&id=2
        $json = file_get_contents('php://input');
        // $json = '{"cantidad": 20, "precio": 6000.00, "fo_compras": 1, "fo_producto": 3}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $detalleCompra->editarDetalleCompra($id, $params);
        break;
    case 'buscar':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=buscar&dato=2
        $dato = $_GET['dato'];
        $vec = $detalleCompra->buscarDetalleCompra($dato);
        break;
    case 'buscarid':
        // http://localhost:8080/dulceton-sena/backend/controlador/DetalleCompraControlador.php?control=buscarid&id=2
        $id = $_GET['id'];
        $vec = $detalleCompra->buscarDetallesCompraPorId($id);
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