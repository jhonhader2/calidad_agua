<?php

require_once("conexion.php");
require_once("funciones.php");

$query  = "SELECT * FROM datos";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $pos        = 0;
    $etiquetas  = [];
    $datos      = [];

    while ($data = mysqli_fetch_assoc($result)) {
        $muestras = [$data['muestra1'], $data['muestra2'], $data['muestra3'], $data['muestra4']];
        $promedio = promedio($muestras);
        $pos++;
        array_push($etiquetas, $pos);
        array_push($datos, $promedio);
        $respuesta = [
            'etiquetas' => $etiquetas,
            'datos'     => $datos,
        ];

        $respuesta = json_encode($respuesta);
    }

    echo $respuesta;
}
