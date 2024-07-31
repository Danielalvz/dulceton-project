<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Usuario.php");

    $control = $_GET['control'];
    $usuario = new Usuario($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/UsuarioController.php?control=listar
            $vec = $usuario->getUsuarios();
            break;
        case 'insertar':
            // Inserta un nuevo usuario
            //$json = file_get_contents('php://input');
            $json = '{"usuario": "LuCorrales", "password": "123456", "email": "lucia.corral@example.com", "telefono": "21651512", "fo_tipo_usuario": 1}';
            $params = json_decode($json);
            $vec = $usuario->postUsuario($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/UsuarioController.php?control=eliminar&id=7
            $id = $_GET['id'];
            $vec = $usuario->deleteUsuario($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/UsuarioController.php?control=editar&id=6
            //$json = file_get_contents('php://input');
            $json = '{"usuario": "Carmin", "password": "123456", "email": "carmin@thebear.com", "telefono": "221564154", "fo_tipo_usuario": 1}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $usuario->updateUsuario($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/UsuarioController.php?control=buscar&dato=a
            $dato = $_GET['dato'];
            $vec = $usuario->getUsuario($dato);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
