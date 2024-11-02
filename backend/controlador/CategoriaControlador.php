<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Incluye el método PUT
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permite los encabezados necesarios

require_once("../conexion.php");
require_once("../modelos/Categoria.php");

$control = $_GET['control'];

$categoria = new Categoria($conexion);
switch ($control) {
    case 'listar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CategoriaControlador.php?control=listar
        $vec = $categoria->consultarCategorias();
        break;
    case 'insertar':
        http://localhost:8080/dulceton-sena/backend/controlador/CategoriaControlador.php?control=insertar
        $json = file_get_contents('php://input');
        // $json = '{"nombre": "Prueba Categoria 3"}';
        $params = json_decode($json); //convierte en vector
        //print_r($params);

        $vec = $categoria->insertarCategoria($params);
        break;
    case 'eliminar': //http://localhost:8080/dulceton-sena/backend/controlador/CategoriaControlador.php?control=eliminar&id=10
        $id = $_GET['id'];
        $vec = $categoria->eliminarCategoria($id);
        break;
    case 'editar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CategoriaControlador.php?control=editar&id=12
        $json = file_get_contents('php://input');
        // $json = '{"nombre": "Prueba Categoria 3312"}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $categoria->editarCategoria($id, $params);
        break;
    case 'buscar':
        // http://localhost:8080/dulceton-sena/backend/controlador/CategoriaControlador.php?control=buscar&dato=combo
        $dato = $_GET['dato'];
        $vec = $categoria->buscarCategoria($dato);
}

$datos_json = json_encode($vec);
echo $datos_json;
header('Content-Type: application/json');
?>