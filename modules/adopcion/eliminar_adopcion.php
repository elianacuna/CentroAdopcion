<?php
// Conexion a la base de datos
include_once '../../includes/conexion.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para eliminar el cliente
    $sql = "DELETE FROM Adopcion WHERE id_adopcion = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $codigo);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Adopcion eliminado correctamente."); window.location.href = "../../index.php";</script>';
    } else {
        echo "<script>alert('Error al eliminar Adopcion');</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

header("Location: ../../index.php");
exit();
?>
