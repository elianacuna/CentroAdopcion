<?php
//Conexion
include_once 'includes/conexion.php';

//Menu
include_once 'nav-bar.php';

// Realizar la consulta a la base de datos
$sql = "SELECT id_mascota, nombre, tipo, edad, adoptado 
        FROM Mascota;";
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
  
    <div class="cardview container mt-5" style="margin-top: 20px;">
        <h2 class="text-center mb-4">Lista de Mascota</h2>
        <a type="button" href="modules/mascota/agregar_mascota.php" class="btn btn-outline-secondary">Agregar Mascota</a>

        
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Edad</th>
                    <th>Adoptado</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $fila['id_mascota'] . "</td>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['tipo'] . "</td>";
                        echo "<td>" . $fila['edad'] . "</td>";
                        echo "<td>" . $fila['adoptado'] . "</td>";
                        echo "<td>";
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $fila['id_mascota']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $fila['id_mascota']; ?>">
                                <li><a class="dropdown-item" href="modules/mascota/editar_mascota.php?codigo=<?php echo $fila['id_mascota']; ?>">Editar</a></li>
                                <li><a class="dropdown-item" href="modules/mascota/eliminar_mascota.php?codigo=<?php echo $fila['id_mascota']; ?>" onclick="return confirm('¿Estás seguro que deseas eliminar este cliente?');">Eliminar</a></li>
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

