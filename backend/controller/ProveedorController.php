<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Proveedor.php");

    $control = $_GET['control'];
    $proveedor = new Proveedor($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProveedorController.php?control=listar
            $vec = $proveedor->getProveedores();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProveedorController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"razon_social": "1551", "nombre": "Proveedor Ejemplo", "direccion": "Cl 33 no.1-85", "telefono": "555123456", "email": "contacto@proveedorejemplo.com", "fo_ciudad": 2}';
            $params = json_decode($json);
            $vec = $proveedor->postProveedor($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProveedorController.php?control=eliminar&id=3
            $id = $_GET['id'];
            $vec = $proveedor->deleteProveedor($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProveedorController.php?control=editar&id=3
            //$json = file_get_contents('php://input');
            $json = '{"razon_social": "1551", "nombre": "Proveedor Ejemplo", "direccion": "Cl 33 no.1-85", "telefono": "555123456", "email": "contacto@proveedorejemplo.com", "fo_ciudad": 1}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $proveedor->updateProveedor($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/ProveedorController.php?control=buscar&dato=a
            $dato = $_GET['dato'];
            $vec = $proveedor->getProveedor($dato);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
