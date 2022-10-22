<?php

$hostname   = "localhost";
$user       = "root";
$password   = null;
$database   = "calidad_agua";


try {
    mysqli_connect($hostname, $user, $password, $database);
    echo "Hay Conexion";
} catch (\Throwable $e) {
    print $e->getMessage();
}
