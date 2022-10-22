<?php

function promedio($muestras)
{
    return array_sum($muestras) / count($muestras);
}

function maximo($muestras)
{
    return max($muestras);
}

function minimo($muestras)
{
    return min($muestras);
}

function evaluarRiesgo($riesgo)
{
    switch ($riesgo) {
        case $riesgo > 0 && $riesgo <= 5:
            return 'Sin Riesgo';
            break;
        case $riesgo > 5 && $riesgo <= 14:
            return 'Bajo';
            break;
        case $riesgo > 14 && $riesgo <= 35:
            return 'Medio';
            break;
        case $riesgo > 35 && $riesgo <= 80:
            return 'Alto';
            break;
        case $riesgo > 80 && $riesgo <= 100:
            return 'Inviable Sanitariamente';
            break;
        default:
            return 'No ha ingresado valores';
            break;
    }
}
