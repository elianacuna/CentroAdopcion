<?php
// Conexion 
include_once '../../includes/conexion.php'; 

$id_adopcion = "";
$fk_id_propietario = "";
$fk_id_mascota = "";
$fk_id_empleado = "";
$fecha_adopcion = "";

$sql_propietarios = "SELECT id_propietario, nombre FROM propietario";
$result_propietarios = mysqli_query($conexion, $sql_propietarios);

$sql_mascotas = "SELECT id_mascota, nombre FROM mascota";
$result_mascotas = mysqli_query($conexion, $sql_mascotas);

$sql_empleados = "SELECT id_empleado, nombre FROM empleado";
$result_empleados = mysqli_query($conexion, $sql_empleados);

if (isset($_GET['codigo'])) {
    $id_adopcion = $_GET['codigo'];

    $sql = "SELECT fk_id_propietario, fk_id_mascota, fk_id_empleado, fecha_adopcion FROM adopcion WHERE id_adopcion = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_adopcion);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $fk_id_propietario, $fk_id_mascota, $fk_id_empleado, $fecha_adopcion);
        mysqli_stmt_fetch($stmt);  
    } else {
        echo "<script>alert('Error al obtener los datos de la adopción');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CentroAdopcion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Adopción</h2>
    
    <form action="" method="POST" novalidate>
        <!-- Propietario -->
        <div class="mb-3">
            <label for="propietario" class="form-label">Propietario</label>
            <select class="form-control" name="propietario" required>
                <option value="" disabled>Selecciona un propietario</option>
                <?php while ($propietario = mysqli_fetch_assoc($result_propietarios)) { ?>
                    <option value="<?php echo $propietario['id_propietario']; ?>" <?php echo ($propietario['id_propietario'] == $fk_id_propietario) ? 'selected' : ''; ?>>
                        <?php echo $propietario['nombre']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Mascota -->
        <div class="mb-3">
            <label for="mascota" class="form-label">Mascota</label>
            <select class="form-control" name="mascota" required>
                <option value="" disabled>Selecciona una mascota</option>
                <?php while ($mascota = mysqli_fetch_assoc($result_mascotas)) { ?>
                    <option value="<?php echo $mascota['id_mascota']; ?>" <?php echo ($mascota['id_mascota'] == $fk_id_mascota) ? 'selected' : ''; ?>>
                        <?php echo $mascota['nombre']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Empleado -->
        <div class="mb-3">
            <label for="empleado" class="form-label">Empleado</label>
            <select class="form-control" name="empleado" required>
                <option value="" disabled>Selecciona un empleado</option>
                <?php while ($empleado = mysqli_fetch_assoc($result_empleados)) { ?>
                    <option value="<?php echo $empleado['id_empleado']; ?>" <?php echo ($empleado['id_empleado'] == $fk_id_empleado) ? 'selected' : ''; ?>>
                        <?php echo $empleado['nombre']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Fecha de Adopción -->
        <div class="mb-3">
            <label for="fecha_adopcion" class="form-label">Fecha de Adopción</label>
            <input type="date" class="form-control" name="fecha_adopcion" value="<?php echo htmlspecialchars($fecha_adopcion); ?>" required>
        </div>

        <input type="hidden" name="id_adopcion" value="<?php echo $id_adopcion; ?>">

        <button type="submit" class="btn btn-primary">Actualizar Adopción</button>
        <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    actualizarAdopcion();
}

function actualizarAdopcion() {
    global $conexion;

    $id_adopcion = $_POST['id_adopcion'];
    $fk_id_propietario = $_POST['propietario'];
    $fk_id_mascota = $_POST['mascota'];
    $fk_id_empleado = $_POST['empleado'];
    $fecha_adopcion = $_POST['fecha_adopcion'];

    $sql = "UPDATE adopcion SET fk_id_propietario = ?, fk_id_mascota = ?, fk_id_empleado = ?, fecha_adopcion = ? WHERE id_adopcion = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'iiisi', $fk_id_propietario, $fk_id_mascota, $fk_id_empleado, $fecha_adopcion, $id_adopcion);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Adopción actualizada correctamente');</script>";
        header("Location: ../../index.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar la adopción');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
