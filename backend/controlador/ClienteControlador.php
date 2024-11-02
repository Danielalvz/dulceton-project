<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

    require_once ("../conexion.php");
    require_once ("../modelos/Cliente.php");

    $control = $_GET['control'];
    $cliente = new Cliente($conexion);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controlador/ClienteControlador.php?control=listar
            $vec = $cliente->consultarClientes();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controlador/ClienteControlador.php?control=insertar
            $json = file_get_contents('php://input');
            // $json = '{"identificacion": "587464", "nombre": "Pablo Perez", "direccion": "Cl wallaci 24", "telefono": "123456789", "email": "pablop@egmail.com", "fo_ciudad": 1}';
            $params = json_decode($json);
            $vec = $cliente->insertarCliente($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controlador/ClienteControlador.php?control=eliminar&id=2
            $id = $_GET['id'];
            $vec = $cliente->eliminarCliente($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controlador/ClienteControlador.php?control=editar&id=3
            $json = file_get_contents('php://input');
            // $json = '{"identificacion": "2654541", "nombre": "Cliente Editado", "direccion": "Nueva Dirección", "telefono": "987654321", "email": "clienteeditado@example.com", "fo_ciudad": 2}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $cliente->editarCliente($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controlador/ClienteControlador.php?control=buscar&dato=a
            $dato = $_GET['dato'];
            $vec = $cliente->buscarCliente($dato);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
