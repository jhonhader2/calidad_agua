<?php

require_once "conexion.php";
require_once "funciones.php";

$query     = "SELECT * FROM datos";
$result    = mysqli_query($con, $query);
$pos       = 0;
$etiquetas = [];
$datos     = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $muestras = [$data['muestra1'], $data['muestra2'], $data['muestra3'], $data['muestra4']];
        $promedio = promedio($muestras);
        $pos++;

        $etiquetas[] = $pos;
        $datos[]     = $promedio;
    }
}

$respuesta = [
    'etiquetas' => $etiquetas,
    'datos'     => $datos,
];

echo json_encode($respuesta);
