<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para eliminar el cliente
    $sql = "DELETE FROM Mascota WHERE id_mascota = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Mascota eliminado correctamente."); window.location.href = "../../mascota.php";</script>';
    } else {
        echo "<script>alert('Error al eliminar Mascota');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

header("Location: ../../mascota.php");
exit();
?>
