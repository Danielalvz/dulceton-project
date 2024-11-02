<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Incluye el método PUT
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permite los encabezados necesarios

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once("../conexion.php");
require_once("../modelos/Producto.php");

$control = $_GET['control'];

$producto = new Producto($conexion);
switch ($control) {
    case 'listar':
        // http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php?control=listar
        $vec = $producto->consultarProductos();
        break;
    case 'insertar':
        // http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php?control=insertar
        // $json = '{"codigo": "P011", "nombre": "Tartin de Chocolate 1 libra", "fo_categoria": 1, "valor_compra": 15000, "valor_venta": 32000, "stock": 15, "venta_al_publico": 1, "fo_proveedor": 1}';

        $json = file_get_contents('php://input');
        $params = json_decode($json); //convierte en vector
        //print_r($params);
        $vec = $producto->insertarProducto($params);
        break;
    case 'eliminar':
        // http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php?control=eliminar&id=10
        $id = $_GET['id'];
        $vec = $producto->eliminarProducto($id);
        break;
    case 'editar':
        // http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php?control=editar&id=2
        $json = file_get_contents('php://input');
        // $json = '{"codigo": "P002", "nombre": "Torta de Zanahoria 1 libra", "fo_categoria": 1, "valor_compra": 12500, "valor_venta": 24000, "stock": 15, "venta_al_publico": 1, "fo_proveedor": 1}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $producto->editarProducto($id, $params);
        break;
    case 'buscar':
        // http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php?control=buscar&dato=torta
        $dato = $_GET['dato'];
        $vec = $producto->buscarProducto($dato);
        break;
}

$datos_json = json_encode($vec);


echo $datos_json;
?>