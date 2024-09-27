<?php
// Conexion 
include_once '../../includes/conexion.php'; 

$id_empleado = "";
$nombre = "";
$cargo = "";
$telefono = "";
$correo = "";

if (isset($_GET['codigo'])) {
    $id_empleado = $_GET['codigo'];

    $sql = "SELECT nombre, cargo, telefono, correo FROM empleado WHERE id_empleado = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_empleado);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $nombre, $cargo, $telefono, $correo);
        mysqli_stmt_fetch($stmt);  
    } else {
        echo "<script>alert('Error al obtener los datos del empleado');</script>";
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
    <h2 class="text-center mb-4">Editar Empleado</h2>
    
    <form action="" method="POST" novalidate>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo htmlspecialchars($cargo); ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
        </div>
        
        <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">

        <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
        <a href="../../empleado.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    actualizarEmpleado();
}

function actualizarEmpleado() {
    global $conexion;

    $id_empleado = $_POST['id_empleado'];
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "UPDATE empleado SET nombre = ?, cargo = ?, telefono = ?, correo = ? WHERE id_empleado = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nombre, $cargo, $telefono, $correo, $id_empleado);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Empleado actualizado correctamente');</script>";
        header("Location: ../../empleado.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar el empleado');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
