<?php

require_once "conexion.php";
require_once "funciones.php";

$query  = "SELECT * FROM datos";
$result = null;

if ($con && $dbError === null) {
    $result = mysqli_query($con, $query);
    if (!$result) {
        $dbError = "No fue posible consultar los datos de calidad de agua.";
    }
}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f5f7fb;
        }

        .section-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 0.4rem 1rem rgba(17, 24, 39, 0.08);
        }

        .table thead th {
            white-space: nowrap;
        }

        .risk-badge {
            display: inline-block;
            white-space: normal;
            text-align: center;
        }
    </style>
</head>

<body class="py-4">
    <div class="container">
        <?php if ($dbError !== null) { ?>
            <div class="alert alert-warning shadow-sm" role="alert">
                <h5 class="alert-heading mb-2">Base de datos no disponible</h5>
                <p class="mb-2"><?php echo $dbError; ?></p>
                <hr>
                <p class="mb-0">Verifique que exista la base <strong>calidad_agua</strong> y que el esquema del proyecto este correctamente desplegado. La interfaz permanece operativa, pero las funciones de listado, grafica y persistencia quedan temporalmente limitadas.</p>
            </div>
        <?php } ?>
        <div class="row mb-3">
            <div class="col-12">
                <div class="section-card card">
                    <div class="card-body py-4">
                        <h1 class="h3 mb-2">Monitoreo de calidad del agua</h1>
                        <p class="text-muted mb-0">Panel para registrar muestras IRCA, consultar historico y visualizar tendencia de riesgo.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 align-items-stretch">
            <div class="col-lg-6">
                <div class="section-card card h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Clasificacion de riesgo IRCA</h2>
                        <div>
                            <table class="table table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Clasificacion IRCA (%)</th>
                                        <th>Nivel de riesgo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>(80 - 100]</td>
                                        <td><span class="badge bg-danger risk-badge">Inviable Sanitariamente</span></td>
                                    </tr>
                                    <tr>
                                        <td>(35 - 80]</td>
                                        <td><span class="badge bg-warning text-dark risk-badge">Alto</span></td>
                                    </tr>
                                    <tr>
                                        <td>(14 - 35]</td>
                                        <td><span class="badge bg-info text-dark risk-badge">Medio</span></td>
                                    </tr>
                                    <tr>
                                        <td>(5 - 14]</td>
                                        <td><span class="badge bg-primary risk-badge">Bajo</span></td>
                                    </tr>
                                    <tr>
                                        <td>[0 - 5]</td>
                                        <td><span class="badge bg-success risk-badge">Sin Riesgo</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-card card h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Registrar muestras</h2>
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
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" <?php echo $dbError !== null ? 'disabled' : ''; ?>>Guardar medicion</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-12">
                <div class="section-card card">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Contexto</h2>
                        <p class="mb-2">
                            En el año 2015, los líderes mundiales adoptaron un conjunto de objetivos globales para erradicar la pobreza, proteger el planeta y asegurar la prosperidad para todos como parte de una nueva agenda de desarrollo sostenible. Cada objetivo tiene metas específicas que deben alcanzarse en los próximos 15 años.
                        </p>
                        <p class="mb-2">
                            El departamento del Guaviare se ha comprometido con esta causa y por ello ha decidido adoptar estos retos, se lista uno de los principales relacionados con el agua potable:
                        </p>
                        <p class="mb-2">
                            De aquí a 2030, se busca lograr el acceso universal y equitativo al agua potable a un precio asequible para todos.
                        </p>
                        <p class="mb-0">
                            Algunas ONG’s se atribuyeron la tarea de poder diseñar un dispositivo para analizar la calidad del agua de poblaciones apartadas. Para comenzar, requieren que el dispositivo cuente con un lector de la calidad del agua. Después de la lectura, el dispositivo nos entrega el índice de riesgo de la calidad del agua, IRCA, y según este resultado debe indicar el nivel de riesgo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-lg-8">
                <div class="section-card card h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Registro consolidado de muestras</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Toma #</th>
                                        <th>Fecha</th>
                                        <th>Muestra 1</th>
                                        <th>Muestra 2</th>
                                        <th>Muestra 3</th>
                                        <th>Muestra 4</th>
                                        <th>Nivel Promedio</th>
                                        <th>Riesgo Promedio</th>
                                        <th colspan="3">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $pos        = 1;
                                        $promedio   = 0;
                                        while ($data = mysqli_fetch_assoc($result)) {
                                            $muestras = [$data['muestra1'], $data['muestra2'], $data['muestra3'], $data['muestra4']];
                                            $promedio = promedio($muestras);
                                            $riesgo   = evaluarRiesgo($promedio);
                                            $fecha_muestra = date_format(date_create($data['fecha_muestra']), 'd-m-Y');
                                    ?>
                                            <tr>
                                                <td><?php echo $pos; ?></td>
                                                <td><?php echo $fecha_muestra; ?></td>
                                                <td><?php echo $data['muestra1']; ?></td>
                                                <td><?php echo $data['muestra2']; ?></td>
                                                <td><?php echo $data['muestra3']; ?></td>
                                                <td><?php echo $data['muestra4']; ?></td>
                                                <td><span class="badge bg-secondary"><?php echo $promedio; ?></span></td>
                                                <td><?php echo $riesgo; ?></td>
                                                <td><a href="editar.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-warning">Editar</a></td>
                                                <td><a href="eliminar.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-danger">Eliminar</a></td>
                                                <td><a href="imprimirReporte.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-info">Imprimir</a></td>
                                            </tr>
                                        <?php
                                            $pos++;
                                        }
                                    } elseif ($dbError !== null) { ?>
                                        <tr>
                                            <td colspan="11">Sin conexion de base de datos</td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="11">No hay datos registrados aun</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-card card h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Riesgo promedio acumulado</h2>
                        <canvas id="grafica"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($dbError === null) { ?>
        <script type="text/javascript" src="./js/script.js"></script>
    <?php } ?>
</body>

</html>
