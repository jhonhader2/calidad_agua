<?php

require_once("conexion.php");

$id = $_GET['id'];

$query  = "DELETE FROM datos WHERE id = $id";
$result = mysqli_query($con, $query) or die(mysqli_error($con));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Calidad de Agua</title>
</head>
<body class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col">
            <?php if ($result) { ?>
                    <p class="fs-4 text-success">Registro Eliminado</p>
                <?php } else { ?>
                    <p class="fs-4 text-danger">Registro no Eliminado</p>
            <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="./" class="btn btn-sm btn-outline-primary">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>