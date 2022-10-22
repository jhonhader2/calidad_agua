<?php
    include_once('conexion.php');
    $id = $_GET['id'];

    $query  = "SELECT * FROM datos WHERE id = $id";
    $result = mysqli_query($con, $query);
    $data   = mysqli_fetch_assoc($result);

    //Formatea la fecha cargada desde BD
    $fecha_muestra = date_format(date_create($data['fecha_muestra']),'Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Calidad de agua</title>
</head>
<body class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                    <h2 class="pb-2 border-bottom">Editar de la medición de calidad del agua</h2>
                </div>
            </div>
        <div class="row">
            <div class="col-4">
                <h6>Ingrese los datos actualizados de las muestras... </h6>
                <form action="guardar.php" method="POST" autocomplete="off">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <fieldset disabled>
                        <div class="mb-3">
                            <label for="fecha" class="fecha">Fecha Muestra</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha_muestra; ?>" required>
                        </div>
                    </fieldset>
                    <div class="mb-3">
                        <label for="muestra1" class="form-label">Primera Muestra</label>
                        <input type="number" class="form-control" name="muestra1" id="muestra1" value="<?php echo $data['muestra1']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra2" class="form-label">Segunda Muestra</label>
                        <input type="number" class="form-control" name="muestra2" id="muestra2" value="<?php echo $data['muestra2']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra3" class="form-label">Tercera Muestra</label>
                        <input type="number" class="form-control" name="muestra3" id="muestra3" value="<?php echo $data['muestra3']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra4" class="form-label">Cuarta Muestra</label>
                        <input type="number" class="form-control" name="muestra4" id="muestra4" value="<?php echo $data['muestra4']; ?>" required>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-sm btn-outline-warning">Actualizar</button>
                        <a href="./" class="btn btn-sm btn-outline-info">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>