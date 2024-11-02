<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

    require_once ("../conexion.php");
    require_once ("../modelos/TipoUsuario.php");

    $control = $_GET['control'];
    $tipoUsuario = new TipoUsuario($conexion);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controlador/TipoUsuarioControlador.php?control=listar
            $vec = $tipoUsuario->consultarTipoUsuarios();
            break;
        case 'insertar':
            // http://localhost:8080/dulceton-sena/backend/controlador/TipoUsuarioControlador.php?control=insertar
            $json = file_get_contents('php://input');
            // $json = '{"cargo": "Practicante"}';
            $params = json_decode($json);
            $vec = $tipoUsuario->insertarTipoUsuario($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controlador/TipoUsuarioControlador.php?control=eliminar&id=5
            $id = $_GET['id'];
            $vec = $tipoUsuario->eliminarTipoUsuario($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controlador/TipoUsuarioControlador.php?control=editar&id=5
            $json = file_get_contents('php://input');
            // $json = '{"cargo": "Usuario Editado"}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $tipoUsuario->editarTipoUsuario($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controlador/TipoUsuarioControlador.php?control=buscar&dato=ad
            $dato = $_GET['dato'];
            $vec = $tipoUsuario->buscarTipoUsuario($dato);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>
