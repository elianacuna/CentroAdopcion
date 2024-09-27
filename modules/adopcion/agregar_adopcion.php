<?php
// Conexion
include_once '../../includes/conexion.php';

$sql_propietarios = "SELECT id_propietario, nombre FROM propietario";
$result_propietarios = mysqli_query($conexion, $sql_propietarios);

$sql_mascotas = "SELECT id_mascota, nombre FROM mascota";
$result_mascotas = mysqli_query($conexion, $sql_mascotas);

$sql_empleados = "SELECT id_empleado, nombre FROM empleado";
$result_empleados = mysqli_query($conexion, $sql_empleados);
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

<header class="bg-primary text-white py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="../../index.php" class="btn btn-outline-light d-flex align-items-center">
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
            Agregar Adopción
        </div>
        <form id="miFormulario" action="" method="POST" novalidate>
            <div class="card-body">

                <!-- Propietario -->
                <div class="mb-3">
                    <label for="propietario" class="form-label">Propietario</label>
                    <select class="form-control" name="propietario" required>
                        <option value="" disabled selected>Selecciona un propietario</option>
                        <?php while ($propietario = mysqli_fetch_assoc($result_propietarios)) { ?>
                            <option value="<?php echo $propietario['id_propietario']; ?>"><?php echo $propietario['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Mascota -->
                <div class="mb-3">
                    <label for="mascota" class="form-label">Mascota</label>
                    <select class="form-control" name="mascota" required>
                        <option value="" disabled selected>Selecciona una mascota</option>
                        <?php while ($mascota = mysqli_fetch_assoc($result_mascotas)) { ?>
                            <option value="<?php echo $mascota['id_mascota']; ?>"><?php echo $mascota['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Empleado -->
                <div class="mb-3">
                    <label for="empleado" class="form-label">Empleado</label>
                    <select class="form-control" name="empleado" required>
                        <option value="" disabled selected>Selecciona un empleado</option>
                        <?php while ($empleado = mysqli_fetch_assoc($result_empleados)) { ?>
                            <option value="<?php echo $empleado['id_empleado']; ?>"><?php echo $empleado['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Fecha de Adopción -->
                <div class="mb-3">
                    <label for="fecha_adopcion" class="form-label">Fecha de Adopción</label>
                    <input type="date" class="form-control" name="fecha_adopcion" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Agregar Adopción</button>

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
    form.classList.add('was-validated');
}
const form = document.getElementById('miFormulario');
form.addEventListener('submit', validarFormulario);
</script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    agregarAdopcion();
}

function agregarAdopcion() {
    global $conexion;

    $fk_id_propietario = $_POST['propietario'] ?? '';
    $fk_id_mascota = $_POST['mascota'] ?? '';
    $fk_id_empleado = $_POST['empleado'] ?? '';
    $fecha_adopcion = $_POST['fecha_adopcion'] ?? '';

    if (empty($fk_id_propietario) || empty($fk_id_mascota) || empty($fk_id_empleado) || empty($fecha_adopcion)) {
        echo "<script>alert('Todos los campos son obligatorios');</script>";
        return;
    } else {

        $sql = "INSERT INTO adopcion (fk_id_propietario, fk_id_mascota, fk_id_empleado, fecha_adopcion) VALUES (?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("iiis", $fk_id_propietario, $fk_id_mascota, $fk_id_empleado, $fecha_adopcion);

            if ($stmt->execute()) {
                echo '<script>alert("Adopción agregada correctamente."); window.location.href = "../../index.php";</script>';
            } else {
                echo "Error al agregar la adopción: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conexion->error;
        }
    }
}
?>
