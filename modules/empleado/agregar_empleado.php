<?php
// Conexion
include_once '../../includes/conexion.php';
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CentroAdopcion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/empleado.css">
</head>
<body>

<header class="bg-primary text-white py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="../../empleado.php" class="btn btn-outline-light d-flex align-items-center">
            <i class="bi bi-arrow-left-circle me-2"></i> Regresar
        </a>
    </div>
</header>

<div class="container mt-5 mb-5">
    <div id="alertError" class="alert alert-danger" style="display: none;">
        <span id="textAlert"></span>
    </div>
    
    <div class="card mx-auto rounded" style="max-width: 600px;">
        <div class="card-header text-center bg-primary text-white rounded-top">
            Agregar Empleado
        </div>
        <form id="miFormulario" action="" method="POST" novalidate>
            <div class="card-body">

                <!-- Nombre -->
                <div class="col-md">
                    <label for="nombres" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombres" required>
                </div>

                <!-- Cargo -->
                <div class="col-md">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text" class="form-control" name="cargo" required>
                </div>

                <!-- Correo y teléfono -->
                <div class="row mb-3" style="margin-top: 10px;">
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="correo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Número de teléfono</label>
                        <input type="number" class="form-control" name="telefono" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Agregar Empleado</button>

            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>

function validarFormulario(event) {
    const form = document.getElementById('miFormulario');
    if (!form.checkValidity()) {
        event.preventDefault(); 
        event.stopPropagation();

        const alertError = document.getElementById('alertError');
        const textAlert = document.getElementById('textAlert');
        textAlert.textContent = 'Por favor, completa todos los campos.';
        alertError.style.display = 'block'; 
    } else {
        const alertError = document.getElementById('alertError');
        alertError.style.display = 'none';
    }
    form.classList.add('was-validated'); // Agrega clase para mostrar los estilos de validación
}
const form = document.getElementById('miFormulario');
form.addEventListener('submit', validarFormulario);
</script>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    agregarEmpleado();
}

function agregarEmpleado() {
    global $conexion;

    $nombre = $_POST['nombres'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';

    if (empty($nombre) || empty($cargo) || empty($telefono) || empty($correo)) {
        echo "<script>alert('Todos los campos son obligatorios');</script>";
        return;
    } else {

        $sql = "INSERT INTO empleado (nombre, cargo, telefono, correo) VALUES (?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("ssss", $nombre, $cargo, $telefono, $correo);

            if ($stmt->execute()) {
                echo '<script>alert("Empleado agregado correctamente."); window.location.href = "../../empleado.php";</script>';
            } else {
                echo "Error al agregar el empleado: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conexion->error;
        }
    }
}
?>
