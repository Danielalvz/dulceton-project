<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once ("../connection.php");
    require_once ("../model/Categoria.php");

    $control = $_GET['control'];

    $categoria = new Categoria($connection);
    switch ($control) {
        case 'listar':
            //http://localhost:8080/dulceton-sena/backend/controller/CategoriaController.php?control=listar
            $vec = $categoria->getCategorias();
            break;
        case 'insertar':
            //http://localhost:8080/dulceton-sena/backend/controller/CategoriaController.php?control=insertar
            //$json = file_get_contents('php://input');
            $json = '{"nombre": "Prueba Categoria 3"}';
            $params = json_decode($json); //convierte en vector
            //print_r($params);

            $vec = $categoria->postCategoria($params);
            break;
        case 'eliminar': //http://localhost:8080/dulceton-sena/backend/controller/CategoriaController.php?control=eliminar&id=10
            $id = $_GET['id'];
            $vec = $categoria -> deleteCategoria($id);
            break;
        case 'editar':
            // http://localhost:8080/dulceton-sena/backend/controller/CategoriaController.php?control=editar&id=12
            //$json = file_get_contents('php://input');
            $json = '{"nombre": "Prueba Categoria 3312"}';
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $categoria -> updateCategoria($id, $params);
            break;
        case 'buscar':
            // http://localhost:8080/dulceton-sena/backend/controller/CategoriaController.php?control=buscar&dato=combo
            $dato = $_GET['dato'];
            $vec = $categoria -> getCategoria($dato);
    }

    $datos_json = json_encode($vec);
    echo $datos_json;
    header('Content-Type: application/json');
?>