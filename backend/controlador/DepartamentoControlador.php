<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

require_once("../conexion.php");
require_once("../modelos/Departamento.php");

$control = $_GET['control'];
$departamento = new Departamento($conexion);

switch ($control) {
    case 'listar':
        //http://localhost:8080/dulceton-sena/backend/controlador/DepartamentoControlador.php?control=listar
        $vec = $departamento->consultarDepartamentos();
        break;
    case 'insertar':
        //http://localhost:8080/dulceton-sena/backend/controlador/DepartamentoControlador.php?control=insertar
        $json = file_get_contents('php://input');
        // $json = '{"nombre": "Nuevo Departamento"}';
        $params = json_decode($json);
        $vec = $departamento->insertarDepartamento($params);
        break;
    case 'eliminar':
        //http://localhost:8080/dulceton-sena/backend/controlador/DepartamentoControlador.php?control=eliminar&id=33
        $id = $_GET['id'];
        $vec = $departamento->eliminarDepartamento($id);
        break;
    case 'editar':
        //http://localhost:8080/dulceton-sena/backend/controlador/DepartamentoControlador.php?control=editar&id=34
        // $json = '{"nombre": "Departamento Actualizado"}';
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $departamento->editarDepartamento($id, $params);
        break;
    case 'buscar':
        //http://localhost:8080/dulceton-sena/backend/controlador/DepartamentoControlador.php?control=buscar&dato=a
        $dato = $_GET['dato'];
        $vec = $departamento->buscarDepartamento($dato);
        break;
}

$datos_json = json_encode($vec);
echo $datos_json;
header('Content-Type: application/json');
?>
