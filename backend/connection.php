<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "dulceton";

    $connection = mysqli_connect($server, $user, $password) or die("No encontró el servidor");
    mysqli_select_db($connection, $db) or die("No encontró la base de datos");
    mysqli_set_charset($connection, "utf8");
    //echo "Se conectó correctamente"
?>