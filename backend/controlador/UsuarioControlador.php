<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    require_once("../conexion.php");
    require_once("../modelos/Usuario.php");

    $control = $_GET['control'];
    $usuario = new Usuario($conexion);

    $vec = [];

    switch ($control) {
        case 'listar':
            // http://localhost:8080/dulceton-sena/backend/controlador/UsuarioControlador.php?control=listar
            $vec = $usuario->consultarUsuarios();
            break;
        case 'insertar':
            // Inserta un nuevo usuario
            $json = file_get_contents('php://input');
            // $json = '{"usuario": "LuCorrales", "password": "123456", "email": "lucia.corral@example.com", "telefono": "21651512", "fo_tipo_usuario": 1}';
            $params = json_decode($json);
            $vec = $usuario->insertarUsuario($params);
            break;
        case 'eliminar':
            // http://localhost:8080/dulceton-sena/backend/controlador/UsuarioControlador.php?control=eliminar&id=7
            $id = $_GET['id'];
            $vec = $usuario->eliminarUsuario($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controlador/UsuarioControlador.php?control=editar&id=6
            $json = file_get_contents('php://input');
            // $json = '{"usuario": "Carmin", "password": "123456", "email": "carmin@thebear.com", "telefono": "221564154", "fo_tipo_usuario": 1}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $usuario->editarUsuario($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controlador/UsuarioControlador.php?control=buscar&dato=a
            $dato = $_GET['dato'];
            $vec = $usuario->buscarUsuario($dato);
            break;
        case 'login':
            // http://localhost:8080/dulceton-sena/backend/controlador/UsuarioControlador.php?control=login&email=armandorincon@gmail.com&password=contrasena123
            $email = $_GET['email'];
            $password = $_GET['password'];

            $vec = $usuario -> buscarUsuarioPorCorreoYClave($email, $password);
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($vec);
?>