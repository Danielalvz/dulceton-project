<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

require_once("../conexion.php");
require_once("../modelos/Ciudad.php");

$control = $_GET['control'];
$ciudad = new Ciudad($conexion);

switch ($control) {
    case 'listar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CiudadControlador.php?control=listar
        $vec = $ciudad->consultarCiudades();
        break;
    case 'insertar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CiudadControlador.php?control=insertar
        // $json = '{"nombre": "Nueva Ciudad", "fo_dpto": 3}';
        $params = json_decode($json);
        $vec = $ciudad->insertarCiudad($params);
        break;
    case 'eliminar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CiudadControlador.php?control=eliminar&id=33
        $id = $_GET['id'];
        $vec = $ciudad->eliminarCiudad($id);
        break;
    case 'editar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CiudadControlador.php?control=editar&id=34
        // $json = '{"nombre": "Ciudad Actualizada", "fo_dpto": 4}';
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $id = $_GET['id'];
        $vec = $ciudad->editarCiudad($id, $params);
        break;
    case 'buscar':
        //http://localhost:8080/dulceton-sena/backend/controlador/CiudadControlador.php?control=buscar&dato=b
        $dato = $_GET['dato'];
        $vec = $ciudad->buscarCiudad($dato);
        break;
}

$datos_json = json_encode($vec);
header('Content-Type: application/json'); 
echo $datos_json;
?>

