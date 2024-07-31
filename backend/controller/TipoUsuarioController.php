<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/TipoUsuario.php");

    $control = $_GET['control'];
    $tipoUsuario = new TipoUsuario($connection);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controller/TipoUsuarioController.php?control=listar
            $vec = $tipoUsuario->getTipoUsuarios();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controller/TipoUsuarioController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"cargo": "Practicante"}';
            $params = json_decode($json);
            $vec = $tipoUsuario->postTipoUsuario($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controller/TipoUsuarioController.php?control=eliminar&id=5
            $id = $_GET['id'];
            $vec = $tipoUsuario->deleteTipoUsuario($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/TipoUsuarioController.php?control=editar&id=5
            //$json = file_get_contents('php://input');
            $json = '{"cargo": "Usuario Editado"}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $tipoUsuario->updateTipoUsuario($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/TipoUsuarioController.php?control=buscar&dato=ad
            $dato = $_GET['dato'];
            $vec = $tipoUsuario->getTipoUsuario($dato);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
