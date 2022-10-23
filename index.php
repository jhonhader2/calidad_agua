<?php

    require_once("conexion.php");
    require_once("funciones.php");
    
    $query  = "SELECT * FROM datos";
    $result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calidad de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body class="mt-3">
    <div class="container">
        <div class="row">
            <h2 class="pb-2 border-bottom">Lector del nivel de la calidad del agua en el Departamento del Guaviare.</h2>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="row">
                    <div class="col">
                        <p class="">
                            En el año 2015, los líderes mundiales adoptaron un conjunto de objetivos globales para erradicar la pobreza, proteger el planeta y asegurar la prosperidad para todos como parte de una nueva agenda de desarrollo sostenible. Cada objetivo tiene metas específicas que deben alcanzarse en los próximos 15 años.
                        </p>
                        <p>
                            El departamento del Guaviare se ha comprometido con esta causa y por ello ha decidido adoptar estos retos, se lista uno de los principales relacionados con el agua potable:
                        </p>
                        <p>
                            De aquí a 2030, se busca lograr el acceso universal y equitativo al agua potable a un precio asequible para todos.
                        </p>
                        <p>
                            Algunas ONG’s se atribuyeron la tarea de poder diseñar un dispositivo para analizar la calidad del agua de poblaciones apartadas. Para comenzar, requieren que el dispositivo cuente con un lector de la calidad del agua. Después de la lectura, el dispositivo nos entrega el índice de riesgo de la calidad del agua, IRCA, y según este resultado debe indicar el nivel de riesgo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <h4>Tabla de Clasificación</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Clasificación IRCA (%)</th>
                            <th>Nivel de riesgo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>(80 - 100]</td>
                            <td>Inviable Sanitariamente</td>
                        </tr>
                        <tr>
                            <td>(35 - 80]</td>
                            <td>Alto</td>
                        </tr>
                        <tr>
                            <td>(14 - 35]</td>
                            <td>Medio</td>
                        </tr>
                        <tr>
                            <td>(5 - 14]</td>
                            <td>Bajo</td>
                        </tr>
                        <tr>
                            <td>[0 - 5]</td>
                            <td>Sin Riesgo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-3">
                <h6>Ingrese los datos de las muestras...</h6>
                <form action="guardar.php" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="muestra1" class="form-label">Primera Muestra</label>
                        <input type="number" class="form-control" name="muestra1" id="muestra1" min="1" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra2" class="form-label">Segunda Muestra</label>
                        <input type="number" class="form-control" name="muestra2" id="muestra2" min="1" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra3" class="form-label">Tercera Muestra</label>
                        <input type="number" class="form-control" name="muestra3" id="muestra3" min="1" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="muestra4" class="form-label">Cuarta Muestra</label>
                        <input type="number" class="form-control" name="muestra4" id="muestra4" min="1" max="100" required>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <td>Toma #</td>
                            <td>Fecha</td>
                            <td>Muestra 1</td>
                            <td>Muestra 2</td>
                            <td>Muestra 3</td>
                            <td>Muestra 4</td>
                            <td>Nivel Promedio</td>
                            <td>Riesgo Promedio</td>
                            <td colspan="2">Opciones</td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                            if (mysqli_num_rows($result) > 0) {
                                $pos = 1;
                                $promedio = 0;
                                while($data = mysqli_fetch_assoc($result)) {

                                    $muestras = [$data['muestra1'] , $data['muestra2'] , $data['muestra3'] , $data['muestra4']];
                                    $promedio = promedio($muestras);
                                    $riesgo   = evaluarRiesgo($promedio)
                        ?>
                        <tr>
                            <td><?php echo $pos; ?></td>
                            <td><?php echo $data['fecha_muestra']; ?></td>
                            <td><?php echo $data['muestra1']; ?></td>
                            <td><?php echo $data['muestra2']; ?></td>
                            <td><?php echo $data['muestra3']; ?></td>
                            <td><?php echo $data['muestra4']; ?></td>
                            <td><?php echo $promedio; ?></td>
                            <td><?php echo $riesgo; ?></td>
                            
                            <td><a href="editar.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-warning" >Editar</a></td>
                            <td><a href="eliminar.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-danger" value="">Eliminar</a></td>
                        </tr>
                        <?php   $pos++;}} else { ?>
                            <tr>
                                <td colspan="9">No hay datos</td>
                            </tr>
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>