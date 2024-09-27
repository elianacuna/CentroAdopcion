<?php

// Conexion
include_once '../../includes/conexion.php'; 

$id_mascota = "";
$nombre = "";
$tipo = "";
$edad = "";
$adoptado = "";

if (isset($_GET['codigo'])) {
    $id_mascota = $_GET['codigo'];

    $sql = "SELECT nombre, tipo, edad, adoptado FROM Mascota WHERE id_mascota = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_mascota);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $nombre, $tipo, $edad, $adoptado);
        mysqli_stmt_fetch($stmt);  
    } else {
        echo "<script>alert('Error al obtener los datos de la mascota');</script>";
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
    <h2 class="text-center mb-4">Editar Mascota</h2>
    
    <form action="" method="POST" novalidate>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>" required>
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo htmlspecialchars($edad); ?>" required>
        </div>
        <div class="mb-3">
            <label for="adoptado" class="form-label">Adoptado</label>
            <select class="form-control" name="adoptado" id="adoptado" required>
                <option value="" disabled>Selecciona una opción</option>
                <option value="Sí" <?php if ($adoptado == "Sí") echo "selected"; ?>>Sí</option>
                <option value="No" <?php if ($adoptado == "No") echo "selected"; ?>>No</option>
            </select>
        </div>
        
        <input type="hidden" name="id_mascota" value="<?php echo $id_mascota; ?>">

        <button type="submit" class="btn btn-primary">Actualizar Mascota</button>
        <a href="../../mascota.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    actualizarMascota();
}

function actualizarMascota() {
    global $conexion;

    $id_mascota = $_POST['id_mascota'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $edad = $_POST['edad'];
    $adoptado = $_POST['adoptado'];

    $sql = "UPDATE Mascota SET nombre = ?, tipo = ?, edad = ?, adoptado = ? WHERE id_mascota = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nombre, $tipo, $edad, $adoptado, $id_mascota);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Mascota actualizada correctamente');</script>";
        header("Location: ../../mascota.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar la mascota');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
