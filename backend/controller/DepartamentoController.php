<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once("../connection.php");
require_once("../model/Departamento.php");

$control = $_GET['control'];
$departamento = new Departamento($connection);

switch ($control) {
    case 'listar':
        //http://localhost:8080/dulceton-sena/backend/controller/DepartamentoController.php?control=listar
        $vec = $departamento->getDepartamentos();
        break;
    case 'insertar':
        //http://localhost:8080/dulceton-sena/backend/controller/DepartamentoController.php?control=insertar
        $json = '{"nombre": "Nuevo Departamento"}';
        $params = json_decode($json);
        $vec = $departamento->postDepartamento($params);
        break;
    case 'eliminar':
        //http://localhost:8080/dulceton-sena/backend/controller/DepartamentoController.php?control=eliminar&id=33
        $id = $_GET['id'];
        $vec = $departamento->deleteDepartamento($id);
        break;
    case 'editar':
        //http://localhost:8080/dulceton-sena/backend/controller/DepartamentoController.php?control=editar&id=34
        $json = '{"nombre": "Departamento Actualizado"}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $departamento->updateDepartamento($id, $params);
        break;
    case 'buscar':
        //http://localhost:8080/dulceton-sena/backend/controller/DepartamentoController.php?control=buscar&dato=a
        $dato = $_GET['dato'];
        $vec = $departamento->getDepartamento($dato);
        break;
}

$datos_json = json_encode($vec);
echo $datos_json;
header('Content-Type: application/json');
?>
