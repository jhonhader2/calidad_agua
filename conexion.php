<?php

$hostname   = "localhost";
$user       = "root";
$password   = null;
$database   = "calidad_agua";

try {
    $con = mysqli_connect($hostname, $user, $password, $database);
} catch (\Throwable $e) {
    print $e->getMessage();
}
