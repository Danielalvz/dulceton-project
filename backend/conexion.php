<?php
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "dulceton";

    $conexion = mysqli_connect($servidor, $usuario, $clave) or die("No encontró el servidor");
    mysqli_select_db($conexion, $bd) or die("No encontró la base de datos");
    mysqli_set_charset($conexion, "utf8");
    //echo "Se conectó correctamente"
?>



