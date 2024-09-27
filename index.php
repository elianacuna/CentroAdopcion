<?php
// Conexion
include_once 'includes/conexion.php';

// Menu
include_once 'nav-bar.php';

// Realizar la consulta a la base de datos con INNER JOIN
$sql = "SELECT 
            adopcion.id_adopcion,
            propietario.nombre AS nombre_propietario,
            mascota.nombre AS nombre_mascota,
            empleado.nombre AS nombre_empleado,
            adopcion.fecha_adopcion
        FROM 
            adopcion
        INNER JOIN propietario ON adopcion.fk_id_propietario = propietario.id_propietario
        INNER JOIN mascota ON adopcion.fk_id_mascota = mascota.id_mascota
        INNER JOIN empleado ON adopcion.fk_id_empleado = empleado.id_empleado";

$resultado = mysqli_query($conexion, $sql); 
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CentroAdopcion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/propietario.css">
</head>
<body>

<div class="cardview container mt-5">
    <h2 class="text-center mb-4">Lista de Adopciones</h2>
    <a type="button" href="modules/adopcion/agregar_adopcion.php" class="btn btn-outline-secondary">Agregar Adopción</a>
    
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID Adopción</th>
                <th>Propietario</th>
                <th>Mascota</th>
                <th>Empleado</th>
                <th>Fecha de Adopción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id_adopcion'] . "</td>";
                    echo "<td>" . $fila['nombre_propietario'] . "</td>";
                    echo "<td>" . $fila['nombre_mascota'] . "</td>";
                    echo "<td>" . $fila['nombre_empleado'] . "</td>";
                    echo "<td>" . $fila['fecha_adopcion'] . "</td>";
                    echo "<td>";
                    ?>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $fila['id_adopcion']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $fila['id_adopcion']; ?>">
                            <li><a class="dropdown-item" href="modules/adopcion/editar_adopcion.php?codigo=<?php echo $fila['id_adopcion']; ?>">Editar</a></li>
                            <li><a class="dropdown-item" href="modules/adopcion/eliminar_adopcion.php?codigo=<?php echo $fila['id_adopcion']; ?>" onclick="return confirm('¿Estás seguro que deseas eliminar esta adopción?');">Eliminar</a></li>
                        </ul>
                    </div>
                    <?php
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay datos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
</body>
</html>

<?php
mysqli_close($conexion);
?>
