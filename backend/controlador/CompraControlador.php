<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../conexion.php");
require_once("../modelos/Compra.php");

$control = isset($_GET['control']) ? $_GET['control'] : '';
$compra = new Compra($conexion);

$vec = [];

switch ($control) {
    case 'listar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=listar
        $vec = $compra->consultarCompras();
        break;
    case 'insertar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=insertar
        $json = file_get_contents('php://input');
        // $json = '{"fecha": "2024-07-30", "iva": 19.00, "fo_proveedor": 1, "fo_usuario": 2}';
        $params = json_decode($json);
        $vec = $compra->insertarCompra($params);
        break;
    case 'eliminar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=eliminar&id=2
        $id = $_GET['id'];
        $vec = $compra->eliminarCompra($id);
        break;
    case 'editar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=editar&id=3
        $json = file_get_contents('php://input');
        // $json = '{"fecha": "2024-07-31", "iva": 21.00, "fo_proveedor": 2, "fo_usuario": 3}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $compra->editarCompra($id, $params);
        break;
    case 'buscar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=buscar&dato=a
        $dato = $_GET['dato'];
        $vec = $compra->buscarCompra($dato);
        break;
    case 'buscarid':
        // http://localhost:8080/dulceton-sena/backend/controlador/CompraControlador.php?control=buscarid&id=1
        $id = $_GET['id'];
        $vec = $compra->buscarCompraPorID($id);
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