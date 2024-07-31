<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Producto.php");

    $control = $_GET['control'];

    $producto = new Producto($connection);
    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProductoController.php?control=listar
            $vec = $producto->getProductos();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProductoController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"codigo": "P011", "nombre": "Tartin de Chocolate 1 libra", "fo_categoria": 1, "valor_compra": 15000, "valor_venta": 32000, "stock": 15, "venta_al_publico": 1, "fo_proveedor": 1}';
            $params = json_decode($json); //convierte en vector
            //print_r($params);

            $vec = $producto->postProducto($params);
            break;
        case 'eliminar': 
            // http://localhost:8080/dulceton-sena/backend/controller/ProductoController.php?control=eliminar&id=10
            $id = $_GET['id'];
            $vec = $producto -> deleteProducto($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProductoController.php?control=editar&id=2
            //$json = file_get_contents('php://input');
            $json = '{"codigo": "P002", "nombre": "Torta de Zanahoria 1 libra", "fo_categoria": 1, "valor_compra": 12500, "valor_venta": 24000, "stock": 15, "venta_al_publico": 1, "fo_proveedor": 1}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $producto -> updateProducto($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProductoController.php?control=buscar&dato=torta
            $dato = $_GET['dato'];
            $vec = $producto -> getProducto($dato);
            break;
    }

    $datos_json = json_encode($vec);
    echo $datos_json;
    header('Content-Type: application/json');
?>
