<?php

date_default_timezone_set("America/Bogota");

$hostname   = "localhost";
$user       = "root";
$password   = null;
$database   = "calidad_agua";
$con        = null;
$dbError    = null;

mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect($hostname, $user, $password);

if (!$con) {
    $dbError = "No fue posible conectar con el servidor de base de datos.";
} elseif (!mysqli_select_db($con, $database)) {
    $dbError = "La base de datos configurada no existe o no esta disponible.";
} elseif (!mysqli_query($con, "SET time_zone = '-05:00'")) {
    $dbError = "No fue posible configurar la zona horaria de la base de datos.";
}
