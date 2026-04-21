<?php

function promedio($muestras)
{
    return array_sum($muestras) / count($muestras);
}

function evaluarRiesgo($riesgo)
{
    $resultado = 'No ha ingresado valores';

    if ($riesgo > 0 && $riesgo <= 5) {
        $resultado = 'Sin Riesgo';
    } elseif ($riesgo > 5 && $riesgo <= 14) {
        $resultado = 'Bajo';
    } elseif ($riesgo > 14 && $riesgo <= 35) {
        $resultado = 'Medio';
    } elseif ($riesgo > 35 && $riesgo <= 80) {
        $resultado = 'Alto';
    } elseif ($riesgo > 80 && $riesgo <= 100) {
        $resultado = 'Inviable Sanitariamente';
    }

    return $resultado;
}
