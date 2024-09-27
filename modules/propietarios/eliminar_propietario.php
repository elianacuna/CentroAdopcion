<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para eliminar el cliente
    $sql = "DELETE FROM Propietario WHERE id_propietario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("propietario eliminado correctamente."); window.location.href = "../../propietario.php";</script>';
    } else {
        echo "<script>alert('Error al eliminar propietario');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

header("Location: ../../propietario.php");
exit();
?>
