<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once("../connection.php");
require_once("../model/Ciudad.php");

$control = $_GET['control'];
$ciudad = new Ciudad($connection);

switch ($control) {
    case 'listar':
        //http://localhost:8080/dulceton-sena/backend/controller/CiudadController.php?control=listar
        $vec = $ciudad->getCiudades();
        break;
    case 'insertar':
        //http://localhost:8080/dulceton-sena/backend/controller/CiudadController.php?control=insertar
        $json = '{"nombre": "Nueva Ciudad", "fo_dpto": 3}';
        $params = json_decode($json);
        $vec = $ciudad->postCiudad($params);
        break;
    case 'eliminar':
        //http://localhost:8080/dulceton-sena/backend/controller/CiudadController.php?control=eliminar&id=33
        $id = $_GET['id'];
        $vec = $ciudad->deleteCiudad($id);
        break;
    case 'editar':
        //http://localhost:8080/dulceton-sena/backend/controller/CiudadController.php?control=editar&id=34
        $json = '{"nombre": "Ciudad Actualizada", "fo_dpto": 4}';
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $ciudad->updateCiudad($id, $params);
        break;
    case 'buscar':
        //http://localhost:8080/dulceton-sena/backend/controller/CiudadController.php?control=buscar&dato=b
        $dato = $_GET['dato'];
        $vec = $ciudad->getCiudad($dato);
        break;
}

$datos_json = json_encode($vec);
header('Content-Type: application/json'); 
echo $datos_json;
?>

